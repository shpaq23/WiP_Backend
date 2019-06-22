<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/14/2019
 * Time: 8:31 PM
 */

namespace App\Http\Requests\Auth;


use App\Http\Requests\Request;

class Register extends Request
{

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:40',
            'last_name' => 'required|string|max:40',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'position' => 'required|in:tester,developer,project_manager',
            'specialization_field_1' => 'required|max:255',
            'specialization_field_2' => 'required|max:255',
            'checkbox' => 'required|boolean',
        ];
    }

}