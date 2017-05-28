<?php
/**
 * Created by PhpStorm.
 * User: jose
 * Date: 5/27/17
 * Time: 7:57 PM
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $headers = [
            'Content-type' => 'application/json;charset=UTF-8',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'HEAD,GET,POST,PUT,PATCH,DELETE,OPTIONS',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400',
            'Access-Control-Allow-Headers' => $request->header('Access-Control-Request-Headers')
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }
        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }
        return $response;
    }

}