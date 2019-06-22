<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/17/2019
 * Time: 7:34 PM
 */

namespace App\Http\Requests\User;


use App\Http\Requests\Request;

class Edit extends Request
{

    public function rules(): array
    {
        return [
            'uuid' => 'required|uuid|exists:users',
            'first_name' => 'required|string|max:40',
            'last_name' => 'required|string|max:40',
            'position' => 'required|in:tester,developer,project_manager',
            'specialization_field_1' => 'required|max:255',
            'specialization_field_2' => 'required|max:255',
            'checkbox' => 'required|boolean',
        ];
    }
}