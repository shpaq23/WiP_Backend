<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/16/2019
 * Time: 5:07 PM
 */

namespace App\Http\Requests\Auth;


use App\Http\Requests\Request;

class ResetPassword extends Request
{

    public function rules(): array
    {
        return [
            'password' => 'required|confirmed|min:8'
        ];
    }
}