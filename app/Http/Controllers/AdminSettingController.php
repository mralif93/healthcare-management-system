<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        // Ensure some default settings exist if none found
        if (Setting::count() === 0) {
            $this->seedDefaults();
        }

        $settings = Setting::all()->groupBy('group');
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    private function seedDefaults()
    {
        $defaults = [
            ['key' => 'app_name', 'value' => 'Healthcare MS', 'group' => 'general', 'label' => 'Application Name', 'type' => 'text'],
            ['key' => 'app_email', 'value' => 'admin@healthcare.com', 'group' => 'general', 'label' => 'Contact Email', 'type' => 'text'],
            ['key' => 'clinic_address', 'value' => '123 Medical St, Health City', 'group' => 'general', 'label' => 'Clinic Address', 'type' => 'textarea'],
            ['key' => 'clinic_phone', 'value' => '+123456789', 'group' => 'general', 'label' => 'Clinic Phone', 'type' => 'text'],
            ['key' => 'opening_time', 'value' => '08:00', 'group' => 'schedule', 'label' => 'Opening Time', 'type' => 'text'],
            ['key' => 'closing_time', 'value' => '20:00', 'group' => 'schedule', 'label' => 'Closing Time', 'type' => 'text'],
            ['key' => 'currency_symbol', 'value' => 'RM ', 'group' => 'general', 'label' => 'Currency Symbol', 'type' => 'text'],
        ];

        foreach ($defaults as $item) {
            Setting::create($item);
        }
    }
}