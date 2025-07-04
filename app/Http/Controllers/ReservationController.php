<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Shop;
use App\Models\ShopHoliday;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $now = Carbon::now();
        $type = $request->query('type', 'future');

        $query = Reservation::where('user_id', auth()->id())
            ->with('shop')
            ->orderBy('reservation_date')
            ->orderBy('reservation_time');

        if ($type === 'past') {
            $query->whereRaw("STR_TO_DATE(CONCAT(reservation_date, ' ' , reservation_time), '%Y-%m-%d %H:%i') < ?", [$now])
            ->orderBy('reservation_date')
            ->orderBy('reservation_time');
        } else {
            $query->whereRaw("STR_TO_DATE(CONCAT(reservation_date, ' ' , reservation_time), '%Y-%m-%d %H:%i') >= ?", [$now]);
        }

        $reservations = $query->paginate(10)->withQueryString();
        
        return view('reservations.index', compact('reservations', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($shopId)
    {
        $shop = Shop::findOrFail($shopId);

        $holidays = ShopHoliday::where('shop_id', $shop->id)->pluck('weekday')->toArray();
        
        return view('reservations.create', compact('shop', 'holidays'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $shopId)
    {
        $shop = Shop::findOrFail($shopId);

        $request->validate([
            'reservation_date' => 'required|date|after:today',
            'reservation_time' => 'required|date_format:H:i',
            'people' => 'required|integer|between:1,10',
        ]);

        $date = Carbon::parse($request->reservation_date);
        $time = Carbon::parse($request->reservation_time);

        $weekday = $date->dayOfWeek;
        $isHoliday = ShopHoliday::where('shop_id', $shopId)->where('weekday', $weekday)->exists();
        if ($isHoliday) {
            return back()->withErrors(['reservation_date' => 'この日は定休日です。'])->withInput();
        }

        $maxDate = now()->addMonth(2)->startOfDay();
        if ($date->gt($maxDate)) {
            return back()->withErrors(['reservation_date' => '予約日は2か月先以内にしてください。'])->withInput();
        }

        $open = Carbon::createFromTimeString($shop->open_time);
        $close = Carbon::createFromTimeString($shop->close_time);

        $spansNextDay = $close->lte($open);
        if ($spansNextDay) {
            $close->addDay();
        }

        $openDateTime = $date->copy()->setTimeFrom($open);
        $lastTime = $close->copy()->subHours(2);
        $lastDateTime = $date->copy()->setTimeFrom($lastTime);

        if ($spansNextDay || $lastDateTime->lt($openDateTime)) {
            $lastDateTime->addDay();
        }

        $reservationDateTime = $date->copy()->setTimeFrom($time);
        if ($spansNextDay && $time->lt($open)) {
            $reservationDateTime->addDay();
        }

        if ($reservationDateTime->lt($openDateTime) || $reservationDateTime->gt($lastDateTime)) {
            return back()->withErrors(['reservation_time' => '営業時間内で、閉店2時間前までに予約してください。'])->withInput();
        }

        if (!in_array($time->minute, [0, 30])) {
            return back()->withErrors(['reservation_time' => '予約時間は30分単位で指定してください（例：12:00, 12:30）。'])->withInput();
        }
        
        $startTime = $reservationDateTime;
        $endTime = $startTime->copy()->addHours(2);
        $conflict = Reservation::where('shop_id', $shopId)
            ->where('reservation_date', $date->toDateString())
            ->whereTime('reservation_time', '>=', $startTime->format('H:i'))
            ->whereTime('reservation_time', '<', $endTime->format('H:i'))
            ->exists();
        
        if ($conflict) {
            return back()->withErrors(['reservation_time' => 'この時間帯はすでに予約があります。'])->withInput();
        }

        Reservation::create([
            'shop_id' => $shopId,
            'user_id' => Auth()->id(),
            'reservation_date' => $date->toDateString(),
            'reservation_time' => $time->toTimeString(),
            'people' => $request->people,
        ]);

        return redirect()->route('reservations.index')->with('flash_message', '予約が完了しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')->with('flash_message', '予約をキャンセルしました。');
    }
}
