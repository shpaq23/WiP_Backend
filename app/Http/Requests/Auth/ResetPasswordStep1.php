<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/16/2019
 * Time: 8:53 PM
 */

namespace App\Http\Requests\Auth;


use App\Http\Requests\Request;
use App\Rules\IsUserActive;

class ResetPasswordStep1 extends Request
{
    public function messages(): array
    {
        return [
            'email.exists' => 'No User of given email.'
        ];
    }

    public function rules(): array
    {

        return [
            'email' => ['required', 'exists:users', new IsUserActive],
        ];
    }


    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['email'] = $this->route('email');
        return $data;
    }
}