<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/14/2019
 * Time: 8:17 PM
 */

namespace App\Http\Controllers;


use App\Http\Requests\Auth\Activate;
use App\Http\Requests\Auth\Email;
use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\Reactivate;
use App\Http\Requests\Auth\ResetPasswordStep1;
use App\Http\Requests\Auth\ResetPasswordStep2;
use App\Http\Requests\Auth\Register;
use App\Http\Requests\Outputs;
use App\Mail\ResetPassword;
use Carbon\Carbon;
use App\Mail\ActivateAccount;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use Outputs;

    public function register(Register $request)
    {
        $user = User::newUser($request);
        $this->success();
        Mail::to($user)->send(new ActivateAccount($user));
        return $this->output();
    }
    public function activate(Activate $request)
    {
        $token = $request->route('token');
        (User::getUserByToken($token, false))
            ->activate();
        return redirect(env('ACTIVATE_REDIRECT').'?success=activated');
    }
    public function reactivate(Reactivate $request)
    {
        $email = $request->route('email');
        $user = (User::getUserByEmail($email, false))
            ->setNewToken();
        Mail::to($user)->send(new ActivateAccount($user));
        $this->success();
        return $this->output();
    }
    public function resetPasswordStep1(ResetPasswordStep1 $request)
    {
        $email = $request->route('email');
        $user = (User::getUserByEmail($email))
            ->setNewToken();
        Mail::to($user)->send(new ResetPassword($user));
        $this->success();
        return $this->output();
    }
    public function resetPasswordStep2(ResetPasswordStep2 $request)
    {
        (User::getUserByToken($request->token))
            ->setNewPassword($request->password);
        $this->success();
        return $this->output();
    }
    public function login(Login $request)
    {

        if (!Auth::attempt(array_merge($request->all()))) {
            $this->notAcceptable('Wrong E-mail or Password.');
            return $this->output();
        }
        $user = $request->user();
        if (!$user->active) {$this->notAcceptable('This User is inactive.'); return $this->output();}
        if ($user->deleted) {$this->notAcceptable('This User has been deleted.'); return $this->output();}
        $user->updateActivity();
        $tokenResult = $user->createToken('Personal Access Token');
        $tokenResult->token->save();
        $this->success([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);

        return $this->output();
    }
    public function logout()
    {
        $user = auth()->guard('api')->user();
        $user->logout();
        $this->success();
        return $this->output();
    }
    public function email(Email $request)
    {
        $this->success(User::where(['email' => $request->email])->first() === null);
        return $this->output();
    }

}