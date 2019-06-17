<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/17/2019
 * Time: 8:54 PM
 */

namespace App\Http\Requests\User;


use App\Http\Requests\Request;

class Delete extends Request
{
    public function messages(): array
    {
        return [
            'uuid.exists' => 'No User of given uuid.'
        ];
    }

    public function rules(): array
    {
        return [
            'uuid' => ['required', 'uuid', 'exists:users'],
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['uuid'] = $this->route('uuid');
        return $data;
    }
}