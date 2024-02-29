<?php 

namespace App\Http\Traits;

use App\Http\Api\ApiResponses\OkResponse;
use App\Http\Api\ApiResponses\UnprocessableEntityResponse;
use Carbon\Carbon;
use Ichtrojan\Otp\Models\Otp as ModelsOtp;
use Ichtrojan\Otp\Otp;
use App\Mail\MailSender;
use Illuminate\Support\Facades\Mail;

trait OtpTrait
{
    
    public function resendOtp($request)
    {
        
        $todayStart = Carbon::now()->startOfDay();
        $todayEnd = Carbon::now()->endOfDay();

        $recordCount = ModelsOtp::where('identifier', $request->identifier)
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->count();

        if ($recordCount === 5) {
            return new UnprocessableEntityResponse(
                [],
                'You have reached the maximum number of OTP requests for today',
            );
        } else {
            $lastOtp = ModelsOtp::where('identifier', $request->identifier)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($lastOtp != null && $lastOtp->created_at->diffInMinutes() < 1) {
                return new UnprocessableEntityResponse(
                    [],
                    'OTP already sent, please wait for 1 minute',
                );
            }

            $otp = (new Otp)->generate($request->identifier, 'numeric', 4, 2);

            $data = [
                'identifier' => $request->identifier,
            ];
            $message = $otp->token;
            Mail::to($request->email)->send(new MailSender($message));

            return new OkResponse($data, 'OTP sent successfully');
        }
    }
}

?>