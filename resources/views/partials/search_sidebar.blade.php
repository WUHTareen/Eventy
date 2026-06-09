@php
    $facetClone1 = clone $facetQuery;
    $uniqueLocations = $facetClone1->pluck('location')->filter()->unique();

    $facetClone2 = clone $facetQuery;
    $uniqueCategoryIds = $facetClone2->pluck('category_id')->filter()->unique();
    $uniqueCategories = \App\Models\ServiceCategory::whereIn('id', $uniqueCategoryIds)->pluck('name')->filter()->unique();
@endphp

<div class="space-y-6">
    <!-- Budget Range Card -->
    <div x-data="{
        minVal: {{ request('min_price', 0) }},
        maxVal: {{ request('max_price', 500000) }},
        minLimit: 0,
        maxLimit: 500000,
        get minPercent() { return (this.minVal / this.maxLimit) * 100; },
        get maxPercent() { return (this.maxVal / this.maxLimit) * 100; },
        formatPKR(val) {
            if(val >= 100000) return (val/100000).toFixed(val%100000===0?0:1) + 'L';
            if(val >= 1000) return (val/1000).toFixed(val%1000===0?0:0) + 'K';
            return val;
        },
        applyFilter() {
            const url = new URL(window.location.href);
            url.searchParams.set('min_price', this.minVal);
            url.searchParams.set('max_price', this.maxVal);
            updateResults(url.toString());
        }
    }">
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 block">Your Budget (per item)</label>

        <!-- Price Display -->
        <div class="flex justify-between items-center mb-4">
            <div class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-center">
                <p class="text-[8px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Min</p>
                <p class="text-xs font-black text-[#0A192F]">PKR <span x-text="formatPKR(minVal)"></span></p>
            </div>
            <div class="text-slate-300 text-xs font-bold">—</div>
            <div class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-center">
                <p class="text-[8px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Max</p>
                <p class="text-xs font-black text-[#0A192F]">PKR <span x-text="formatPKR(maxVal)"></span></p>
            </div>
        </div>

        <!-- Dual Range Slider -->
        <div class="relative h-5 mb-4">
            <div class="absolute top-1/2 -translate-y-1/2 w-full h-1.5 bg-slate-200 rounded-full"></div>
            <div class="absolute top-1/2 -translate-y-1/2 h-1.5 bg-[#ED1C24] rounded-full"
                 :style="'left:' + minPercent + '%;width:' + (maxPercent - minPercent) + '%'"></div>
            <input type="range" :min="minLimit" :max="maxLimit" step="5000"
                   x-model.number="minVal"
                   @input="if(minVal > maxVal - 10000) minVal = maxVal - 10000"
                   class="absolute w-full appearance-none bg-transparent h-1.5 top-1/2 -translate-y-1/2 pointer-events-none [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-[#ED1C24] [&::-webkit-slider-thumb]:shadow-md [&::-webkit-slider-thumb]:cursor-pointer">
            <input type="range" :min="minLimit" :max="maxLimit" step="5000"
                   x-model.number="maxVal"
                   @input="if(maxVal < minVal + 10000) maxVal = minVal + 10000"
                   class="absolute w-full appearance-none bg-transparent h-1.5 top-1/2 -translate-y-1/2 pointer-events-none [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-[#ED1C24] [&::-webkit-slider-thumb]:shadow-md [&::-webkit-slider-thumb]:cursor-pointer">
        </div>

        <!-- Quick Presets -->
        <div class="flex flex-wrap gap-1.5 mb-4">
            <button type="button" @click="minVal=0; maxVal=50000" class="text-[9px] font-bold px-2 py-1 rounded-lg border border-slate-200 text-slate-500 hover:border-[#ED1C24] hover:text-[#ED1C24] transition-colors">Under 50K</button>
            <button type="button" @click="minVal=50000; maxVal=100000" class="text-[9px] font-bold px-2 py-1 rounded-lg border border-slate-200 text-slate-500 hover:border-[#ED1C24] hover:text-[#ED1C24] transition-colors">50K-1L</button>
            <button type="button" @click="minVal=100000; maxVal=500000" class="text-[9px] font-bold px-2 py-1 rounded-lg border border-slate-200 text-slate-500 hover:border-[#ED1C24] hover:text-[#ED1C24] transition-colors">1L+</button>
        </div>

        <button @click="applyFilter()" class="w-full py-2 bg-[#ED1C24] text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#0A192F] transition-colors">
            Apply Range
        </button>
    </div>

    <div class="h-px bg-gray-100 my-6"></div>

    <!-- Dynamic Asset Details Filter -->
    <div>
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block">Property Details & Area</label>
        
        @if($uniqueLocations->isNotEmpty())
            <div class="mt-4 mb-2 text-[9px] font-bold text-[#ED1C24] uppercase tracking-widest">Available Areas</div>
            <div class="space-y-3 max-h-40 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-200">
                @foreach($uniqueLocations as $loc)
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="locations[]" value="{{ $loc }}" onchange="syncAndFilter(this)" class="checked:bg-[#ED1C24] rounded text-[#ED1C24] focus:ring-0 w-4 h-4 border-gray-300 shadow-sm transition-colors cursor-pointer" {{ (is_array(request('locations')) && in_array($loc, request('locations'))) ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-600 group-hover:text-[#0A192F] transition-colors truncate" title="{{ $loc }}">{{ Str::limit($loc, 25) }}</span>
                    </label>
                @endforeach
            </div>
        @endif

        @if($uniqueCategories->isNotEmpty())
            <div class="mt-4 mb-2 text-[9px] font-bold text-[#ED1C24] uppercase tracking-widest">Asset Categories</div>
            <div class="space-y-3 max-h-40 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-200">
                @foreach($uniqueCategories as $catName)
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="categories[]" value="{{ $catName }}" onchange="syncAndFilter(this)" class="checked:bg-[#ED1C24] rounded text-[#ED1C24] focus:ring-0 w-4 h-4 border-gray-300 shadow-sm transition-colors cursor-pointer" {{ (is_array(request('categories')) && in_array($catName, request('categories'))) ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-gray-600 group-hover:text-[#0A192F] transition-colors truncate" title="{{ $catName }}">{{ Str::limit($catName, 25) }}</span>
                    </label>
                @endforeach
            </div>
        @endif
        
    </div>

    <div class="h-px bg-gray-100 my-6"></div>

    <!-- Rating Filter -->
    <div>
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block">Review Score</label>
        <div class="mt-2 space-y-2">
            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="radio" name="rating_filter" value="4.5" 
                       {{ request('rating') == '4.5' ? 'checked' : '' }}
                       onchange="
                            const url = new URL(window.location.href);
                            url.searchParams.set('rating', '4.5');
                            updateResults(url.toString());
                       "
                       class="checked:bg-[#ED1C24] rounded-full text-[#ED1C24] focus:ring-0 w-4 h-4 border-gray-300">
                <div class="flex items-center gap-1 text-xs font-bold text-gray-600 group-hover:text-[#0A192F]">
                    <span>Excellent</span>
                    <span class="bg-[#0A192F] text-white text-[9px] px-1.5 py-0.5 rounded ml-1">4.5+</span>
                </div>
            </label>
            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="radio" name="rating_filter" value="4.0"
                       {{ request('rating') == '4.0' ? 'checked' : '' }}
                       onchange="
                            const url = new URL(window.location.href);
                            url.searchParams.set('rating', '4.0');
                            updateResults(url.toString());
                       "
                       class="checked:bg-[#ED1C24] rounded-full text-[#ED1C24] focus:ring-0 w-4 h-4 border-gray-300">
                <div class="flex items-center gap-1 text-xs font-bold text-gray-600 group-hover:text-[#0A192F]">
                    <span>Very Good</span>
                    <span class="bg-[#0A192F] text-white text-[9px] px-1.5 py-0.5 rounded ml-1">4.0+</span>
                </div>
            </label>
        </div>
    </div>
    <!-- Corporate Mission Parameters -->
    <div class="h-px bg-gray-100 my-6"></div>
    <div>
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block">Corporate Mission Parameters</label>
        
        <div class="space-y-4">
            <!-- Event Size -->
            <div>
                <p class="text-[9px] font-bold text-[#ED1C24] uppercase tracking-widest mb-2">Guest Capacity Profile</p>
                <select onchange="
                    const url = new URL(window.location.href);
                    url.searchParams.set('event_size', this.value);
                    updateResults(url.toString());
                " class="w-full bg-slate-50 border-slate-200 rounded-xl text-[11px] font-bold text-slate-600 focus:ring-0">
                    <option value="">Any Capacity</option>
                    <option value="0-50" {{ request('event_size') == '0-50' ? 'selected' : '' }}>0-50 (Micro)</option>
                    <option value="50-200" {{ request('event_size') == '50-200' ? 'selected' : '' }}>50-200 (Medium)</option>
                    <option value="200-500" {{ request('event_size') == '200-500' ? 'selected' : '' }}>200-500 (Large)</option>
                    <option value="500+" {{ request('event_size') == '500+' ? 'selected' : '' }}>500+ (Enterprise)</option>
                </select>
            </div>

            <!-- Departmental Metadata -->
            <div>
                <p class="text-[9px] font-bold text-[#ED1C24] uppercase tracking-widest mb-2">Compliance Hierarchy</p>
                <div class="space-y-3">
                    <input type="text" placeholder="Department..." 
                           value="{{ request('department') }}"
                           @change="
                                const url = new URL(window.location.href);
                                url.searchParams.set('department', $event.target.value);
                                updateResults(url.toString());
                           "
                           class="w-full bg-slate-50 border-slate-200 rounded-xl text-[11px] font-bold text-slate-600 focus:ring-0">
                    
                    <input type="text" placeholder="Cost Center ID..." 
                           value="{{ request('cost_center') }}"
                           @change="
                                const url = new URL(window.location.href);
                                url.searchParams.set('cost_center', $event.target.value);
                                updateResults(url.toString());
                           "
                           class="w-full bg-slate-50 border-slate-200 rounded-xl text-[11px] font-bold text-slate-600 focus:ring-0">
                </div>
            </div>

            <!-- Verified Partners Only -->
            <label class="flex items-center justify-between mt-2 cursor-pointer group">
                <div class="flex flex-col">
                    <span class="text-[10px] font-black text-[#0A192F] uppercase tracking-widest">Verified Partners</span>
                    <span class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter">Enterprise Vetted Only</span>
                </div>
                <div class="relative inline-flex items-center">
                    <input type="checkbox" name="verified_only" value="1" 
                           {{ request('verified_only') ? 'checked' : '' }}
                           onchange="
                                const url = new URL(window.location.href);
                                if(this.checked) url.searchParams.set('verified_only', '1');
                                else url.searchParams.delete('verified_only');
                                updateResults(url.toString());
                           "
                           class="sr-only peer">
                    <div class="w-9 h-5 bg-slate-200 rounded-full peer peer-checked:bg-[#ED1C24] transition-all after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full shadow-inner"></div>
                </div>
            </label>
        </div>
    </div>
</div>
