<?php

namespace App\Http\Controllers;

use App\Models\UserSmtpSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserSmtpController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $smtpSetting = $user->smtpSetting;
        $providers = UserSmtpSetting::getProviderConfigs();
        
        return view('admin.settings.user-smtp-configuration', compact('smtpSetting', 'providers'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $existingSmtp = $user->smtpSetting;
        
        // Determine password validation rules
        $passwordRules = $existingSmtp ? 'nullable|string' : 'required|string';
        
        $validator = Validator::make($request->all(), [
            'provider' => 'required|string',
            'host' => 'required|string',
            'port' => 'required|integer|min:1|max:65535',
            'username' => 'required|email',
            'password' => $passwordRules,
            'encryption' => 'required|in:tls,ssl',
            'from_address' => 'required|email',
            'from_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $password = $request->password ?? $user->smtpSetting->password;
        
        $smtpSetting = $user->smtpSetting()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'provider' => $request->provider,
                'host' => $request->host,
                'port' => $request->port,
                'username' => $request->username,
                'password' => $password,
                'encryption' => $request->encryption,
                'from_address' => $request->from_address,
                'from_name' => $request->from_name,
                'is_active' => true,
            ]
        );

        log_activity('User SMTP Settings', 'update', "SMTP settings updated for user {$user->name}");

        return redirect()->back()->with('success', 'SMTP settings saved successfully!');
    }

    public function test(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid email address']);
        }

        $user = Auth::user();
        
        if (!$user->hasSmtpConfigured()) {
            return response()->json(['success' => false, 'message' => 'Please configure SMTP settings first']);
        }

        try {
            $smtpConfig = $user->getSmtpConfig();
            
            // Set mail config for this test
            config([
                'mail.mailers.smtp.host' => $smtpConfig['host'],
                'mail.mailers.smtp.port' => $smtpConfig['port'],
                'mail.mailers.smtp.username' => $smtpConfig['username'],
                'mail.mailers.smtp.password' => $smtpConfig['password'],
                'mail.mailers.smtp.encryption' => $smtpConfig['encryption'],
                'mail.from.address' => $smtpConfig['from_address'],
                'mail.from.name' => $smtpConfig['from_name'],
            ]);

            Mail::raw('This is a test email from your SMTP configuration.', function ($msg) use ($request) {
                $msg->to($request->test_email)->subject('SMTP Test Mail');
            });

            return response()->json(['success' => true, 'message' => 'Test email sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send test email: ' . $e->getMessage()]);
        }
    }

    public function toggle(Request $request)
    {
        $user = Auth::user();
        $smtpSetting = $user->smtpSetting;
        
        if (!$smtpSetting) {
            return response()->json(['success' => false, 'message' => 'No SMTP settings found']);
        }

        $smtpSetting->update(['is_active' => !$smtpSetting->is_active]);
        
        $status = $smtpSetting->is_active ? 'enabled' : 'disabled';
        log_activity('User SMTP Settings', 'update', "SMTP settings {$status} for user {$user->name}");

        return response()->json([
            'success' => true, 
            'message' => "SMTP settings {$status} successfully!",
            'is_active' => $smtpSetting->is_active
        ]);
    }

    public function delete()
    {
        $user = Auth::user();
        $smtpSetting = $user->smtpSetting;
        
        if ($smtpSetting) {
            $smtpSetting->delete();
            log_activity('User SMTP Settings', 'delete', "SMTP settings deleted for user {$user->name}");
        }

        return redirect()->back()->with('success', 'SMTP settings deleted successfully!');
    }
}
