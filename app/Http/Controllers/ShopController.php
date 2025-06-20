<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Category;
use App\Models\Price;
use App\Models\ShopHoliday;
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
            '新着順' => 'created_at desc',
            '高評価順' => 'reviews_avg_score desc',
        ];

        $sorted = $request->input('select_sort', 'created_at desc');
        $slices = explode(' ', $sorted);
        $column = $slices[0];
        $direction = $slices[1] ?? 'desc';
        
        $category_id = $request->category;
        $price_id = $request->price;

        $query = Shop::withAvg('reviews', 'score');

        $weekday = null;
        if ($request->filled('weekday')) {
            $weekday = (int)$request->input('weekday');
            $query->whereDoesntHave('holidays', function($q) use ($weekday) {
                $q->where('weekday', $weekday);
            });
        }

        $inputTime = null;
        if ($request->filled('time')) {
            $inputTime = $request->input('time');
            $query->where('open_time', '<=', $inputTime)->where('close_time', '>', $inputTime);
        }

        if ($category_id !== null) {
            $query->where('category_id', $category_id);
            $category = Category::find($category_id);
            $price = null;
            $total_count = Shop::where('category_id', $category_id)->count();
        } elseif ($price_id !== null) {
            $query->where('price_id', $price_id);
            $category = null;
            $price = Price::find($price_id);
            $total_count = Shop::where('price_id', $price_id)->count();
        }elseif ($keyword !== null) {
            $query->where('name', 'like', "%{$keyword}%");
            $category = null;
            $price = null;
        } else {
            $category = null;
            $price = null;
        }

        $shops = $query->orderBy($column, $direction)->paginate(15);
        $total_count = $total_count ?? $shops->total();

        $shops->getCollection()->transform(function ($shop) {
            $shop->average_score = round($shop->reviews->avg('score'), 1);
            return $shop;
        });

        $categories = Category::all();
        $prices = Price::all();
        
        return view('shops.index', compact('shops', 'total_count', 'category', 'keyword', 'categories', 'sorts', 'sorted', 'price', 'prices', 'weekday', 'inputTime'));
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
