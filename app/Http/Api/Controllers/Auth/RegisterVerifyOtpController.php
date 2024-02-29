<?php

namespace App\Http\Api\Controllers\Auth;

use App\Http\Api\ApiResponses\OkResponse;
use App\Http\Api\ApiResponses\UnprocessableEntityResponse;
use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\ResendOtpRequest;
use App\Http\Api\Requests\VerifyOtpRegisterRequest;
use App\Http\Traits\OtpTrait;
use App\Models\User;
use Carbon\Carbon;
use Ichtrojan\Otp\Otp;

class RegisterVerifyOtpController extends Controller
{
    use OtpTrait;
    
    public function otp()
    {
        return new OkResponse([], 'OTP page');
    }
    
    // function to verify OTP and register user
    public function verifyOtp(VerifyOtpRegisterRequest $request)
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
            $user->update(['email_verified_at' => Carbon::now()]);
            $user->auth_token = $user->createToken('authToken')->plainTextToken;
            auth()->login($user); 
            return new OkResponse($user, 'OTP verified and register successfully');
        }

    }
    
    // function to resend OTP
    public function resendOtpRegister(ResendOtpRequest $request)
    {
        return $this->resendOtp($request);
    }
}