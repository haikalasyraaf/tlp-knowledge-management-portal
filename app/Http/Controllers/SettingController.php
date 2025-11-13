<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'guideline_document_path' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        \App\Models\Setting::set('app_name', $request->app_name);

        if ($request->hasFile('app_logo')) {
            $oldLogo = \App\Models\Setting::get('app_logo');
            if ($oldLogo && Storage::disk('public')->exists(str_replace('storage/', '', $oldLogo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $oldLogo));
            }
            $path = $request->file('app_logo')->store('logo', 'public');
            \App\Models\Setting::set('app_logo', 'storage/' . $path);
        }

        if ($request->hasFile('guideline_document_path')) {
            $oldDoc = \App\Models\Setting::get('guideline_document_path');
            if ($oldDoc && Storage::disk('public')->exists(str_replace('storage/', '', $oldDoc))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $oldDoc));
            }
            $path = $request->file('guideline_document_path')->store('login_guideline', 'public');
            \App\Models\Setting::set('guideline_document_path', 'storage/' . $path);
        }

        if ($request->hasFile('lockscreen_video_path')) {
            $oldDoc = \App\Models\Setting::get('lockscreen_video_path');
            if ($oldDoc && Storage::disk('public')->exists(str_replace('storage/', '', $oldDoc))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $oldDoc));
            }
            $path = $request->file('lockscreen_video_path')->store('lockscreen_video', 'public');
            \App\Models\Setting::set('lockscreen_video_path', 'storage/' . $path);
        }

        return back()->with('success', 'Settings updated successfully.');
    }

    public function updateTokGuideline(Request $request)
    {
        $request->validate([
            'tok_guideline' => 'nullable|string|max:255',
        ]);

        \App\Models\Setting::set('tok_guideline', $request->tok_guideline);
    }

    public function deleteLockscreenVideo()
    {
        $video = \App\Models\Setting::where('key', 'lockscreen_video_path')->value('value');

        if ($video && Storage::disk('public')->exists($video)) {
            Storage::disk('public')->delete($video);
        }

        \App\Models\Setting::where('key', 'lockscreen_video_path')->delete();

        return back()->with('success', 'Lockscreen video deleted.');
    }
}
