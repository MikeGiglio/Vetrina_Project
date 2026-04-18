<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $query = Review::whereNotNull('email_verified_at');

        if ($filter === 'pending') {
            $query->where('is_approved', false);
        } elseif ($filter === 'approved') {
            $query->where('is_approved', true);
        }

        $reviews = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        $counts = [
            'all'      => Review::whereNotNull('email_verified_at')->count(),
            'pending'  => Review::whereNotNull('email_verified_at')->where('is_approved', false)->count(),
            'approved' => Review::whereNotNull('email_verified_at')->where('is_approved', true)->count(),
        ];

        return view('admin.reviews', compact('reviews', 'counts', 'filter'));
    }

    public function approve(Review $review)
    {
        if (! $review->email_verified_at) {
            return back()->with('error', 'Email non verificata.');
        }

        $review->update(['is_approved' => ! $review->is_approved]);

        return back()->with('success', $review->is_approved ? 'Recensione pubblicata.' : 'Recensione rimossa dalla pubblicazione.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Recensione eliminata.');
    }
}
