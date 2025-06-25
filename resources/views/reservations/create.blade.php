@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mb-4">
                <a href="{{ route('shops.show', $shop->id) }}">< 店舗詳細ページに戻る</a>
            </div>
            <div>
                <h1>{{ $shop->name }}の予約</h1>
                <hr>
                @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h2 class="mb-3">{{ $shop->name }}</h2>
                <div class="mx-3 mb-3">
                    <div class="d-flex">
                        ※定休日：
                        @php
                            $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
                        @endphp
                        
                        @forelse ($shop->holidays as $holiday)
                            <span class="mx-1">{{ $weekdays[$holiday->weekday] }}</span>
                        @empty
                            <span>なし</span>
                        @endforelse
                    </div>
                    <div>※営業時間：{{ $shop->open_time }} ~ {{ $shop->close_time }}</div>
                </div>
                <form action="{{ route('reservations.store', $shop->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="reservation_date" class="form-label">予約日（予約可能日：翌日～2か月先まで）</label>
                        <input type="date" name="reservation_date" id="reservation_date" class="form-control" min="{{ now()->addDay()->toDateString() }}" max="{{ now()->addMonth(2)->toDateString() }}" value="{{ old('reservation_date') }}" required>
                        @error('reservation_date') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="reservation_time" class="form-label">予約時間（予約可能時間：開店時間～閉店2時間前まで）</label>
                        @php
                            use Carbon\Carbon;
                            $start = Carbon::createFromTimeString($shop->open_time);
                            $end = Carbon::createFromTimeString($shop->close_time);

                            if ($end->lte($start)) {
                                $end->addDay();
                            }

                            $lastTime = $end->copy()->subHours(2);

                            $timeOptions = [];
                            $current = $start->copy();
                            while ($current <= $lastTime) {
                                $timeOptions[] = $current->format('H:i');
                                $current->addMinutes(30);
                            }
                        @endphp
                        <select name="reservation_time" id="reservation_time" class="form-control" required>
                            @foreach ($timeOptions as $time)
                                <option value="{{ $time }}" {{ old('reservation_time') == $time ? 'selected' : '' }}>
                                    {{ $time }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="people" class="form-label">予約人数（最大10名まで）</label>
                        <input type="number" name="people" id="people" class="form-control" min="1" max="10" value="{{ old('people', 1) }}" required>
                        @error('people') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <label class="mb-3">
                        <input type="checkbox" id="reservation_confirm">
                        ご登録いただいているお名前と電話番号を予約店舗へ共有させていただきます。同意いただける場合はチェックをしてください。
                    </label>
                    <hr>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success w-50" id="submit_button" disabled>予約する</button>
                    </div>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const holidays = @json($holidays);
                        const dateInput = document.getElementById('reservation_date');
                        const checkbox = document.getElementById('reservation_confirm');
                        const button = document.getElementById('submit_button');

                        dateInput.addEventListener('change', function() {
                            const selectedDate = new Date(this.value);
                            const day = selectedDate.getDay();

                            if (holidays.includes(day)) {
                                alert('この日は定休日です。別の日を選んでください。');
                                this.value = '';
                            }
                        });

                        checkbox.addEventListener('change', function() {
                            button.disabled = !this.checked;
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection