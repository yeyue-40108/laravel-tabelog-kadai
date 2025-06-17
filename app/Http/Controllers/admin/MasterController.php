<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master;

class MasterController extends Controller
{
    public function mypage()
    {
        $master = Auth::master();

        return view('masters.mypage', compact('master'));
    }
}
