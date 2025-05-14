<?php

// app/Http/Controllers/OtpController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $otpCode = rand(100000, 999999);

        // Store OTP in DB
        Otp::create([
            'email' => $request->email,
            'otp' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send email
        Mail::to($request->email)->send(new SendOtpMail($otpCode));

        return response()->json([
            'message' => 'OTP sent successfully to ' . $request->email,
        ]);
    }
}
