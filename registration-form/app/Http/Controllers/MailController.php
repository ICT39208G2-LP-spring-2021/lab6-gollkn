<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class MailController extends Controller
{
    public static function sendVerificationEmail($email, $verification_code)
    {
        Mail::to($email)->send(new EmailVerification($verification_code));
    }

    public function verify()
    {
        $token = \Illuminate\Support\Facades\Request::get('token');
        $user = User::where(['remember_token' => $token])->first();
        if ($user != null) {
            $user->StatusId = 1;
            $user->save();
            return redirect()->route('register')->with(session()->flash('notification', 'Account verified'));
        }
    }

    public function showResend()
    {
        return view('mail.activate-user');
    }

    public function resend()
    {
        $attempts = session('resend-attempts');
        $email = session('email');
        $token = session('token');
        if ($attempts != 0) {
            $attempts = $attempts - 1;
            session(['resend-attempts' => $attempts]);
            MailController::sendVerificationEmail($email, $token);
            session()->flash('verification-notification', 'Verification email has been sent');
        } else {
            session()->flash('verification-notification', 'No more attempts remaining');
        }
        return redirect()->route('resend');
    }
}
