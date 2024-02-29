<?php

namespace App\Http\Api\Controllers\Auth;

use App\Http\Api\ApiResponses\CreatedResponse;
use App\Http\Api\ApiResponses\OkResponse;
use App\Http\Api\ApiResponses\UnprocessableEntityResponse;
use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\LoginRequest;
use App\Models\User;
use Ichtrojan\Otp\Otp;

class LoginController extends Controller
{

    public function index()
    {
        return new OkResponse([], 'Login page');
    }
    
    public function store(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return new UnprocessableEntityResponse([], 'User not found');
        }else{
            $op = new Otp();
            $otp = $op->generate($request->email,'numeric', 4, 2);
            $data = [
                'identifier' => $request->email,
            ];
            return new CreatedResponse($data, 'OTP sent successfully');
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        session()->flush();

        return new OkResponse([], 'User logged out successfully');
    }
}