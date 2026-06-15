<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = User::where('role', 'vendor')->latest()->paginate(20);
        return view('admin.vendors.index', compact('vendors'));
    }

    public function show(User $vendor)
    {
        if ($vendor->role !== 'vendor') {
            abort(404);
        }
        $services = $vendor->services()->latest()->get();
        return view('admin.vendors.show', compact('vendor', 'services'));
    }

    public function verify(User $vendor)
    {
        if ($vendor->role === 'vendor') {
            $vendor->is_verified = true;
            $vendor->save();
            
            // Notify the vendor
            Notification::createSystemNotification(
                $vendor->id,
                'Account Verified!',
                'Congratulations! Your vendor account has been verified. You can now create and publish services.',
                route('vendor.dashboard')
            );
        }
        return redirect()->back()->with('success', 'Vendor verified successfully.');
    }

    public function destroy(User $vendor)
    {
        $vendor->delete();
        return redirect()->route('admin.vendors.index')->with('success', 'Vendor deleted successfully.');
    }
}
