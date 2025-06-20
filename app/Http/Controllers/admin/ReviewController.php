<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request, Review $review)
    {
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        $query = Review::with(['user', 'shop']);

        if ($keyword = request('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('content', 'like', "%{$keyword}%")
                ->orWhereHas('user', function ($q2) use ($keyword) {
                    $q2->where('name', 'like', "%{$keyword}%");
                })
                ->orWhereHas('shop', function ($q3) use ($keyword) {
                    $q3->where('name', 'like', "%{$keyword}%");
                });
            });
        }

        $results = $query->get();

        if (!empty($start_date)) {
            $query->whereDate('reviews.created_at', '>=', $start_date);
        }
        
        if (!empty($end_date)) {
            $query->whereDate('reviews.created_at', '<=', $end_date);
        }

        $reviews = $query->sortable()->paginate(15);
        $total_count = $reviews->total();

        return view('admin.reviews.index', compact('reviews', 'total_count', 'keyword', 'start_date', 'end_date'));
    }

    public function show(Review $review)
    {
        return view('admin.reviews.show', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $review->display = $request->input('display');
        $review->update();

        return redirect()->route('admin.reviews.show', $review)->with('flash_message', 'レビューの表示許可を変更しました。');
    }
}
