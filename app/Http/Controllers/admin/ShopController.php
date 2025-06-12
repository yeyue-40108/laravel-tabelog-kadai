<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Category;

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

        return view('admin.shops.create', compact('categories'));
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $holidays = $request->input('holiday', []);
        
        $shop = new Shop();
        $shop->name = $request->input('name');
        $shop->description = $request->input('description');
        $shop->postal_code = $request->input('postal_code');
        $shop->address = $request->input('address');
        $shop->phone = $request->input('phone');
        $shop->open_time = $request->input('open_time');
        $shop->close_time = $request->input('close_time');
        $shop->holiday = implode(',', $holidays);
        $shop->category_id = $request->input('category_id');
        $shop->price = $request->input('price');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = Storage::disk('public')->putFile('img', $file);
        }
        $shop->save();

        return redirect()->route('web.shops.index')->with('flash_message', '店舗の作成が完了しました。');
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
        
        return view('admin.shops.show', compact('shop', 'holidays'));
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
        
        return view('admin.shops.edit', compact('shop', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        $holidays = $request->input('holiday', []);
        
        $shop->name = $request->input('name');
        $shop->description = $request->input('description');
        $shop->postal_code = $request->input('postal_code');
        $shop->address = $request->input('address');
        $shop->phone = $request->input('phone');
        $shop->open_time = $request->input('open_time');
        $shop->close_time = $request->input('close_time');
        $shop->holiday = implode(',', $holidays);
        $shop->category_id = $request->input('category_id');
        $shop->price = $request->input('price');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = Storage::disk('public')->putFile('img', $file);
        }
        $shop->update();

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
