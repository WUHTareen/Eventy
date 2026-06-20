<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageController extends Controller
{
    /**
     * Default homepage content. Acts as the single source of truth for fallbacks,
     * so the live page never breaks when a value has not been customized yet.
     */
    public static function defaults(): array
    {
        return [
            // Hero
            'hp_hero_badge'      => 'Your Trusted Event Partner',
            'hp_hero_title_1'    => 'Plan, Book & Manage',
            'hp_hero_title_2'    => 'Events, Travel & Hospitality',
            'hp_hero_title_3'    => '— Worldwide',
            'hp_hero_subtitle'   => 'From Weddings to Corporate Conferences, From Hotels to Visa & Transport — All in One Platform',
            'hp_hero_image'      => null,

            // Featured Assets section
            'hp_featured_show'     => '1',
            'hp_featured_badge'    => 'High-Value Intelligence',
            'hp_featured_title'    => 'Featured',
            'hp_featured_title_hl' => 'Assets',
            'hp_featured_subtitle' => 'Pre-vetted elite protocols for specialized event architectures and high-stakes travel.',

            // How It Works section
            'hp_how_show'      => '1',
            'hp_how_badge'     => 'Strategic Workflow',
            'hp_how_title'     => 'Process',
            'hp_how_title_hl'  => 'Architecture',

            // Corporate CTA banner (inside How It Works)
            'hp_cta_title'     => 'Are you an',
            'hp_cta_title_hl'  => 'Organization?',
            'hp_cta_subtitle'  => 'Join our corporate ecosystem for specialized handling and bulk assets.',
            'hp_cta_btn1'      => 'Corporate Portal',
            'hp_cta_btn2'      => 'Request Briefing',

            // Testimonials section
            'hp_testi_show'      => '1',
            'hp_testi_badge'     => 'Community Intel',
            'hp_testi_title'     => 'Success',
            'hp_testi_title_hl'  => 'Metrics',
            'hp_testi_subtitle'  => 'Verified feedback from Pakistan\'s most prominent event architectures and corporate summits.',
        ];
    }

    public static function defaultSteps(): array
    {
        return [
            ['id' => '01', 'title' => 'Define Parameters', 'desc' => 'Identify target goals, logistics needs, and asset requirements.', 'icon' => 'fa-crosshairs'],
            ['id' => '02', 'title' => 'Asset Selection', 'desc' => 'Deploy pre-vetted vendors and high-fidelity service protocols.', 'icon' => 'fa-database'],
            ['id' => '03', 'title' => 'Secure Checkout', 'desc' => 'Intel-grade escrow payments and encrypted transaction seals.', 'icon' => 'fa-shield-halved'],
            ['id' => '04', 'title' => 'Live Orchestration', 'desc' => 'Real-time deployment tracking and mission command support.', 'icon' => 'fa-tower-broadcast'],
        ];
    }

    /**
     * Resolve the full homepage content (saved values merged over defaults).
     * Used by both the admin editor and the public HomeController.
     */
    public static function content(): array
    {
        $content = [];
        foreach (static::defaults() as $key => $default) {
            $content[$key] = SiteSetting::get($key, $default);
        }
        $content['hp_steps'] = SiteSetting::getJson('hp_steps', static::defaultSteps());
        return $content;
    }

    public function edit()
    {
        $hp = static::content();
        return view('admin.homepage.edit', compact('hp'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hp_hero_badge'      => 'nullable|string|max:120',
            'hp_hero_title_1'    => 'nullable|string|max:120',
            'hp_hero_title_2'    => 'nullable|string|max:120',
            'hp_hero_title_3'    => 'nullable|string|max:120',
            'hp_hero_subtitle'   => 'nullable|string|max:500',
            'hp_hero_image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',

            'hp_featured_badge'    => 'nullable|string|max:120',
            'hp_featured_title'    => 'nullable|string|max:120',
            'hp_featured_title_hl' => 'nullable|string|max:120',
            'hp_featured_subtitle' => 'nullable|string|max:500',

            'hp_how_badge'     => 'nullable|string|max:120',
            'hp_how_title'     => 'nullable|string|max:120',
            'hp_how_title_hl'  => 'nullable|string|max:120',

            'hp_cta_title'     => 'nullable|string|max:120',
            'hp_cta_title_hl'  => 'nullable|string|max:120',
            'hp_cta_subtitle'  => 'nullable|string|max:500',
            'hp_cta_btn1'      => 'nullable|string|max:60',
            'hp_cta_btn2'      => 'nullable|string|max:60',

            'hp_testi_badge'     => 'nullable|string|max:120',
            'hp_testi_title'     => 'nullable|string|max:120',
            'hp_testi_title_hl'  => 'nullable|string|max:120',
            'hp_testi_subtitle'  => 'nullable|string|max:500',

            'steps'             => 'nullable|array',
            'steps.*.id'        => 'nullable|string|max:10',
            'steps.*.title'     => 'nullable|string|max:120',
            'steps.*.desc'      => 'nullable|string|max:300',
            'steps.*.icon'      => 'nullable|string|max:60',
        ]);

        // Plain text settings (everything in defaults except the image + JSON steps)
        $textKeys = array_keys(static::defaults());
        foreach ($textKeys as $key) {
            if ($key === 'hp_hero_image') continue;
            // Visibility toggles arrive only when checked
            if (in_array($key, ['hp_featured_show', 'hp_how_show', 'hp_testi_show'])) {
                SiteSetting::set($key, $request->boolean($key) ? '1' : '0');
                continue;
            }
            SiteSetting::set($key, $request->input($key));
        }

        // Steps (repeatable) — drop blank rows
        $steps = collect($request->input('steps', []))
            ->filter(fn ($s) => filled($s['title'] ?? null))
            ->map(fn ($s) => [
                'id'    => $s['id'] ?? '',
                'title' => $s['title'] ?? '',
                'desc'  => $s['desc'] ?? '',
                'icon'  => $s['icon'] ?? 'fa-circle',
            ])
            ->values()
            ->all();
        SiteSetting::setJson('hp_steps', $steps);

        // Hero background image
        if ($request->hasFile('hp_hero_image')) {
            $old = SiteSetting::get('hp_hero_image');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('hp_hero_image')->store('homepage', 'public');
            SiteSetting::set('hp_hero_image', $path);
        }

        if ($request->boolean('remove_hero_image')) {
            $old = SiteSetting::get('hp_hero_image');
            if ($old) Storage::disk('public')->delete($old);
            SiteSetting::set('hp_hero_image', null);
        }

        return redirect()->route('admin.homepage.edit')
            ->with('success', 'Homepage content updated successfully!');
    }
}
