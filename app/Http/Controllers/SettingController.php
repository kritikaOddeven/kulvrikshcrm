<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Country;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.email-configuration', compact('settings'));
    }

    public function update(Request $request)
    {
        if ($request->submit == 'smtp') {
            // Ignore token and button name
            $data = $request->except(['_token', 'submit']);

            foreach ($data as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            log_activity('Settings', 'update', "SMTP settings updated");
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    public function address(){
        $countries = Country::all();
        return view ('admin.settings.address_setting', compact('countries'));
    }

    
}
