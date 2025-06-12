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
        $keyword = $request->query('keyword');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        $query = Review::query()
            ->with(['user', 'shop'])
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->join('shops', 'reviews.shop_id', '=', 'shops.id')
            ->select('reviews.*');

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('users.name', 'like', "%{$keyword}%")
                ->orWhere('shops.name', 'like', "%{$keyword}%")
                ->orWhere('reviews.content', 'like', "%{$keyword}%");
            });
        }

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
