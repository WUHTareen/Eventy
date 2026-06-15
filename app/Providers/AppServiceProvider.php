<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Booking;
use App\Models\Review;
use App\Observers\BookingObserver;
use App\Observers\ReviewObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Booking::observe(BookingObserver::class);
        Review::observe(ReviewObserver::class);

        try {
            \Illuminate\Support\Facades\View::share('cities', \App\Models\City::all());
            \Illuminate\Support\Facades\View::share('categories', \App\Models\ServiceCategory::whereNull('parent_id')->get());

            // Format testimonials for the slider
            $testimonials = \App\Models\Testimonial::all()->map(function($t, $index) {
                $colors = ['bg-purple-100 text-purple-600', 'bg-blue-100 text-blue-600', 'bg-pink-100 text-pink-600', 'bg-green-100 text-green-600', 'bg-orange-100 text-orange-600'];
                return [
                    'quote' => $t->quote,
                    'name' => $t->name,
                    'role' => $t->role,
                    'initial' => substr($t->name, 0, 1),
                    'color' => $colors[$index % count($colors)],
                    'stars' => $t->stars
                ];
            });
            \Illuminate\Support\Facades\View::share('testimonialSlides', $testimonials);

            // Fetch generic features collection for other uses
            $features = \App\Models\Feature::orderBy('order')->get();
            \Illuminate\Support\Facades\View::share('features', $features);

            // Format Features for the generic loop with colors
            $featureCards = $features->map(function($f, $index) {
                // We define a set of color configurations for the cards to rotate through
                $styles = [
                    ['bg' => 'from-purple-600 to-indigo-600', 'shadow' => 'shadow-purple-900/50', 'text' => 'group-hover:text-purple-300', 'blur' => 'bg-purple-600/20'],
                    ['bg' => 'from-pink-600 to-rose-600', 'shadow' => 'shadow-pink-900/50', 'text' => 'group-hover:text-pink-300', 'blur' => 'bg-pink-600/20'],
                    ['bg' => 'from-blue-600 to-cyan-600', 'shadow' => 'shadow-blue-900/50', 'text' => 'group-hover:text-blue-300', 'blur' => 'bg-blue-600/20'],
                    ['bg' => 'from-emerald-600 to-green-600', 'shadow' => 'shadow-emerald-900/50', 'text' => 'group-hover:text-emerald-300', 'blur' => 'bg-emerald-600/20'],
                    ['bg' => 'from-orange-600 to-amber-600', 'shadow' => 'shadow-orange-900/50', 'text' => 'group-hover:text-orange-300', 'blur' => 'bg-orange-600/20'],
                    ['bg' => 'from-amber-500 to-yellow-500', 'shadow' => 'shadow-amber-900/50', 'text' => 'group-hover:text-amber-300', 'blur' => 'bg-amber-600/20'],
                ];
                
                $style = $styles[$index % count($styles)];
                
                // Add style properties to the object
                $f->style_bg = $style['bg'];
                $f->style_shadow = $style['shadow'];
                $f->style_text = $style['text'];
                $f->style_blur = $style['blur'];
                $f->delay = $index * 100; // Staggered animation delay
                
                return $f;
            });
            \Illuminate\Support\Facades\View::share('featureCards', $featureCards);

        } catch (\Exception $e) {
            // In case database tables don't exist yet (e.g. during migration reset)
        }

        // Security: Define Rate Limiters
        \Illuminate\Support\Facades\RateLimiter::for('login', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->email.$request->ip());
        });

        \Illuminate\Support\Facades\RateLimiter::for('register', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(3)->by($request->ip());
        });

        \Illuminate\Support\Facades\RateLimiter::for('password', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->ip());
        });

        \Illuminate\Support\Facades\RateLimiter::for('form', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(10)->by($request->ip());
        });
    }
}
