<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class WebController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $keyword = $request->keyword;

        return view('web.index', compact('categories', 'keyword'));
    }
}
