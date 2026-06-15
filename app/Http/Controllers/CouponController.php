<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Service;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Validate a coupon via AJAX.
     */
    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'amount' => 'required|numeric',
            'service_id' => 'required|exists:services,id',
        ]);

        $service = Service::findOrFail($request->service_id);
        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid coupon code.'
            ], 422);
        }

        if (!$coupon->isValidFor($request->amount, $service->user_id)) {
            $message = 'Coupon is not valid for this order.';
            
            if (!$coupon->is_active) $message = 'Coupon is no longer active.';
            elseif ($coupon->expires_at && $coupon->expires_at->isPast()) $message = 'Coupon has expired.';
            elseif ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) $message = 'Coupon usage limit reached.';
            elseif ($request->amount < $coupon->min_order_amount) $message = 'Minimum amount of Rs. ' . number_format($coupon->min_order_amount) . ' required.';
            elseif ($coupon->vendor_id && $coupon->vendor_id != $service->user_id) $message = 'Coupon is only valid for specific vendor services.';

            return response()->json([
                'valid' => false,
                'message' => $message
            ], 422);
        }

        $discount = $coupon->calculateDiscount($request->amount);

        return response()->json([
            'valid' => true,
            'discount' => $discount,
            'new_total' => $request->amount - $discount,
            'message' => 'Coupon applied successfully!'
        ]);
    }
}
