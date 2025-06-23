<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $master = auth('admin')->user();
        $keyword = $request->query('keyword');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        $query = Reservation::with(['user', 'shop']);

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('user', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', "%{$keyword}%");
                })
                ->orWhereHas('shop', function ($q2) use ($keyword) {
                    $q2->where('name', 'like', "%{$keyword}%");
                });
            });
        }

        if (!empty($start_date)) {
            $query->whereDate('reservation_date', '>=', $start_date);
        }
        
        if (!empty($end_date)) {
            $query->whereDate('reservation_date', '<=', $end_date);
        }

        if ($master->role === 'shop_manager') {
            $shop_ids = Shop::where('master_id', $master->id)->pluck('id');
            $query->whereIn('shop_id', $shop_ids);
        }

        $reservations = $query->sortable()->paginate(10);
        $total_count = $reservations->total();
        
        return view('admin.reservations.index', compact('reservations', 'master', 'total_count', 'keyword', 'start_date', 'end_date'));
    }

    public function show($id)
    {
        $reservation = Reservation::with('shop')->findorFail($id);
        
        return view('admin.reservations.show', compact('reservation'));
    }
}
