<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function create()
    {
        $intent = Auth::user()->createSetupIntent();
        
        return view('subscription.create', compact('intent'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        
        $user->newSubscription('paid', env('STRIPE_PAID_ID'))->create($request->paymentMethodId);

        $user->role = 'paid';
        $user->save();
        
        return redirect()->route('mypage')->with('flash_message', '有料会員登録が完了しました。');
    }

    public function edit()
    {
        $user->Auth::user();
        $intent = $user->createSetupIntent();
        
        return view('subscription.edit', compact('user', 'intent'));
    }

    public function update(Request $request)
    {
        $request->user()->updateDefaultPaymentMethod($request->paymentMethodId);

        return redirect()->route('mypage')->with('flash_message', 'お支払いカード情報の変更が完了しました。');
    }

    public function cancel()
    {
        return view('subscription.cancel');
    }

    public function destroy(Request $request)
    {
        $request->user()->subscription('paid')->cancelNow();

        $user->role = 'free';
        $user->save();

        return redirect()->route('mypage')->with('flash_message', '有料会員を解約しました。今後は無料会員としてご利用いただけます。');
    }
}
