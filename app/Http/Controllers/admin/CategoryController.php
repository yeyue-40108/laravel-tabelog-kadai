<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\shop;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::sortable()->get();
        
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('admin.categories.index')->with('flash_message', '新しいカテゴリを作成しました。');
    }

    public function update(Request $request, Category $category)
    {
        $category->name = $request->input('name');
        $category->update();

        return redirect()->route('admin.categories.index')->with('flash_message', 'カテゴリ名を編集しました。');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('flash_message', 'カテゴリを削除しました。');
    }
}
