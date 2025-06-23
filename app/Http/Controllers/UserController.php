<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();

        return view('users.mypage', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = Auth::user();

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = Auth::user();

        $user->name = $request->input('name') ? $request->input('name') : $user->name;
        $user->furigana = $request->input('furigana') ? $request->input('furigana') : $user->furigana;
        $user->email = $request->input('email') ? $request->input('email') : $user->email;
        $user->phone = $request->input('phone') ? $request->input('phone') : $user->phone;
        $user->birthday = $request->input('birthday') ? $request->input('birthday') : $user->birthday;
        $user->work = $request->input('work') ? $request->input('work') : $user->work;
        $user->update();

        return redirect()->route('mypage')->with('flash_message', '登録情報を編集しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Auth::user()->delete();
        return redirect()->route('top')->with('flash_message', '退会しました。');
    }

    public function favorite()
    {
        $user = Auth::user();

        $favorite_shops = $user->favorite_shops;

        return view('users.favorite', compact('favorite_shops'));
    }

    public function update_password(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        if ($request->input('password') == $request->input('password_confirmation')) {
            $user->password = bcrypt($request->input('password'));
            $user->update();
        } else {
            return to_route('mypage.edit_password');
        }

        return redirect()->route('mypage')->with('flash_message', 'パスワードを変更しました。');
    }

    public function edit_password()
    {
        return view('users.edit_password');
    }

    public function update_paid(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'phone' => 'required|string|max:20',
            'birthday' => 'required|date|before_or_equal:today',
            'work' => 'required',
        ], [
            'birthday.before_or_equal' => '生年月日には今日以前の日付を入力してください。',
        ]);

        $user = Auth::user();
        
        $user->phone = $validatedData['phone'];
        $user->birthday = $validatedData['birthday'];
        $user->work = $validatedData['work'];
        $user->update();
        
        return to_route('subscription.create');
    }

    public function edit_paid(User $user)
    {
        $user = Auth::user();

        return view('users.edit_paid', compact('user'));
    }
}
