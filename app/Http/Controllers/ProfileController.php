<?php
namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();
        // dd($user);
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $validate = $request->validate([
            'name'  => 'required',
            'email' => 'required|email|email:rfc,dns',
        ]);
        // dd($request->all());

        if (! $validate) {
            return redirect()->route('admin.profile')->with('failed', 'Something went wrong');
        }

        $user        = User::where('id', Auth::user()->id)->first();
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        // dd($user);
        $user->update();

        log_activity('Profile', 'update', "Profile updated for user: {$user->name}");

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
            try {
                $request->validate([
                    'current_password' => 'required',
                    'new_password'     => 'required|min:8',
                    'password_confirmation' => 'required|same:new_password',
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return redirect()->route('admin.profile')
                    ->withErrors($e->validator)
                    ->with('password_error', true);
            }

            $user = User::where('id', Auth::user()->id)->first();

            if (! Hash::check($request->current_password, $user->password)) {
                return redirect()->route('admin.profile')
                    ->with('error', 'Current password is incorrect')
                    ->with('password_error', true);
            }

            $user->password = Hash::make($request->new_password);
            $user->update();

            log_activity('Profile', 'update', "Password updated for user: {$user->name}");

            return redirect()->back()->with('success', 'Password updated successfully')->with('password_error', false);
       
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_image')) {
            // Delete old image if needed
            if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }

            $image     = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/admin/profile'), $imageName);

            $user->profile_image = 'assets/admin/profile/' . $imageName;
            $user->save();
        }
        log_activity('Profile', 'update', "Profile image updated for user: {$user->name}");

        return back()->with('success', 'Profile image updated successfully.');
    }

}
