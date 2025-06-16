<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

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
        $user->update();

        return to_route('mypage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
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

        return to_route('mypage');
    }

    public function edit_password()
    {
        return view('users.edit_password');
    }

    public function update_paid(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'phone' => 'required|string|max:20',
            'birthday' => 'required|date_format:Y/m/d',
            'work' => 'required',
        ]);
        
        $stripeCustomer = $user->createOrGetStripeCustomer();
        $user->phone = $request->input('phone');
        $user->birthday = $request->input('birthday');
        $user->work = $request->input('work');
        $user->role = $request->input('role');
        $user->update();
        
        return redirect()->route('mypage')->with('flash_message', '有料会員登録が完了しました。');
    }

    public function edit_paid(User $user)
    {
        $user = Auth::user();

        return view('users.edit_paid', ['intent' => $user->createSetupIntent()], compact('user'));
    }

    public function update_cash(Request $request, User $user)
    {
        $user->updateDefaultPaymentMethod($paymentMethod);
        
        return redirect()->route('mypage')->with('flash_message', 'カード情報の更新が完了しました。');
    }

    public function edit_cash()
    {
        return view('mypage.edit_cash');
    }

    public function update_cancel(Request $request, User $user)
    {
        $paymentMethod->delete();
        $user->role = $request->input('role');
        $user->update();
        
        return redirect()->route('mypage')->with('flash_message', '有料会員の解約が完了しました。');
    }

    public function edit_cancel()
    {
        return view('users.edit_cancel');
    }
}
