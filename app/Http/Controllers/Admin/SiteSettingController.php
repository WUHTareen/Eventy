<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::getAllSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'        => 'required|string|max:100',
            'site_email'       => 'required|email',
            'site_phone'       => 'nullable|string|max:20',
            'site_address'     => 'nullable|string|max:255',
            'footer_text'      => 'nullable|string|max:255',
            'facebook_url'     => 'nullable|url|max:255',
            'instagram_url'    => 'nullable|url|max:255',
            'twitter_url'      => 'nullable|url|max:255',
            'whatsapp_number'  => 'nullable|string|max:20',
            'stripe_key'       => 'nullable|string|max:255',
            'stripe_secret'    => 'nullable|string|max:255',
            'commission_rate'  => 'nullable|numeric|min:0|max:100',
            'meta_description' => 'nullable|string|max:255',
            'logo'             => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'favicon'          => 'nullable|image|mimes:png,ico|max:512',
        ]);

        $fields = [
            'site_name', 'site_email', 'site_phone', 'site_address',
            'footer_text', 'facebook_url', 'instagram_url', 'twitter_url',
            'whatsapp_number', 'stripe_key', 'stripe_secret',
            'commission_rate', 'meta_description',
        ];

        foreach ($fields as $field) {
            SiteSetting::set($field, $request->input($field));
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $old = SiteSetting::get('site_logo');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('logo')->store('settings', 'public');
            SiteSetting::set('site_logo', $path);
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $old = SiteSetting::get('site_favicon');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('favicon')->store('settings', 'public');
            SiteSetting::set('site_favicon', $path);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Site settings updated successfully!');
    }
}
