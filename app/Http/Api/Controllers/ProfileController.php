<?php

namespace App\Http\Api\Controllers;

use App\Http\Api\ApiResponses\CreatedResponse;
use App\Http\Api\ApiResponses\OkResponse;
use App\Http\Api\ApiResponses\UnprocessableEntityResponse;
use App\Http\Api\Requests\ChangeEmailRequest;
use App\Http\Api\Requests\ResendOtpChangeEmailRequest;
use App\Http\Api\Requests\UpdateProfileRequest;
use App\Http\Api\Requests\VerifyEmailOtpRequest;
use App\Http\Traits\OtpTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ichtrojan\Otp\Otp;

class ProfileController extends Controller
{
    use OtpTrait;
    
    public function viewProfile()
    {
        $data = Auth::user();
        return new OkResponse($data, 'Profile Page');
    }
    
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());
        $data = [
            'user' => $user,
            'message' => 'Profile updated successfully'
        ];
        return new OkResponse($data, 'Profile updated successfully');
    }

    public function changeEmail(ChangeEmailRequest $request)
    {
        $op = new Otp();
        $otp = $op->generate($request->email,'numeric', 4, 2);
        $data = [
            'identifier' => $request->email,
        ];
        return new CreatedResponse($data, 'OTP sent successfully');
                
    }
    public function otp()
    {
        return new OkResponse([], 'OTP change Email page');
    }


    public function verifyEmailOtp(VerifyEmailOtpRequest $request)
    {
        $op = new Otp();
        $otp = $op->validate($request->identifier, $request->token)->status;

        if (! $otp) {
            return new UnprocessableEntityResponse(
                [],
                'OTP not valid',
            );
        } else {
            $user = Auth::user();
            $user->update(['email' => $request->identifier]);
            $data = [
                'user' => $user,
                'message' => 'Email updated successfully'
            ];
            return new OkResponse($data, 'Email updated successfully');
        }    
    }

    public function resendEmailOtp(ResendOtpChangeEmailRequest $request){
        $request['identifier'] = $request->email;
        return $this->resendOtp($request);
    }
}