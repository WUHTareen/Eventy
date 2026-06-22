@php
    /** @var \App\Models\Coupon|null $coupon */
    $coupon = $coupon ?? null;
    $labelCls = 'block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5';
@endphp
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <label class="{{ $labelCls }}">Code</label>
        <input type="text" name="code" value="{{ old('code', $coupon->code ?? '') }}" placeholder="SUMMER20" class="{{ $fieldCls }} font-mono uppercase tracking-wider" required>
    </div>
    <div>
        <label class="{{ $labelCls }}">Discount Type</label>
        <select name="type" class="{{ $fieldCls }}">
            <option value="fixed" @selected(old('type', $coupon->type ?? 'fixed') === 'fixed')>Fixed Amount (PKR)</option>
            <option value="percent" @selected(old('type', $coupon->type ?? '') === 'percent')>Percentage (%)</option>
        </select>
    </div>
    <div>
        <label class="{{ $labelCls }}">Value</label>
        <input type="number" step="0.01" min="0.01" name="value" value="{{ old('value', $coupon->value ?? '') }}" class="{{ $fieldCls }}" required>
    </div>
    <div>
        <label class="{{ $labelCls }}">Min. Order Amount (PKR)</label>
        <input type="number" step="0.01" min="0" name="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount ?? 0) }}" class="{{ $fieldCls }}">
    </div>
    <div>
        <label class="{{ $labelCls }}">Usage Limit <span class="text-gray-400">(blank = unlimited)</span></label>
        <input type="number" min="1" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}" class="{{ $fieldCls }}">
    </div>
    <div>
        <label class="{{ $labelCls }}">Expires On <span class="text-gray-400">(blank = never)</span></label>
        <input type="date" name="expires_at" value="{{ old('expires_at', $coupon && $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '') }}" class="{{ $fieldCls }}">
    </div>
    <div class="md:col-span-2">
        <label class="{{ $labelCls }}">Restrict to Vendor <span class="text-gray-400">(blank = platform-wide)</span></label>
        <select name="vendor_id" class="{{ $fieldCls }}">
            <option value="">-- Platform-wide (all vendors) --</option>
            @foreach($vendors as $vendor)
                <option value="{{ $vendor->id }}" @selected(old('vendor_id', $coupon->vendor_id ?? '') == $vendor->id)>{{ $vendor->name }}</option>
            @endforeach
        </select>
    </div>
    <label class="flex items-center gap-2 text-xs font-bold text-gray-600 cursor-pointer self-end pb-2.5">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $coupon->is_active ?? true)) class="rounded"> Active
    </label>
</div>
