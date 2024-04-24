<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\PasswordResetToken;
use App\Mail\ResetPasswordMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PasswordResetController extends Controller
{
    public function showForgetPasswordForm()
    {
        return view('auth.forgetpassword');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $token = Str::random(64);
        // Session::put('token', $token);

        PasswordResetToken::updateOrCreate( 
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );

        Mail::to($user->email)->send(new ResetPasswordMail($token));

        return back()->with('message', 'Reset password link has been sent to your email.');
    }

    public function showResetPasswordForm($token)
    {   
        $passwordResetToken = PasswordResetToken::where('token', $token)->first();

        if (!$passwordResetToken || empty($passwordResetToken)) {

            return redirect()->route('forget.password.get')->with('message', 'Invalid or expired reset password token.');
        }

        // dd( (Carbon::now()->timestamp - $passwordResetToken->updated_at->timestamp)>120);
        if ( (Carbon::now()->timestamp - $passwordResetToken->updated_at->timestamp)>120) {

            return redirect()->route('forget.password.get')->with(['message', 'Invalid reset password token.']);
        }

         return view('password.newpassword', compact('token'));
        
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $passwordResetToken = PasswordResetToken::where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$passwordResetToken) {
            return redirect()->route('forget.password.get')->with('error', 'Invalid reset password token.');
        }

        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        $passwordResetToken->delete();

        return redirect('/login')->with('success', 'Your password has been reset successfully.');
    }
}
