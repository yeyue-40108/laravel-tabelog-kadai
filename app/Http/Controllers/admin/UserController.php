<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

    public function sales(Request $request)
    {
        $query = User::query()->where('role', 'paid');
        $total_count = $query->whereHas('subscriptions', function ($q) {
            $q->where('stripe_status', 'active');
        }) 
        ->count();
        $sales = $total_count * 300;

        $start_year = $request->input('start_year');
        $start_month = $request->input('start_month');
        $end_year = $request->input('end_year');
        $end_month = $request->input('end_month');
        $age = $request->input('age');
        $work = $request->input('work');

        $limit_query = User::query()->where('role', 'paid');

        if (!empty($start_year) && !empty($start_month) && !empty($end_year) && !empty($end_month)) {
            $start_date = Carbon::createFromDate($start_year, $start_month, 1)->startOfMonth();
            $end_date = Carbon::createFromDate($end_year, $end_month, 1)->endOfMonth();
            $limit_query->whereHas('subscriptions', function ($q) use ($start_date, $end_date) {
                $q->whereBetween('created_at', [$start_date, $end_date]);
            });
        } elseif (!empty($start_year) && !empty($start_month)) {
            $start_date = Carbon::createFromDate($start_year, $start_month, 1)->startOfMonth();
            $limit_query->whereHas('subscriptions', function ($q) use ($start_date) {
                $q->where('created_at', '>=', $start_date);
            });
        } elseif (!empty($end_year) && !empty($end_month)) {
            $end_date = Carbon::createFromDate($end_year, $end_month, 1)->endOfMonth();
            $limit_query->whereHas('subscriptions', function ($q) use ($end_date) {
                $q->where('created_at', '<=', $end_date);
            });
        }
        
        if (!empty($age)) {
            $now = Carbon::now();
            $start_age = $age;
            $end_age = $age + 9;

            if ($age == 10) {
                $start_birth = $now->copy()->subYears(10);
                $end_birth = null;
            } elseif ($age == 60) {
                $start_birth = $now->copy()->subYears(69);
                $end_birth = $now->copy()->subYears(60);
            } else {
                $start_birth = $now->copy()->subYears($end_age);
                $end_birth = $now->copy()->subYears($start_age);
            }

            if ($end_birth) {
                $limit_query->whereBetween('birthday', [$start_birth, $end_birth]);
            } else {
                $limit_query->where('birthday', '>=', $start_birth);
            }
        }
        
        if (!empty($work)) {
            $limit_query->where('work', $work);
        }

        $limit_count = $limit_query->count();
        $limit_sales = $limit_count * 300;

        return view('admin.users.sales', compact('total_count', 'sales', 'limit_count', 'limit_sales', 'age', 'work', 'start_year', 'start_month', 'end_year', 'end_month'));
    }
}
