<?php

namespace Tests\Feature\Admin;

use App\Models\Master;
use App\Models\User;
use App\Models\Category;
use Database\Seeders\CategoriesTableSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_categories_index()
    {
        $response = $this->get(route('admin.categories.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_categories_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.categories.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_cannot_access_admin_categories_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.categories.index'));

        $response->assertStatus(403);
    }

    public function test_manager_can_access_admin_categories_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.categories.index'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_categories_store()
    {
        $category_data = [
            'name' => 'テスト',
        ];

        $response = $this->post(route('admin.categories.store'), $category_data);

        $this->assertDatabaseMissing('categories', $category_data);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_categories_store()
    {
        $user = User::factory()->create();
        $category_data = [
            'name' => 'テスト',
        ];

        $response = $this->actingAs($user)->post(route('admin.categories.store'), $category_data);

        $this->assertDatabaseMissing('categories', $category_data);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_cannot_access_admin_categories_store()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();
        $category_data = [
            'name' => 'テスト',
        ];

        $response = $this->actingAs($master, 'admin')->post(route('admin.categories.store'), $category_data);

        $this->assertDatabaseMissing('categories', $category_data);
        $response->assertStatus(403);
    }

    public function test_manager_can_access_admin_categories_store()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();
        $category_data = [
            'name' => 'テスト',
        ];

        $response = $this->actingAs($master, 'admin')->post(route('admin.categories.store'), $category_data);

        $this->assertDatabaseHas('categories', $category_data);
        $response->assertRedirect(route('admin.categories.index'));
    }

    public function test_guest_cannot_access_admin_categories_update()
    {
        $this->seed([
            CategoriesTableSeeder::class,
        ]);

        $old_category = Category::first();
        $new_category_data = [
            'name' => 'テスト更新',
        ];

        $response = $this->patch(route('admin.categories.update', $old_category), $new_category_data);

        $this->assertDatabaseMissing('categories', $new_category_data);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_categories_update()
    {
        $user = User::factory()->create();
        
        $this->seed([
            CategoriesTableSeeder::class,
        ]);

        $old_category = Category::first();
        $new_category_data = [
            'name' => 'テスト更新',
        ];

        $response = $this->actingAs($user)->patch(route('admin.categories.update', $old_category), $new_category_data);

        $this->assertDatabaseMissing('categories', $new_category_data);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_cannot_access_admin_categories_update()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();
        
        $this->seed([
            CategoriesTableSeeder::class,
        ]);

        $old_category = Category::first();
        $new_category_data = [
            'name' => 'テスト更新',
        ];

        $response = $this->actingAs($master, 'admin')->patch(route('admin.categories.update', $old_category), $new_category_data);

        $this->assertDatabaseMissing('categories', $new_category_data);
        $response->assertStatus(403);
    }

    public function test_manager_can_access_admin_categories_update()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $this->seed([
            CategoriesTableSeeder::class,
        ]);

        $old_category = Category::first();
        $new_category_data = [
            'name' => 'テスト',
        ];

        $response = $this->actingAs($master, 'admin')->patch(route('admin.categories.update', $old_category), $new_category_data);

        $this->assertDatabaseHas('categories', $new_category_data);
        $response->assertRedirect(route('admin.categories.index'));
    }

    public function test_guest_cannot_access_admin_categories_destroy()
    {
        $this->seed([
            CategoriesTableSeeder::class,
        ]);

        $category = Category::first();

        $response = $this->delete(route('admin.categories.destroy', $category));

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_categories_destroy()
    {
        $user = User::factory()->create();
        $this->seed([
            CategoriesTableSeeder::class,
        ]);

        $category = Category::first();

        $response = $this->actingAs($user)->delete(route('admin.categories.destroy', $category));

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_cannot_access_admin_categories_destroy()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();
        $this->seed([
            CategoriesTableSeeder::class,
        ]);

        $category = Category::first();

        $response = $this->actingAs($master, 'admin')->delete(route('admin.categories.destroy', $category));

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
        $response->assertStatus(403);
    }

    public function test_manager_can_access_admin_categories_destroy()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $this->seed([
            CategoriesTableSeeder::class,
        ]);

        $category = Category::first();

        $response = $this->actingAs($master, 'admin')->delete(route('admin.categories.destroy', $category));

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $response->assertRedirect(route('admin.categories.index'));
    }
}
