<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Review;
use App\Models\ReviewLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class ReviewController extends Controller
{
    public function store(Request $request, Booking $booking)
    {
        // 1. Authorization & Validation
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'completed') {
            return back()->with('error', 'You can only review completed bookings.');
        }

        if ($booking->review) {
            return back()->with('error', 'You have already reviewed this booking.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        // 2. Create Review
        $booking->review()->create([
            'user_id' => Auth::id(),
            'service_id' => $booking->service_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // 3. Update Service Cached Rating
        $booking->service->updateCachedRating();

        return back()->with('success', 'Thank you! Your verified review helps others.');
    }

    public function reply(Request $request, Review $review)
    {
        // Only the service owner (vendor) can reply
        if (Auth::id() !== $review->service->user_id) {
            abort(403);
        }

        $request->validate([
            'reply' => 'required|string|min:5|max:1000',
        ]);

        $review->update([
            'reply' => $request->reply,
            'replied_at' => now(),
        ]);

        return back()->with('success', 'Your reply has been posted.');
    }

    public function toggleLike(Review $review)
    {
        $user = Auth::user();
        $like = ReviewLike::where('review_id', $review->id)
            ->where('user_id', $user->id)
            ->first();

        if ($like) {
            $like->delete();
            $review->decrement('likes_count');
            $liked = false;
        } else {
            ReviewLike::create([
                'review_id' => $review->id,
                'user_id' => $user->id,
            ]);
            $review->increment('likes_count');
            $liked = true;
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'liked' => $liked,
                'likes_count' => $review->likes_count
            ]);
        }

        return back();
    }
}
