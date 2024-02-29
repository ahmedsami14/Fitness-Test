<?php

namespace App\Http\Api\Controllers\Auth;

use App\Http\Api\ApiResponses\OkResponse;
use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\RegisterRequest;
use App\Models\User;
use Ichtrojan\Otp\Otp;
use App\Mail\MailSender;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return new OkResponse([], 'Register page');
    }

    // function to store user data in session and send OTP
    public function store(RegisterRequest $request)
    {
        $op = new Otp();
        $otp = $op->generate($request->email,'numeric', 4, 2);
        User::create($request->validated());
        $data = [
            'identifier' => $request->email,
        ];
        $message = $otp->token;
        Mail::to($request->email)->send(new MailSender($message));

        return new OkResponse($data, 'OTP sent successfully');
    }
}