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

    protected function output()
    {
        return response()->json($this->response, $this->response['code']);
    }

}
