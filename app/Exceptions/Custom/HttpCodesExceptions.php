<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/14/2019
 * Time: 6:47 PM
 */

namespace App\Exceptions\Custom;
use App\Http\Requests\Outputs;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class HttpCodesExceptions
{
    use Outputs;

    private $availables = [
        404 => 'notFound',
        403 => 'forbidden',
        400 => 'badRequest',
        401 => 'unauthorized',
        406 => 'notAcceptable',
        504 => 'gatewayTimeout',
        415 => 'unsupportedType',
        503 => 'serviceUnavailable',
        500 => 'internalServerError'
    ];


    public function check($exception)
    {
        $code = $this->getExceptionHTTPStatusCode($exception);
        $message = $this->getExceptionHTTPMessage($exception);


        $message = json_decode($message, true)['data'];


        $this->checkIsCodeSystemError($code, $exception->getMessage());

        return array_key_exists($code, $this->availables)?
            response()->json($this->{$this->availables[$code]}(($code == 406 || $code == 415 || $code == 503)? $message : $code), $code)
            :
            false;
    }


    public function getExceptionHTTPStatusCode($exception)
    {
        return
            $exception->getCode() > 0 ? $exception->getCode() :
                (method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500);
    }


    protected function checkIsCodeSystemError($code, $message = ''): void
    {
        if(!array_key_exists($code, $this->availables)) {
            Log::error($message);
            \Exceptions::throwSystemError();
        }
    }


    protected function getExceptionHTTPMessage($exception)
    {
        return method_exists($exception, 'getMessage') ? $exception->getMessage() : '';
    }
}