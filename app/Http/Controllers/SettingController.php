<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name' => \App\Models\Setting::get('app_name', 'Learning Portal'),
            'app_logo' => \App\Models\Setting::get('app_logo', 'images/tlp-logo.png'),
        ];

        return view('settings.system.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        \App\Models\Setting::set('app_name', $request->app_name);

        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('logo', 'public');
            \App\Models\Setting::set('app_logo', 'storage/' . $path);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
