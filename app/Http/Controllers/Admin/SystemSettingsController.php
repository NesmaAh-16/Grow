<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    public function edit()
    {
        $settings = Setting::first();
    return view('system-settings', compact('settings'));
    }

    public function update(Request $r)
    {
        $data = $r->validate([
            'site_name'         => ['required','string','max:190'],
            'official_email'    => ['required','email','max:190'],
            'default_locale'    => ['required','in:ar,en'],
            'registration_open' => ['nullable','boolean'],
        ]);

        $settings = Setting::firstOrCreate([],[]);

        $settings->update([
            'site_name'         => $data['site_name'],
            'official_email'    => $data['official_email'],
            'default_locale'    => $data['default_locale'],
            'registration_open' => (bool)($data['registration_open'] ?? 0),
        ]);

        return back()->with('ok','تم حفظ إعدادات النظام.');
    }
}
