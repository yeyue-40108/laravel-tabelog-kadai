<?php

namespace Tests\Feature\Admin;

use App\Models\Master;
use App\Models\User;
use App\Models\Shop;
use App\Models\Category;
use App\Models\Price;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\PricesTableSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_shops_index()
    {
        $response = $this->get(route('admin.shops.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_shops_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.shops.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_can_access_admin_shops_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.shops.index'));

        $response->assertStatus(200);
    }

    public function test_manager_can_access_admin_shops_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.shops.index'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_shops_show()
    {
        $master = Master::factory()->create();
        $this->seed([
            CategoriesTableSeeder::class,
            PricesTableSeeder::class,
        ]);

        $category = Category::first();
        $price = Price::first();
        $shop = Shop::factory()->create([
            'category_id' => $category->id,
            'price_id' => $price->id,
            'master_id' => $master->id,
        ]);

        $response = $this->get(route('admin.shops.show', $shop));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_shops_show()
    {
        $user = User::factory()->create();
        $master = Master::factory()->create();
        $this->seed([
            CategoriesTableSeeder::class,
            PricesTableSeeder::class,
        ]);

        $category = Category::first();
        $price = Price::first();
        $shop = Shop::factory()->create([
            'category_id' => $category->id,
            'price_id' => $price->id,
            'master_id' => $master->id,
        ]);

        $response = $this->actingAs($user)->get(route('admin.shops.show', $shop));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_manager_can_access_admin_shops_show()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $this->seed([
            CategoriesTableSeeder::class,
            PricesTableSeeder::class,
        ]);

        $category = Category::first();
        $price = Price::first();
        $shop = Shop::factory()->create([
            'category_id' => $category->id,
            'price_id' => $price->id,
            'master_id' => $master->id,
        ]);

        $response = $this->actingAs($master, 'admin')->get(route('admin.shops.show', $shop));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_shops_create()
    {
        $response = $this->get(route('admin.shops.create'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_shops_create()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.shops.create'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_can_access_admin_shops_create()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.shops.create'));

        $response->assertStatus(200);
    }

    public function test_manager_can_access_admin_shops_create()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.shops.create'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_shops_store()
    {
        $master = Master::factory()->create();
        $this->seed([
            CategoriesTableSeeder::class,
            PricesTableSeeder::class,
        ]);

        $category = Category::first();
        $price = Price::first();

        $shop_data = [
            'name' => 'テスト',
            'description' => 'テスト',
            'postal_code' => '0000000',
            'address' => 'テスト',
            'phone' => '0000000000',
            'category_id' => $category->id,
            'open_time' => '10:00',
            'close_time' => '20:00',
            'price_id' => $price->id,
            'master_id' => $master->id
        ];

        $response = $this->post(route('admin.shops.store'), $shop_data);

        $this->assertDatabaseMissing('shops', $shop_data);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_shops_store()
    {
        $user = User::factory()->create();
        $master = Master::factory()->create();

        $this->seed([
            CategoriesTableSeeder::class,
            PricesTableSeeder::class,
        ]);

        $category = Category::first();
        $price = Price::first();

        $shop_data = [
            'name' => 'テスト',
            'description' => 'テスト',
            'postal_code' => '0000000',
            'address' => 'テスト',
            'phone' => '0000000000',
            'category_id' => $category->id,
            'open_time' => '10:00',
            'close_time' => '20:00',
            'price_id' => $price->id,
            'master_id' => $master->id
        ];

        $response = $this->actingAs($user)->post(route('admin.shops.store'), $shop_data);

        $this->assertDatabaseMissing('shops', $shop_data);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_can_access_admin_shops_store()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $this->seed([
            CategoriesTableSeeder::class,
            PricesTableSeeder::class,
        ]);

        $category = Category::first();
        $price = Price::first();

        $shop_data = [
            'name' => 'テスト',
            'description' => 'テスト',
            'postal_code' => '0000000',
            'address' => 'テスト',
            'phone' => '0000000000',
            'category_id' => $category->id,
            'open_time' => '10:00',
            'close_time' => '20:00',
            'price_id' => $price->id,
            'master_id' => $master->id
        ];

        $response = $this->actingAs($master, 'admin')->post(route('admin.shops.store'), $shop_data);

        $this->assertDatabaseHas('shops', $shop_data);
        $response->assertRedirect(route('admin.shops.index'));
    }

    public function test_manager_can_access_admin_shops_store()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $this->seed([
            CategoriesTableSeeder::class,
            PricesTableSeeder::class,
        ]);

        $category = Category::first();
        $price = Price::first();

        $shop_data = [
            'name' => 'テスト',
            'description' => 'テスト',
            'postal_code' => '0000000',
            'address' => 'テスト',
            'phone' => '0000000000',
            'category_id' => $category->id,
            'open_time' => '10:00',
            'close_time' => '20:00',
            'price_id' => $price->id,
            'master_id' => $master->id
        ];

        $response = $this->actingAs($master, 'admin')->post(route('admin.shops.store'), $shop_data);

        $this->assertDatabaseHas('shops', $shop_data);
        $response->assertRedirect(route('admin.shops.index'));
    }

    public function test_guest_cannot_access_admin_shops_edit()
    {
        $shop = Shop::factory()->create();

        $response = $this->get(route('admin.shops.edit', $shop));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_shops_edit()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.shops.edit', $shop));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_manager_can_access_admin_shops_edit()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $shop = Shop::factory()->create();

        $response = $this->actingAs($master, 'admin')->get(route('admin.shops.edit', $shop));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_shops_update()
    {
        $master = Master::factory()->create();
        $this->seed([
            CategoriesTableSeeder::class,
            PricesTableSeeder::class,
        ]);

        $category = Category::first();
        $price = Price::first();
        $old_shop = Shop::factory()->create([
            'category_id' => $category->id,
            'price_id' => $price->id,
        ]);

        $new_shop_data = [
            'name' => 'テスト更新',
            'description' => 'テスト更新',
            'postal_code' => '1234567',
            'address' => 'テスト更新',
            'phone' => '1234567890',
            'category_id' => $category->id,
            'open_time' => '13:00',
            'close_time' => '23:00',
            'price_id' => $price->id,
            'master_id' => $master->id
        ];

        $response = $this->patch(route('admin.shops.update', $old_shop), $new_shop_data);

        $this->assertDatabaseMissing('shops', $new_shop_data);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_shops_update()
    {
        $user = User::factory()->create();
        $master = Master::factory()->create();
        $this->seed([
            CategoriesTableSeeder::class,
            PricesTableSeeder::class,
        ]);

        $category = Category::first();
        $price = Price::first();
        $old_shop = Shop::factory()->create([
            'category_id' => $category->id,
            'price_id' => $price->id,
        ]);

        $new_shop_data = [
            'name' => 'テスト更新',
            'description' => 'テスト更新',
            'postal_code' => '1234567',
            'address' => 'テスト更新',
            'phone' => '1234567890',
            'category_id' => $category->id,
            'open_time' => '13:00',
            'close_time' => '23:00',
            'price_id' => $price->id,
            'master_id' => $master->id
        ];

        $response = $this->actingAs($user)->patch(route('admin.shops.update', $old_shop), $new_shop_data);

        $this->assertDatabaseMissing('shops', $new_shop_data);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_manager_can_access_admin_shops_update()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();
        
        $this->seed([
            CategoriesTableSeeder::class,
            PricesTableSeeder::class,
        ]);

        $category = Category::first();
        $price = Price::first();
        $old_shop = Shop::factory()->create([
            'category_id' => $category->id,
            'price_id' => $price->id,
        ]);

        $new_shop_data = [
            'name' => 'テスト更新',
            'description' => 'テスト更新',
            'postal_code' => '1234567',
            'address' => 'テスト更新',
            'phone' => '1234567890',
            'category_id' => $category->id,
            'open_time' => '13:00',
            'close_time' => '23:00',
            'price_id' => $price->id,
            'master_id' => $master->id
        ];

        $response = $this->actingAs($master, 'admin')->patch(route('admin.shops.update', $old_shop), $new_shop_data);

        $this->assertDatabaseHas('shops', $new_shop_data);
        $response->assertRedirect(route('admin.shops.show', $old_shop));
    }

    public function test_guest_cannot_access_admin_shops_destroy()
    {
        $shop = Shop::factory()->create();

        $response = $this->delete(route('admin.shops.destroy', $shop));

        $this->assertDatabaseHas('shops', ['id' => $shop->id]);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_shops_destroy()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.shops.destroy', $shop));

        $this->assertDatabaseHas('shops', ['id' => $shop->id]);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_manager_can_access_admin_shops_destroy()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $shop = Shop::factory()->create();

        $response = $this->actingAs($master, 'admin')->delete(route('admin.shops.destroy', $shop));

        $this->assertDatabaseMissing('shops', ['id' => $shop->id]);
        $response->assertRedirect(route('admin.shops.index'));
    }
}
