<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('author')->latest()->paginate(15);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'excerpt'        => 'nullable|string|max:500',
            'content'        => 'required|string',
            'category'       => 'nullable|string|max:100',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $slug = Str::slug($request->title);
        $base = $slug;
        $i = 1;
        while (BlogPost::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('blog', 'public');
        }

        BlogPost::create([
            'title'          => $request->title,
            'slug'           => $slug,
            'excerpt'        => $request->excerpt,
            'content'        => $request->content,
            'category'       => $request->category,
            'featured_image' => $imagePath,
            'author_id'      => auth()->id(),
            'is_published'   => $request->boolean('is_published'),
            'published_at'   => $request->boolean('is_published') ? now() : null,
        ]);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully!');
    }

    public function show(BlogPost $blog)
    {
        return redirect()->route('admin.blog.edit', $blog);
    }

    public function edit(BlogPost $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, BlogPost $blog)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'excerpt'        => 'nullable|string|max:500',
            'content'        => 'required|string',
            'category'       => 'nullable|string|max:100',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $wasPublished  = $blog->is_published;
        $nowPublished  = $request->boolean('is_published');
        $featuredImage = $blog->featured_image;

        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image')->store('blog', 'public');
        }

        $blog->update([
            'title'          => $request->title,
            'excerpt'        => $request->excerpt,
            'content'        => $request->content,
            'category'       => $request->category,
            'featured_image' => $featuredImage,
            'is_published'   => $nowPublished,
            'published_at'   => (!$wasPublished && $nowPublished) ? now() : $blog->published_at,
        ]);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully!');
    }

    public function destroy(BlogPost $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted.');
    }

    public function togglePublish(BlogPost $blog)
    {
        $blog->update([
            'is_published' => !$blog->is_published,
            'published_at' => !$blog->is_published ? now() : $blog->published_at,
        ]);
        $status = $blog->is_published ? 'published' : 'unpublished';
        return back()->with('success', "Blog post {$status} successfully!");
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120',
        ]);

        $path = $request->file('file')->store('blog/content', 'public');

        return response()->json([
            'location' => asset('storage/' . $path),
        ]);
    }
}
