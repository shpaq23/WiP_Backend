<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/16/2019
 * Time: 8:20 PM
 */

namespace App\Http\Requests\Auth;


use App\Http\Requests\Request;
use App\Rules\IsUserActive;
use App\Rules\IsUserInactive;
use App\User;

class Activate extends Request
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
            'token' => ['required','exists:users', new IsUserInactive]
        ];
    }
    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['token'] = $this->route('token');
        return $data;
    }
}