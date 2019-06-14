<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/14/2019
 * Time: 7:04 PM
 */

namespace App\Exceptions\Custom;


class CustomExceptions
{
    static public function throwDataBaseError(): void
    {
        throw new \Exception(json_encode(['data' => ['database' => 'Wrong SQL syntax.']]), 406);
    }

    static public function throwNoContentError(): void
    {
        throw new \Exception(json_encode(['data' => ['database' => 'No records found.']]), 204);
    }

    static public function throwForbiddenError(): void
    {
        throw new \Exception(json_encode(['data' => ['request' => 'forbidden']]), 403);
    }
    static public function throwSystemError(): void
    {
        throw new \Exception(json_encode(['data' => ['system' => 'error']]), 503);
    }

    static public function throwError(Array $data, $code = 406): void
    {
        throw new \Exception(json_encode(['data' => $data]), $code);
    }
}