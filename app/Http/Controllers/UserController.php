<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/14/2019
 * Time: 8:01 PM
 */

namespace App\Http\Controllers;
use App\Http\Requests\Auth\Register;
use App\Http\Requests\User\Activate;
use App\Http\Requests\User\Delete;
use App\Http\Requests\User\Edit;
use App\Http\Requests\User\Restore;
use App\Http\Requests\User\SetAdmin;
use App\Mail\ActivateAccount;
use App\Mail\ResetPassword;
use App\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    protected $loggedUser;
    public function __construct()
    {
        $this->loggedUser = auth()->guard('api')->user();
    }
    public function test()
    {
        $user = User::all()[0];
        return new ResetPassword($user);
    }

    public function user()
    {
        if ($this->loggedUser->isAdmin()) {
            $this->success(array_map(function(User $user){return $user->getPretty();}, iterator_to_array(User::all())));
        } else {
            $this->success($this->loggedUser->getPretty());
        }
        return $this->output();
    }
    public function edit(Edit $request)
    {
        if (!$this->loggedUser->isAdmin() && $this->loggedUser->uuid !== $request->uuid) {
            $this->notAcceptable(['Only Admin can edit another user.']);
            return $this->output();
        }
        $user = User::updateUser($request);
        $this->success($user->getPretty());
        return $this->output();
    }
    public function setAdmin(SetAdmin $request)
    {
        User::getUserByUuid($request->uuid)
            ->setAdmin();
        $this->success();
        return $this->output();

    }
    public function activate(Activate $request)
    {
        User::getUserByUuid($request->uuid)
            ->activate(true);
        $this->success();
        return $this->output();
    }
    public function restore(Restore $request)
    {
        User::getUserByUuid($request->uuid)
            ->restore();
        $this->success();
        return $this->output();
    }
    public function delete(Delete $request)
    {
        if (!$this->loggedUser->isAdmin() && $this->loggedUser->uuid !== $request->uuid) {
            $this->notAcceptable(['Only Admin can delete another user.']);
            return $this->output();
        }
        $user = User::getUserByUuid($request->uuid);
        $user->delete();
        $user->logout();
        $this->success();
        return $this->output();
    }
}