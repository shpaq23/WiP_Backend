<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/16/2019
 * Time: 5:07 PM
 */

namespace App\Http\Requests\Auth;


use App\Http\Requests\Request;
use App\Rules\IsUserActive;

class ResetPasswordStep2 extends Request
{

    public function messages(): array
    {
        return [
            'token.exists' => 'No User of given token.'
        ];
    }

    public function rules(): array
    {
        return [
            'password' => 'required|confirmed|min:8',
            'token' => ['required', 'exists:users', new IsUserActive]
        ];
    }
}