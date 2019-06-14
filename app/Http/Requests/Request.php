<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/14/2019
 * Time: 7:09 PM
 */

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

abstract class Request extends FormRequest
{
    use Outputs;


    public function failedValidation(Validator $validator)
    {
        abort(\Illuminate\Http\Response::HTTP_NOT_ACCEPTABLE, json_encode($this->notAcceptable($validator->getMessageBag()->getMessages())));
    }
}