<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\City;
use App\Models\ServiceCategory;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // List all users
    public function index(Request $request)
    {
        $query = User::with(['city'])->where('role', '!=', 'admin');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        if ($request->status === 'banned') {
            $query->where('is_banned', true);
        } elseif ($request->status === 'active') {
            $query->where('is_banned', false);
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    // Show single user detail
    public function show(User $user)
    {
        $user->load(['city', 'bookings', 'reviews']);
        $cities = City::all();
        $categories = ServiceCategory::whereNull('parent_id')->get();
        return view('admin.users.show', compact('user', 'cities', 'categories'));
    }

    // Create user form
    public function create()
    {
        $cities = City::all();
        $categories = ServiceCategory::whereNull('parent_id')->get();
        return view('admin.users.create', compact('cities', 'categories'));
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255', 'unique:users'],
            'password'    => ['required', Rules\Password::defaults()],
            'role'        => ['required', 'in:user,vendor,admin'],
            'city_id'     => $request->role === 'vendor' ? ['required', 'exists:cities,id'] : ['nullable'],
            'category_id' => $request->role === 'vendor' ? ['required', 'exists:service_categories,id'] : ['nullable'],
        ]);

        $vendorType = null;
        if ($request->role === 'vendor' && $request->category_id) {
            $category = ServiceCategory::find($request->category_id);
            $vendorType = $category ? $category->name : null;
        }

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => $request->role,
            'vendor_type' => $vendorType,
            'city_id'     => $request->city_id,
            'category_id' => $request->category_id,
            'is_verified' => $request->role !== 'vendor',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    // Update user details
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email,' . $user->id],
            'role'     => ['required', 'in:user,vendor,admin'],
            'city_id'  => ['nullable', 'exists:cities,id'],
            'password' => ['nullable', 'min:8'],
        ]);

        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->role    = $request->role;
        $user->city_id = $request->city_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->route('admin.users.show', $user)->with('success', 'User updated successfully!');
    }

    // Ban or unban user
    public function toggleBan(User $user)
    {
        $user->is_banned = !$user->is_banned;
        $user->save();

        $status = $user->is_banned ? 'banned' : 'unbanned';
        return redirect()->back()->with('success', "User {$status} successfully!");
    }

    // Verify vendor
    public function verifyVendor(User $user)
    {
        $user->is_verified = true;
        $user->save();

        return redirect()->back()->with('success', 'Vendor verified successfully!');
    }

    // Reject vendor
    public function rejectVendor(Request $request, User $user)
    {
        $user->is_verified = false;
        $user->save();

        return redirect()->back()->with('success', 'Vendor rejected.');
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}
