<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/16/2019
 * Time: 8:41 PM
 */

namespace App\Http\Requests\Auth;


use App\Http\Requests\Request;
use App\Rules\IsUserInactive;

class Reactivate extends Request
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
            'email' => ['required','exists:users', new IsUserInactive()],
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['email'] = $this->route('email');
        return $data;
    }
}