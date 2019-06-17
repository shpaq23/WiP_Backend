<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/17/2019
 * Time: 9:01 PM
 */

namespace App\Http\Middleware;
use App\Http\Controllers\UserController;
use Closure;

class Admin extends UserController
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->loggedUser->position !== 'admin') {
            $this->notAcceptable(['This is admin endpoint.']);
            return $this->output();
        }
        return $next($request);
    }
}