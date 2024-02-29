<?php

namespace App\Http\Services;
use Exception;

class FitbitConnection{

        public static function getToken($request_url, $client_id, $client_secret, $code, $redirect_uri){

        // base64 encode the client_id and client_secret
        $auth = base64_encode("{$client_id}:{$client_secret}");
        // urlencode the redirect_url
        $redirect_uri = urlencode($redirect_uri);
        $request_url .= "?client_id={$client_id}&grant_type=authorization_code&redirect_uri={$redirect_uri}&code={$code}";

        // Set the headers
        $headers = [
        "Authorization: Basic {$auth}",
        "Content-Type: application/x-www-form-urlencoded",
        ];

        // Initiate curl session
        $ch = curl_init();
        // Set headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // Options (see: http://php.net/manual/en/function.curl-setopt.php)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        // Execute the curl request and get the response
        $response = curl_exec($ch);

        // Throw an exception if there was an error with curl
        if($response === false){
        throw new Exception(curl_error($ch), curl_errno($ch));
        }

        // Get the body of the response
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $responseBody = substr($response, $header_size);
        // Close curl session
        curl_close($ch);

        // Return response body
        return $responseBody;

        }
    }
?>