<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\BlogPost;
use App\Models\CustomPackage;
use App\Models\User;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    /**
     * Static public routes worth indexing. Auth/account/checkout pages are
     * intentionally excluded.
     */
    protected array $staticRoutes = [
        'home', 'about', 'contact', 'how-it-works', 'services', 'blog.index',
        'budget-planner', 'upcoming', 'global', 'individual', 'corporate',
        'insights', 'packages.index', 'hotels.index', 'vendor-onboarding',
        'privacy', 'terms', 'refund-policy',
    ];

    public function index()
    {
        $urls = [];

        // Static pages
        foreach ($this->staticRoutes as $name) {
            if (\Illuminate\Support\Facades\Route::has($name)) {
                $urls[] = [
                    'loc'        => route($name),
                    'changefreq' => 'weekly',
                    'priority'   => $name === 'home' ? '1.0' : '0.7',
                ];
            }
        }

        // Active services (slug-based detail pages)
        Service::where('status', 'active')
            ->select('slug', 'updated_at')
            ->orderBy('id')
            ->chunk(500, function ($services) use (&$urls) {
                foreach ($services as $service) {
                    if (! $service->slug) {
                        continue;
                    }
                    $urls[] = [
                        'loc'        => route('services.show', $service->slug),
                        'lastmod'    => optional($service->updated_at)->toAtomString(),
                        'changefreq' => 'weekly',
                        'priority'   => '0.8',
                    ];
                }
            });

        // Published blog posts
        BlogPost::published()
            ->select('slug', 'updated_at')
            ->orderBy('id')
            ->chunk(500, function ($posts) use (&$urls) {
                foreach ($posts as $post) {
                    if (! $post->slug) {
                        continue;
                    }
                    $urls[] = [
                        'loc'        => route('blog.show', $post->slug),
                        'lastmod'    => optional($post->updated_at)->toAtomString(),
                        'changefreq' => 'monthly',
                        'priority'   => '0.6',
                    ];
                }
            });

        // Published custom packages
        CustomPackage::where('status', 'published')
            ->select('id', 'updated_at')
            ->orderBy('id')
            ->chunk(500, function ($packages) use (&$urls) {
                foreach ($packages as $package) {
                    $urls[] = [
                        'loc'        => route('packages.show', $package->id),
                        'lastmod'    => optional($package->updated_at)->toAtomString(),
                        'changefreq' => 'monthly',
                        'priority'   => '0.6',
                    ];
                }
            });

        // Public vendor profiles
        User::where('role', 'vendor')
            ->select('id', 'updated_at')
            ->orderBy('id')
            ->chunk(500, function ($vendors) use (&$urls) {
                foreach ($vendors as $vendor) {
                    $urls[] = [
                        'loc'        => route('vendors.show', $vendor->id),
                        'lastmod'    => optional($vendor->updated_at)->toAtomString(),
                        'changefreq' => 'weekly',
                        'priority'   => '0.6',
                    ];
                }
            });

        $content = view('sitemap', compact('urls'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
