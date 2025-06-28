<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Master;

class MasterController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');
        $query = Master::query();

        if (!empty($keyword)) {
            $query->where('email', 'like', "%{$keyword}%");
        }

        $masters = $query->sortable()->paginate(10);
        $total_count = $masters->total();

        return view('admin.masters.index', compact('keyword', 'masters', 'total_count'));
    }

    public function update(Request $request, Master $master)
    {
        $master->role = $request->input('role');
        $master->update();

        return redirect()->route('admin.masters.index')->with('flash_message', '管理者権限の変更が完了しました。');
    }

    public function destroy(Master $master)
    {
        $master->delete();

        return redirect()->route('admin.masters.index')->with('flash_message', '管理者の削除が完了しました。');
    }
}
