<?php
namespace App\Livewire;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class LoginWithOtp extends Component
{
    public $email, $password, $otp, $step = 'login', $userId;
    public $showPassword                  = false;
    public $remember                      = false;

    public function login()
    {
        if (!$this->email || !$this->password) {
            $this->addError('email', 'Email is required.');
            $this->addError('password', 'Password is required.');
            return;
        }

        $user = User::where('email', $this->email)->first();

        if (! $user || ! Hash::check($this->password, $user->password)) {
            $this->addError('email', 'Invalid credentials.');
            return;
        }
        if($user->status == 'inactive'){
            $this->addError('email', 'Your account has been deactivated. Contact admin to reactivate your access.');
            return;
        }

        // Eable this for 1 day remember account
        // if ($user->email_verified_at && $user->email_verified_at->diffInDays(now()) < 1) {
        //     session()->put('remember_me', $this->remember);
        //     sleep(2);
        //     Auth::login($user, $this->remember);
        //     log_activity('Auth', 'login', "{$user->name} logged in." );

        //     return redirect()->route('admin.dashboard');
        // }

        $generatedOtp = rand(100000, 999999);
        session([
            'otp'         => $generatedOtp,
            'otp_user_id' => $user->id,
        ]);

        // Send OTP
        Mail::to($user->email)->send(new OtpMail($generatedOtp));
        $this->step = 'otp';
        $this->dispatch('save-login-data');
    }

    public function verifyOtp()
    {
        if ($this->otp == session('otp')) {
            sleep(3);
            $user = User::find(session('otp_user_id'));
            $user->update(['email_verified_at' => now()]);
            Auth::login($user, session('remember_me', false));
            log_activity('Auth', 'login', "{$user->name} logged in." );
            session()->forget(['otp', 'otp_user_id']);
            return redirect()->route('admin.dashboard');
        }

        $this->addError('otp', 'Please enter a valid OTP.');
    }

    public function render()
    {
        return view('livewire.login-with-otp');
    }
}
