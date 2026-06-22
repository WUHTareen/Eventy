<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::with('vendor')->latest()->get();
        $vendors = User::where('role', 'vendor')->orderBy('name')->get(['id', 'name']);
        return view('admin.coupons.index', compact('coupons', 'vendors'));
    }

    private function validated(Request $request, ?Coupon $coupon = null): array
    {
        return $request->validate([
            'code'             => ['required', 'string', 'max:50', 'alpha_dash', 'unique:coupons,code' . ($coupon ? ',' . $coupon->id : '')],
            'type'             => ['required', 'in:fixed,percent'],
            'value'            => ['required', 'numeric', 'min:0.01'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'usage_limit'      => ['nullable', 'integer', 'min:1'],
            'expires_at'       => ['nullable', 'date'],
            'is_active'        => ['nullable', 'boolean'],
            'vendor_id'        => ['nullable', 'exists:users,id'],
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['code'] = strtoupper($data['code']);
        $data['min_order_amount'] = $data['min_order_amount'] ?? 0;
        $data['is_active'] = $request->boolean('is_active', true);

        Coupon::create($data);

        return back()->with('success', 'Coupon created.');
    }

    public function update(Request $request, Coupon $coupon)
    {
        $data = $this->validated($request, $coupon);
        $data['code'] = strtoupper($data['code']);
        $data['min_order_amount'] = $data['min_order_amount'] ?? 0;
        $data['is_active'] = $request->boolean('is_active', true);

        $coupon->update($data);

        return back()->with('success', 'Coupon updated.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'Coupon deleted.');
    }
}
