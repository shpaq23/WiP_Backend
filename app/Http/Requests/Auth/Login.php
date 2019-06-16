<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/16/2019
 * Time: 5:48 PM
 */

namespace App\Http\Requests\Auth;


use App\Http\Requests\Request;

class Login extends Request
{


    public function rules(): array
    {
        return [
            'email' => 'required|email|string',
            'password' => 'required|string|min:8'
        ];
    }
}