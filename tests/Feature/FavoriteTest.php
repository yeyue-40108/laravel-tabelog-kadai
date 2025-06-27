<?php

namespace Tests\Feature;

use App\Models\Master;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_favorites_store()
    {
        $shop = Shop::factory()->create();

        $response = $this->post(route('favorites.store', $shop->id));

        $this->assertDatabaseMissing('shop_user', ['shop_id' => $shop->id]);
        $response->assertRedirect(route('login'));
    }

    public function test_free_user_cannot_access_favorites_store()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);
        $shop = Shop::factory()->create();

        $response = $this->actingAs($user)->post(route('favorites.store', $shop->id));

        $this->assertDatabaseMissing('shop_user', ['shop_id' => $shop->id, 'user_id' => $user->id]);
        $response->assertStatus(403);
    }

    public function test_paid_user_can_access_favorites_store()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);

        $shop = Shop::factory()->create();

        $response = $this->actingAs($user)->from(route('shops.show', $shop))->post(route('favorites.store', $shop->id));

        $this->assertDatabaseHas('shop_user', ['shop_id' => $shop->id, 'user_id' => $user->id]);
        $response->assertRedirect(route('shops.show', $shop));
    }

    public function test_manager_cannot_access_favorites_store()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $shop = Shop::factory()->create();

        $response = $this->actingAs($master, 'admin')->post(route('favorites.store', $shop->id));

        $this->assertDatabaseMissing('shop_user', ['shop_id' => $shop->id]);
        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_favorites_destroy()
    {
        $shop = Shop::factory()->create();
        $user = User::factory()->create();

        $user->favorite_shops()->attach($shop->id);

        $response = $this->delete(route('favorites.destroy', $shop->id));

        $this->assertDatabaseHas('shop_user', ['shop_id' => $shop->id, 'user_id' => $user->id]);
        $response->assertRedirect(route('login'));
    }

    public function test_free_user_cannot_access_favorites_destroy()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);
        $shop = Shop::factory()->create();

        $user->favorite_shops()->attach($shop->id);

        $response = $this->actingAs($user)->delete(route('favorites.destroy', $shop->id));

        $this->assertDatabaseHas('shop_user', ['shop_id' => $shop->id, 'user_id' => $user->id]);
        $response->assertStatus(403);
    }

    public function test_paid_user_can_access_favorites_destroy()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);

        $shop = Shop::factory()->create();

        $user->favorite_shops()->attach($shop->id);

        $response = $this->actingAs($user)->from(route('shops.show', $shop))->delete(route('favorites.destroy', $shop->id));

        $this->assertDatabaseMissing('shop_user', ['shop_id' => $shop->id, 'user_id' => $user->id]);
        $response->assertRedirect(route('shops.show', $shop));
    }

    public function test_manager_cannot_access_favorites_destroy()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $shop = Shop::factory()->create();
        $user = User::factory()->create();

        $user->favorite_shops()->attach($shop->id);

        $response = $this->actingAs($master, 'admin')->delete(route('favorites.destroy', $shop->id));

        $this->assertDatabaseHas('shop_user', ['shop_id' => $shop->id, 'user_id' => $user->id]);
        $response->assertRedirect(route('admin.web.index'));
    }
}
