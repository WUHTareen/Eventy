<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\City;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createVendor(): View
    {
        $cities = City::all();
        $categories = \App\Models\ServiceCategory::whereNull('parent_id')->get();
        return view('auth.register-vendor', compact('cities', 'categories'));
    }

    public function storeVendor(Request $request): RedirectResponse
    {
        return $this->store($request, 'vendor');
    }

    public function createCorporate(): View
    {
        $cities = City::all();
        // Corporate users might not need categories, but we can pass them if needed or just cities
        return view('auth.register-corporate', compact('cities'));
    }

    public function storeCorporate(Request $request): RedirectResponse
    {
        return $this->store($request, 'corporate');
    }

    public function store(Request $request, $role = 'user'): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'vendor_type' => $role === 'vendor' ? ['nullable', 'string'] : ['nullable'], // Now derived from category
            'city_id' => $role === 'vendor' ? ['required', 'exists:cities,id'] : ['nullable'],
            'category_id' => $role === 'vendor' ? ['required', 'exists:service_categories,id'] : ['nullable'],
            'ntn_number' => $role === 'corporate' ? ['required', 'string', 'max:50'] : ['nullable'],
        ]);

        $vendorType = null;
        if ($role === 'vendor' && $request->category_id) {
            $category = \App\Models\ServiceCategory::find($request->category_id);
            $vendorType = $category ? $category->name : null;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $role,
            'vendor_type' => $vendorType,
            'city_id' => $role === 'vendor' ? $request->city_id : null,
            'category_id' => $role === 'vendor' ? $request->category_id : null,
            'ntn_number' => $request->ntn_number,
            'is_verified' => $role !== 'vendor', // Vendors need verification
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($role === 'vendor') {
            return redirect()->route('vendor.dashboard');
        }

        if ($role === 'corporate') {
            return redirect()->route('corporate.dashboard');
        }

        return redirect(route('dashboard', absolute: false));
    }
}
