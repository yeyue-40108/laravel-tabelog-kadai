<?php

namespace Tests\Feature\Admin;

use App\Models\Master;
use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Carbon;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_reservations_index()
    {
        $response = $this->get(route('admin.reservations.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_reservations_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.reservations.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_can_access_admin_reservations_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.reservations.index'));

        $response->assertStatus(200);
    }

    public function test_manager_can_access_admin_reservations_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.reservations.index'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_reservations_show()
    {
        $shop = Shop::factory()->create([
            'open_time' => '10:00',
            'close_time' => '20:00',
        ]);
        $user = User::factory()->create();
        $reservation = Reservation::create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay(),
            'reservation_time' => '12:00',
        ]);

        $response = $this->get(route('admin.reservations.show', $reservation));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_reservations_show()
    {
        $shop = Shop::factory()->create([
            'open_time' => '10:00',
            'close_time' => '20:00',
        ]);
        $user = User::factory()->create();
        $reservation = Reservation::create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay(),
            'reservation_time' => '12:00',
        ]);

        $response = $this->actingAs($user)->get(route('admin.reservations.show', $reservation));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_manager_can_access_admin_reservations_show()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $shop = Shop::factory()->create([
            'open_time' => '10:00',
            'close_time' => '20:00',
        ]);
        $user = User::factory()->create();
        $reservation = Reservation::create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay(),
            'reservation_time' => '12:00',
        ]);

        $response = $this->actingAs($master, 'admin')->get(route('admin.reservations.show', $reservation));

        $response->assertStatus(200);
    }
}
