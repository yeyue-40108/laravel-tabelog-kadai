<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');

        $query = User::query();

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('furigana', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        $users = $query->sortable()->paginate(15);
        $total_count = $users->total();
        
        return view('admin.users.index', compact('keyword', 'users', 'total_count'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->name = $request->input('name');
        $user->furigana = $request->input('furigana');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->phone = $request->input('phone');
        $user->birthday = $request->input('birthday');
        $user->work = $request->input('work');
        $user->update();

        return redirect()->route('admin.users.show')->with('flash_message', '会員情報の編集が完了しました。');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('flash_message', '会員の退会が完了しました。');
    }
}
