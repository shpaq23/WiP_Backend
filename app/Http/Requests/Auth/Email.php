<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/18/2019
 * Time: 4:19 PM
 */

namespace App\Http\Requests\Auth;


use App\Http\Requests\Request;

class Email extends Request
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['email'] = $this->route('email');
        return $data;
    }
}