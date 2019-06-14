<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/14/2019
 * Time: 8:17 PM
 */

namespace App\Http\Controllers;


use App\Http\Requests\Auth\Register;
use App\Http\Requests\Outputs;

class AuthController extends Controller
{
    use Outputs;

    public function register(Register $request)
    {

        try {
            $this->success();
            $this->notValidRequest();
        } catch(\Exception $e) {
            $this->throwException($e);
        }
        return $this->output();
    }
}