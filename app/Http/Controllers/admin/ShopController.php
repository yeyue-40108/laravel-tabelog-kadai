<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Category;
use App\Models\Price;
use App\Models\ShopHoliday;
use App\Http\Requests\ShopRequest;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');
        $category_id = $request->query('category');
        $category = null;

        $query = Shop::query();

        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
            $category = Category::find($category_id);
        } 
        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        $shops = $query->sortable()->paginate(15);
        $total_count = $shops->total();
        
        return view('admin.shops.index', compact('shops', 'total_count', 'keyword', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $prices = Price::all();

        return view('admin.shops.create', compact('categories', 'prices'));
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopRequest $request)
    {
        $validated = $request->validated();

        $shop = Shop::create($validated);

        foreach ($validated['weekdays'] ?? [] as $weekday) {
            $shop->holidays()->create(['weekday' => $weekday]);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = Storage::disk('public')->putFile('img', $file);
        }

        foreach ($validated['weekdays'] ?? [] as $weekday) {
            $shop->holidays()->create([
                'weekday' => $weekday,
            ]);
        }

        return redirect()->route('admin.shops.index')->with('flash_message', '店舗の作成が完了しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        $shop->load(['category', 'holidays']);
        
        return view('admin.shops.show', compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        $categories = Category::all();
        $prices = Price::all();
        
        return view('admin.shops.edit', compact('shop', 'categories', 'prices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(ShopRequest $request, Shop $shop)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = Storage::disk('public')->putFile('img', $file);
        }

        $shop->holidays()->delete();

        foreach ($validated['weekdays'] ?? [] as $weekday) {
            if (is_numeric($weekday) && $weekday >= 0 && $weekday <= 6) {
                $shop->holidays()->create(['weekday' => (int)$weekday]);
            }
        }

        $shop->update($validated);

        return redirect()->route('admin.shops.show', $shop)->with('flash_message', '店舗情報を編集しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        $shop->delete();

        return redirect()->route('admin.shops.index')->with('flash_message', '店舗を削除しました。');
    }
}
