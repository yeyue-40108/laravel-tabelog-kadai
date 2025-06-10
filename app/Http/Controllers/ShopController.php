<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $sorts = [
            '新着順' => 'created_at desc'
        ];

        $sort_query = [];
        $sorted = "created_at desc";

        if ($request->has('select_sort')) {
            $slices = explode(' ', $request->input('select_sort'));
            $sort_query[$slices[0]] = $slices[1];
            $sorted = $request->input('select_sort');
        }
        
        $category_id = $request->category;

        if ($category_id !== null) {
            $shops = Shop::where('category_id', $category_id)->sortable($sort_query)->orderBy('created_at', 'desc')->paginate(15);
            $total_count = Shop::where('category_id', $request->category)->count();
            $category = Category::find($category_id);
        } elseif ($keyword !== null) {
            $shops = Shop::where('name', 'like', "%{$keyword}%")->sortable($sort_query)->orderBy('created_at', 'desc')->paginate(15);
            $total_count = $shops->total();
            $category = null;
        } else {
            $shops = Shop::sortable($sort_query)->orderBy('created_at', 'desc')->paginate(15);
            $total_count = $shops->total();
            $category = null;
        }

        $shops->getCollection()->transform(function ($shop) {
            $shop->average_score = round($shop->reviews->avg('score'), 1);
            return $shop;
        });

        $categories = Category::all();
        
        return view('shops.index', compact('shops', 'total_count', 'category', 'keyword', 'categories', 'sorts', 'sorted'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        $shop->load('category');
        
        $reviews = $shop->reviews()->paginate(5);

        $holidayLabels = [
            'monday' => '月',
            'tuesday' => '火',
            'wednesday' => '水',
            'thursday' => '木',
            'friday' => '金',
            'saturday' => '土',
            'sunday' => '日',
            'none' => '定休日なし',
        ];
        $holidays = explode(',', $shop->holiday);
        $holidays = array_map(fn($h) => $holidayLabels[$h] ?? $h, $holidays);

        $reviews = $shop->reviews()->get();
        $averageScore = round($shop->reviews()->avg('score') ?? 0, 1);
        
        return view('shops.show', compact('shop', 'reviews', 'holidays', 'averageScore'));
    }
}
