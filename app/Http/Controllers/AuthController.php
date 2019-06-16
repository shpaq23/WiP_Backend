<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/14/2019
 * Time: 8:17 PM
 */

namespace App\Http\Controllers;


use App\Http\Requests\Auth\ResetPassword as ResetPasswordRequest;
use App\Http\Requests\Auth\Register;
use App\Http\Requests\Outputs;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use App\Mail\ActivateAccount;
use App\User;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use Outputs;

    public function register(Register $request)
    {
        $user = User::newUser($request);
        $this->success($user);
        Mail::to($user)->send(new ActivateAccount($user));
        return $this->output();
    }
    public function activate(Request $request)
    {
        $token = $request->route('token');
        $user = User::getUserByToken($token, false);
        if ($user) {
            $user->activate();
            return redirect(env('ACTIVATE_REDIRECT'));
        }
        $this->serviceUnavailable([]);
        return $this->output();
    }
    public function reactivate(Request $request)
    {
        $email = $request->route('email');
        $user = User::getUserByEmail($email, false);
        if ($user) {
            $user = $user->setNewToken();
            Mail::to($user)->send(new ActivateAccount($user));
            $this->success();
        } else {
            $this->serviceUnavailable([]);
        }
        return $this->output();
    }
    public function resetPasswordStep1(Request $request)
    {
        $email = $request->route('email');
        $user = User::getUserByEmail($email);
        if($user) {
            $user = $user->setNewToken();
            Mail::to($user)->send(new ResetPassword($user));
            $this->success();
        } else {
            $this->serviceUnavailable([]);
        }
        return $this->output();
    }
    public function resetPasswordStep2(ResetPasswordRequest $request)
    {
        $user = User::getUserByToken($request->token);
        if ($user) {
            $user->setNewPassword($request->password);
            $this->success();
        } else {
            $this->serviceUnavailable([]);
        }
        return $this->output();
    }
}