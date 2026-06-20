<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageMediaController extends Controller
{
    private array $sections = ['corporate_card', 'video_tile', 'landmark', 'avatar'];

    private function validated(Request $request): array
    {
        return $request->validate([
            'section'   => 'required|in:' . implode(',', $this->sections),
            'title'     => 'nullable|string|max:160',
            'subtitle'  => 'nullable|string|max:255',
            'badge'     => 'nullable|string|max:100',
            'tag'       => 'nullable|string|max:100',
            'price'     => 'nullable|string|max:60',
            'link'      => 'nullable|string|max:255',
            'sort_order'=> 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'poster'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'video'     => 'nullable|file|mimes:mp4,webm,ogg|max:51200',
            'meta_dept'     => 'nullable|string|max:120',
            'meta_icon'     => 'nullable|string|max:60',
            'meta_verified' => 'nullable|boolean',
            'meta_is_local' => 'nullable|boolean',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $media = new HomepageMedia();
        $this->fill($media, $request, $data);
        $media->save();

        return back()->with('success', 'Homepage media added.');
    }

    public function update(Request $request, HomepageMedia $media)
    {
        $data = $this->validated($request);
        $this->fill($media, $request, $data);
        $media->save();

        return back()->with('success', 'Homepage media updated.');
    }

    public function destroy(HomepageMedia $media)
    {
        foreach (['image', 'poster', 'video'] as $field) {
            if ($media->$field) Storage::disk('public')->delete($media->$field);
        }
        $media->delete();

        return back()->with('success', 'Homepage media removed.');
    }

    private function fill(HomepageMedia $media, Request $request, array $data): void
    {
        $media->section    = $data['section'];
        $media->title      = $data['title'] ?? null;
        $media->subtitle   = $data['subtitle'] ?? null;
        $media->badge      = $data['badge'] ?? null;
        $media->tag        = $data['tag'] ?? null;
        $media->price      = $data['price'] ?? null;
        $media->link       = $data['link'] ?? null;
        $media->sort_order = $data['sort_order'] ?? 0;
        $media->is_active  = $request->boolean('is_active', true);

        $media->meta = [
            'dept'     => $request->input('meta_dept'),
            'icon'     => $request->input('meta_icon'),
            'verified' => $request->boolean('meta_verified'),
            'is_local' => $request->boolean('meta_is_local'),
        ];

        foreach (['image', 'poster', 'video'] as $field) {
            if ($request->hasFile($field)) {
                if ($media->$field) Storage::disk('public')->delete($media->$field);
                $media->$field = $request->file($field)->store('homepage', 'public');
            }
        }
    }
}
