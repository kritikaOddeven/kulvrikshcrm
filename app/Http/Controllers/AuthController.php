<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use DB;
use Hash;
use Mail;
use Validator;
use Str;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                Auth::logout();
                return redirect('/login')->withErrors([
                    'email' => 'Unauthorized access for non-admin users.',
                ]);
            }

            $request->session()->regenerate();
            return redirect('admin/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);

    }

    public function logout()
    {
        log_activity('Auth', 'logout', Auth::user()->name . ' was logged out.');
        Auth::logout();
        return redirect('/login');
    }

     public function forgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        
        $token = Str::random(64);
        // dd($token);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request['email']],
            ['token' => $token, 'created_at' => now()]
        );
        // dd($request->all());

        Mail::send('emails.auth.password-reset-web', ['token' => $token, 'email' => $request['email']], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    public function resetPasswordForm($token)
    {
        $email = DB::table('password_reset_tokens')->where('token', $token)->value('email');
        
        if (!$email) {
            return redirect('/login')->with('error', 'Invalid password reset link.');
        }
        
        return view('admin.auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            // 'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password',
        ]);
        // dd($request->all());
        $updatePassword = DB::table('password_reset_tokens')
        ->where([
            'email' => $request->email,
            'token' => $request->token,
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('failed', 'Invalid token!');
        }

        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        return redirect('/login')->with('success', 'Your password has been changed!');
    }

    public function checkStatus()
    {
        $user = Auth::user();
        return response()->json([
            'status' => $user->status === 'active' ? 'active' : 'inactive'
        ]);
    }
}
