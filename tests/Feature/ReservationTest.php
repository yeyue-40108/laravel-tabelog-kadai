<?php

namespace Tests\Feature;

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

    public function test_guest_cannot_access_reservations_index()
    {
        $response = $this->get(route('reservations.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_free_user_cannot_access_reservations_index()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $response = $this->actingAs($user)->get(route('reservations.index'));

        $response->assertStatus(403);
    }

    public function test_paid_user_can_access_reservations_index()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);

        $response = $this->actingAs($user)->get(route('reservations.index'));

        $response->assertStatus(200);
    }

    public function test_manager_cannot_access_reservations_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('reservations.index'));

        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_reservations_create()
    {
        $shop = Shop::factory()->create();

        $response = $this->get(route('reservations.create', $shop));

        $response->assertRedirect(route('login'));
    }

    public function test_free_user_cannot_access_reservations_create()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $shop = Shop::factory()->create();

        $response = $this->actingAs($user)->get(route('reservations.create', $shop));

        $response->assertStatus(403);
    }

    public function test_paid_user_can_access_reservations_create()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $shop = Shop::factory()->create();

        $response = $this->actingAs($user)->get(route('reservations.create', $shop));

        $response->assertStatus(200);
    }

    public function test_manager_cannot_access_reservations_create()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $shop = Shop::factory()->create();

        $response = $this->actingAs($master, 'admin')->get(route('reservations.create', $shop));

        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_reservations_store()
    {
        $shop = Shop::factory()->create([
            'open_time' => '10:00',
            'close_time' => '20:00',
        ]);
        $user = User::factory()->create();

        $reservation_data = [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00',
        ];

        $response = $this->post(route('reservations.store', $shop), $reservation_data);

        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00',
        ]);
        $response->assertRedirect(route('login'));
    }

    public function test_free_user_cannot_access_reservations_store()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $shop = Shop::factory()->create([
            'open_time' => '10:00',
            'close_time' => '20:00',
        ]);

        $reservation_data = [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00',
        ];

        $response = $this->actingAs($user)->post(route('reservations.store', $shop), $reservation_data);

        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00',
        ]);
        $response->assertStatus(403);
    }

    public function test_paid_user_can_access_reservations_store()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $shop = Shop::factory()->create([
            'open_time' => '10:00',
            'close_time' => '20:00',
        ]);

        $reservation_data = [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00',
        ];

        $response = $this->actingAs($user)->post(route('reservations.store', $shop), $reservation_data);

        $this->assertDatabaseHas('reservations', [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00',
        ]);
        $response->assertRedirect(route('reservations.index'));
    }

    public function test_manager_cannot_access_reservations_store()
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

        $reservation_data = [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00',
        ];

        $response = $this->actingAs($master, 'admin')->post(route('reservations.store', $shop), $reservation_data);

        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00',
        ]);
        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_reservations_destroy()
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
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00:00',
        ]);

        $response = $this->delete(route('reservations.destroy', $reservation));

        $this->assertDatabaseHas('reservations', [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00:00',
        ]);
        $response->assertRedirect(route('login'));
    }

    public function test_free_user_cannot_access_reservations_destroy()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $shop = Shop::factory()->create([
            'open_time' => '10:00',
            'close_time' => '20:00',
        ]);
        $reservation = Reservation::create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00:00',
        ]);

        $response = $this->actingAs($user)->delete(route('reservations.destroy', $reservation));

        $this->assertDatabaseHas('reservations', [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00:00',
        ]);
        $response->assertStatus(403);
    }

    public function test_paid_user_can_access_reservations_destroy()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $shop = Shop::factory()->create([
            'open_time' => '10:00',
            'close_time' => '20:00',
        ]);
        $reservation = Reservation::create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00:00',
        ]);

        $response = $this->actingAs($user)->delete(route('reservations.destroy', $reservation));

        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00:00',
        ]);
        $response->assertRedirect(route('reservations.index'));
    }

    public function test_manager_cannot_access_reservations_destroy()
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
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00:00',
        ]);

        $response = $this->actingAs($master, 'admin')->delete(route('reservations.destroy', $reservation));

        $this->assertDatabaseHas('reservations', [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'people' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' => '12:00:00',
        ]);
        $response->assertRedirect(route('admin.web.index'));
    }
}
