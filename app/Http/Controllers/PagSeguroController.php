<?php
/**
 * Created by PhpStorm.
 * User: jose
 * Date: 5/20/17
 * Time: 7:10 PM
 */
namespace App\Http\Controllers;

class PagSeguroController extends Controller
{
    public function getSessionId(){
        $credentials = \PagSeguroConfig::getAccountCredentials();
        return [
            'sessionId' => \PagSeguroSessionService::getSession($credentials)
        ];
    }
}