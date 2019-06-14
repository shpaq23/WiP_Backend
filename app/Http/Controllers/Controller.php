<?php

namespace App\Http\Controllers;

use App\Http\Requests\Outputs;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Outputs;


    /**
     * Throw custom exception.
     * @param Exception $exception
     * @return void
     */
    protected function throwException(\Exception $exception): void
    {
        $this->notAcceptable();
        $message = json_decode($exception->getMessage(), true);


        $this->response['data'] = array_key_exists('data', $message)? $message['data'] : $message;
        throw $exception;
    }

    /**
     * Prepare output.
     * @return Array
     */
    protected function output()
    {
        return response()->json($this->response);
    }

    /**
     * Throw exception.
     * @return \Exception
     */
    protected function notValidRequest()
    {
        throw new \Exception(json_encode(['data' => ['request' => 'is_not_valid']]), 406);
    }
}
