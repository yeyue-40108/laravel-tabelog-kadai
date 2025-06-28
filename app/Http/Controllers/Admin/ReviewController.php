<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReviewController extends Controller
{
    public function index(Request $request, Review $review)
    {
        $master = auth('admin')->user();
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        $start = $start_date ? Carbon::parse($start_date) : null;
        $end = $end_date ? Carbon::parse($end_date) : null;

        if ($start && $end && $end->lt($start)) {
            return redirect()->route('admin.reviews.index')->with('flash_message', '終了日は開始日より後の日付を指定してください。');
        }

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

        if ($master->role === 'shop_manager') {
            $shop_ids = Shop::where('master_id', $master->id)->pluck('id');
            $query->whereIn('shop_id', $shop_ids);
        }

        $reviews = $query->sortable()->paginate(10);
        $total_count = $reviews->total();

        return view('admin.reviews.index', compact('reviews', 'total_count', 'keyword', 'start_date', 'end_date', 'master'));
    }

    public function show(Review $review)
    {
        $master = auth('admin')->user();
        
        return view('admin.reviews.show', compact('review', 'master'));
    }

    public function update(Request $request, Review $review)
    {
        $review->update([
            'display' => $request->input('display'),
        ]);

        return redirect()->route('admin.reviews.show', $review)->with('flash_message', 'レビューの表示許可を変更しました。');
    }
}
