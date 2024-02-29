<?php

namespace App\Http\Api\Controllers\Auth;

use App\Http\Api\ApiResponses\OkResponse;
use App\Http\Api\ApiResponses\UnprocessableEntityResponse;
use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\ResendOtpRequest;
use App\Http\Api\Requests\VerifyOtpLoginRequest;
use App\Http\Traits\OtpTrait;
use App\Models\User;
use Ichtrojan\Otp\Otp;


class LoginVerifyOtpController extends Controller
{
    use OtpTrait;
    
    public function otp()
    {
        return new OkResponse([], 'OTP page');
    }
    public function verifyOtp(VerifyOtpLoginRequest $request)
    {
        $op = new Otp();
        $otp = $op->validate($request->identifier, $request->token)->status;

        if (! $otp) {
            return new UnprocessableEntityResponse(
                [],
                'OTP not valid',
            );
        } else {
            $user = User::where('email', $request->identifier)->first();
            $user->auth_token = $user->createToken('authToken')->plainTextToken;
            auth()->login($user);
        }
        return new OkResponse($user, 'OTP verified and login successfully');
    }

    public function resendOtpLogin(ResendOtpRequest $request)
    {
        return $this->resendOtp($request);
    }
}