<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/14/2019
 * Time: 8:01 PM
 */

namespace App\Http\Controllers;
use App\Mail\ActivateAccount;
use App\User;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function test(Request $request)
    {
        $user = User::where(['name' => 'Michał Szpak'])->first();


        return new ActivateAccount($user, 'Wiedza i Praktyka');
    }

}