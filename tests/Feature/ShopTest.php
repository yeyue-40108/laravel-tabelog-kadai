<?php

namespace Tests\Feature;

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

    public function test_guest_cannot_access_shops_index()
    {
        $response = $this->get(route('shops.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_can_access_shops_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('shops.index'));

        $response->assertStatus(200);
    }

    public function test_manager_cannot_access_shops_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('shops.index'));

        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_shops_show()
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
        
        $response = $this->get(route('shops.show', $shop));

        $response->assertRedirect(route('login'));
    }

    public function test_user_can_access_shops_show()
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

        $response = $this->actingAs($user)->get(route('shops.show', $shop));

        $response->assertStatus(200);
    }

    public function test_manager_cannot_access_shops_show()
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

        $response = $this->actingAs($master, 'admin')->get(route('shops.show', $shop));

        $response->assertRedirect(route('admin.web.index'));
    }
}
