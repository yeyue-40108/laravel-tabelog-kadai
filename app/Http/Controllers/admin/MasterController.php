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

        $masters = $query->sortable()->paginate(15);
        $total_count = $masters->total();

        return view('admin.masters.index', compact('keyword', 'masters', 'total_count'));
    }

    public function create()
    {
        return view('admin.masters.create');
    }

    public function store()
    {
        //
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
    
    public function edit_email()
    {
        $master = Auth::guard('admin')->user();

        return view('admin.masters.edit_email', compact('master'));
    }

    public function update_email(Request $request, Master $master)
    {
        $master = Auth::guard('admin')->user();

        $master->email = $request->input('email');
        $master->update();

        return redirect()->route('admin.web.index')->with('flash_message', '登録情報を編集しました。');
    }

    public function edit_password()
    {
        return view('admin.masters.edit_password');
    }

    public function update_password(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|confirmed',
        ]);

        $master = Auth::guard('admin')->user();

        if ($request->input('password') == $request->input('password_confirmation')) {
            $master->password = bcrypt($request->input('password'));
            $master->update();
        } else {
            return to_route('admin.masters.edit_password');
        }

        return redirect()->route('admin.web.index')->with('flash_message', 'パスワードを変更しました。');
    }
}
