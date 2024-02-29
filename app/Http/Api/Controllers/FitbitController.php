<?php

namespace App\Http\Api\Controllers;

use App\Http\Services\FitbitConnection;
use Illuminate\Http\Request;
use Exception;


class FitbitController extends Controller
{
  public function fitbitConnect(){
    $code = "1z164g5j1j2a6l4q1x6e3q0p2e5o585g";
    try{
        $token_response = FitbitConnection::getToken("https://api.fitbit.com/oauth2/token",env('FITBIT_CLIENT_ID'),env('FITBIT_CLIENT_SECRET'),$code,env('FITBIT_REDIRECT_URI'));
        echo $token_response;
    }catch(Exception $e){
        // curl error
        echo $e->getMessage();
    }
  }
}