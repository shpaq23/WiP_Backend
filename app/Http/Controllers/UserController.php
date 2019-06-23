<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/14/2019
 * Time: 8:01 PM
 */

namespace App\Http\Controllers;
use App\Http\Requests\User\Activate;
use App\Http\Requests\User\Delete;
use App\Http\Requests\User\Edit;
use App\Http\Requests\User\Restore;
use App\Http\Requests\User\SetAdmin;
use App\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    protected $loggedUser;
    public function __construct()
    {
        $this->loggedUser = auth()->guard('api')->user();
    }
//    public function test()
//    {
//        $user = User::all()[0];
//        return new ResetPassword($user);
//    }

    public function users()
    {
        $this->success(array_map(function(User $user){return $user->getPretty(true);}, iterator_to_array(User::all())));
        return $this->output();
    }
    public function user()
    {
        $this->success($this->loggedUser->getPretty($this->loggedUser->isAdmin()));
        return $this->output();
    }
    public function edit(Edit $request)
    {
        if (!$this->loggedUser->isAdmin() && $this->loggedUser->uuid !== $request->uuid) {
            $this->notAcceptable(['Only Admin can edit another user.']);
            return $this->output();
        }
        $user = User::updateUser($request);
        $this->success($user->getPretty($this->loggedUser->isAdmin()));
        return $this->output();
    }
    public function setAdmin(SetAdmin $request)
    {
        $user = User::getUserByUuid($request->uuid, null,true);
        $user->setAdmin();
        $this->success($user->getPretty(true));
        return $this->output();

    }
    public function activate(Activate $request)
    {
        $user = User::getUserByUuid($request->uuid, null, true);
        $user->activate(true);
        $this->success($user->getPretty(true));
        return $this->output();
    }
    public function restore(Restore $request)
    {
        $user = User::getUserByUuid($request->uuid, null, true);
        $user->restore();
        $this->success($user->getPretty(true));
        return $this->output();
    }
    public function delete(Delete $request)
    {
        $user = User::getUserByUuid($request->uuid, null,true);
        $user->delete();
        $this->success($user->getPretty(true));
        return $this->output();
    }
    public function logo(String $name)
    {
        $file_path = "public/logos/$name.png";
        if (!Storage::exists($file_path)) {
            abort(404);
        }
        $file = Storage::get($file_path);
        $type = Storage::mimeType($file_path);
        $response = Response::make($file, 200)->header("Content-Type", $type);

        return $response;
    }
}