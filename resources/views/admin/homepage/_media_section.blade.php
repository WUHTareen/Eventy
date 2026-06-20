@php
    /** @var string $section */
    /** @var \Illuminate\Support\Collection $items */
    /** @var array $fields */
    $items = $items ?? collect();
@endphp
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ addOpen: false }">
    <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold text-gray-800"><i class="fa-solid {{ $icon }} {{ $iconColor }} mr-2"></i>{{ $label }}</h3>
            <p class="text-gray-500 text-sm">{{ $help }}</p>
        </div>
        <button type="button" @click="addOpen = !addOpen" class="bg-indigo-600 text-white px-4 py-2 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all">+ Add</button>
    </div>

    <div class="p-8 space-y-5">
        @if($items->isEmpty())
            <p class="text-sm text-gray-400 font-medium bg-gray-50 rounded-2xl p-5 text-center">No items yet — the homepage is showing the built-in defaults. Add items here to override them.</p>
        @endif

        @foreach($items as $item)
            <form action="{{ route('admin.homepage.media.update', $item) }}" method="POST" enctype="multipart/form-data" class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                @csrf
                <input type="hidden" name="section" value="{{ $section }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @include('admin.homepage._media_fields', ['item' => $item, 'fields' => $fields])
                    <div>
                        <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ $item->sort_order }}" class="w-full px-4 py-2.5 bg-white border border-gray-100 rounded-xl font-bold text-sm">
                    </div>
                    <label class="flex items-center gap-2 text-xs font-bold text-gray-600 cursor-pointer self-end pb-2.5">
                        <input type="checkbox" name="is_active" value="1" @checked($item->is_active) class="rounded"> Active (visible)
                    </label>
                </div>
                <div class="flex items-center gap-3 mt-4">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-xl font-black text-xs uppercase tracking-widest">Save</button>
                </div>
            </form>
            <form action="{{ route('admin.homepage.media.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this item?')" class="-mt-3">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-black uppercase tracking-widest"><i class="fa-solid fa-trash-can"></i> Delete</button>
            </form>
        @endforeach

        <!-- Add new -->
        <form action="{{ route('admin.homepage.media.store') }}" method="POST" enctype="multipart/form-data" x-show="addOpen" x-cloak class="bg-indigo-50/50 rounded-2xl border border-indigo-100 p-5">
            @csrf
            <input type="hidden" name="section" value="{{ $section }}">
            <h4 class="text-sm font-black text-indigo-700 uppercase tracking-widest mb-4">New Item</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @include('admin.homepage._media_fields', ['item' => null, 'fields' => $fields])
                <div>
                    <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" value="0" class="w-full px-4 py-2.5 bg-white border border-gray-100 rounded-xl font-bold text-sm">
                </div>
                <label class="flex items-center gap-2 text-xs font-bold text-gray-600 cursor-pointer self-end pb-2.5">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded"> Active (visible)
                </label>
            </div>
            <button type="submit" class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl font-black text-xs uppercase tracking-widest">Add Item</button>
        </form>
    </div>
</div>
