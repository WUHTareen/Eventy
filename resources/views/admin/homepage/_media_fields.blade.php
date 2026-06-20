@php
    /** @var \App\Models\HomepageMedia|null $item */
    $item = $item ?? null;
    $meta = $item->meta ?? [];
    $fieldCls = 'w-full px-4 py-2.5 bg-white border border-gray-100 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-bold text-sm';
    $fileCls = 'block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100';
@endphp

@foreach($fields as $f)
    @if($f === 'image')
        <div>
            <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Image</label>
            @if($item && $item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="w-20 h-14 object-cover rounded-lg border border-gray-200 mb-2">
            @endif
            <input type="file" name="image" accept="image/*" class="{{ $fileCls }}">
        </div>
    @elseif($f === 'video')
        <div>
            <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Video (mp4/webm, max 50MB)</label>
            @if($item && $item->video)
                <p class="text-[11px] text-green-600 font-bold mb-1"><i class="fa-solid fa-circle-check"></i> Uploaded</p>
            @endif
            <input type="file" name="video" accept="video/*" class="{{ $fileCls }}">
        </div>
    @elseif($f === 'poster')
        <div>
            <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Poster Image</label>
            @if($item && $item->poster)
                <img src="{{ asset('storage/' . $item->poster) }}" class="w-20 h-14 object-cover rounded-lg border border-gray-200 mb-2">
            @endif
            <input type="file" name="poster" accept="image/*" class="{{ $fileCls }}">
        </div>
    @elseif($f === 'title')
        <div><label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Title</label><input type="text" name="title" value="{{ $item->title ?? '' }}" class="{{ $fieldCls }}"></div>
    @elseif($f === 'subtitle')
        <div><label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Subtitle</label><input type="text" name="subtitle" value="{{ $item->subtitle ?? '' }}" class="{{ $fieldCls }}"></div>
    @elseif($f === 'badge')
        <div><label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Badge / Code</label><input type="text" name="badge" value="{{ $item->badge ?? '' }}" class="{{ $fieldCls }}"></div>
    @elseif($f === 'tag')
        <div><label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Tag</label><input type="text" name="tag" value="{{ $item->tag ?? '' }}" class="{{ $fieldCls }}"></div>
    @elseif($f === 'price')
        <div><label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Price</label><input type="text" name="price" value="{{ $item->price ?? '' }}" class="{{ $fieldCls }}"></div>
    @elseif($f === 'link')
        <div><label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Link URL</label><input type="text" name="link" value="{{ $item->link ?? '' }}" class="{{ $fieldCls }}" placeholder="https://..."></div>
    @elseif($f === 'meta_dept')
        <div><label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Department</label><input type="text" name="meta_dept" value="{{ $meta['dept'] ?? '' }}" class="{{ $fieldCls }}"></div>
    @elseif($f === 'meta_icon')
        <div><label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Icon (Font Awesome)</label><input type="text" name="meta_icon" value="{{ $meta['icon'] ?? '' }}" class="{{ $fieldCls }}" placeholder="fa-server"></div>
    @elseif($f === 'meta_verified')
        <label class="flex items-center gap-2 text-xs font-bold text-gray-600 cursor-pointer self-end pb-2.5"><input type="checkbox" name="meta_verified" value="1" @checked(($meta['verified'] ?? false)) class="rounded"> Verified badge</label>
    @elseif($f === 'meta_is_local')
        <label class="flex items-center gap-2 text-xs font-bold text-gray-600 cursor-pointer self-end pb-2.5"><input type="checkbox" name="meta_is_local" value="1" @checked(($meta['is_local'] ?? true)) class="rounded"> Pakistan (local)</label>
    @endif
@endforeach
