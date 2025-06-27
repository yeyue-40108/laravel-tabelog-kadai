<?php

namespace Tests\Feature\Admin;

use App\Models\Master;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_users_index()
    {
        $response = $this->get(route('admin.users.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_users_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_cannot_access_admin_users_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    public function test_manager_can_access_admin_users_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.users.index'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_users_show()
    {
        $user = User::factory()->create();

        $response = $this->get(route('admin.users.show', $user));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_users_show()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.users.show', $user));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_cannot_access_admin_users_show()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $user = User::factory()->create();

        $response = $this->actingAs($master, 'admin')->get(route('admin.users.show', $user));

        $response->assertStatus(403);
    }

    public function test_manager_can_access_admin_users_show()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $user = User::factory()->create();

        $response = $this->actingAs($master, 'admin')->get(route('admin.users.show', $user));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_users_edit()
    {
        $user = User::factory()->create();
        
        $response = $this->get(route('admin.users.edit', $user));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_users_edit()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.users.edit', $user));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_cannot_access_admin_users_edit()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $user = User::factory()->create();

        $response = $this->actingAs($master, 'admin')->get(route('admin.users.edit', $user));

        $response->assertStatus(403);
    }

    public function test_manager_can_access_admin_users_edit()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $user = User::factory()->create();

        $response = $this->actingAs($master, 'admin')->get(route('admin.users.edit', $user));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_users_update()
    {
        $old_user = User::factory()->create();
        $new_user_data = [
            'id' => $old_user->id,
            'email' => $old_user->email,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン',
            'password' => 'password',
            'role' => 'free',
        ];

        $response = $this->patch(route('admin.users.update', $old_user), $new_user_data);

        $this->assertDatabaseMissing('users', [
            'id' => $old_user->id,
            'email' => $old_user->email,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン',
        ]);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_users_update()
    {
        $user = User::factory()->create();
        $old_user = User::factory()->create();
        $new_user_data = [
            'id' => $old_user->id,
            'email' => $old_user->email,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン',
            'password' => 'password',
            'role' => 'free',
        ];

        $response = $this->actingAs($user)->patch(route('admin.users.update', $old_user), $new_user_data);

        $this->assertDatabaseMissing('users', [
            'id' => $old_user->id,
            'email' => $old_user->email,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン',
        ]);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_cannot_access_admin_users_update()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $old_user = User::factory()->create();
        $new_user_data = [
            'id' => $old_user->id,
            'email' => $old_user->email,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン',
            'password' => 'password',
            'role' => 'free',
        ];

        $response = $this->actingAs($master, 'admin')->patch(route('admin.users.update', $old_user), $new_user_data);

        $this->assertDatabaseMissing('users', [
            'id' => $old_user->id,
            'email' => $old_user->email,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン',
        ]);
        $response->assertStatus(403);
    }

    public function test_manager_can_access_admin_users_update()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $old_user = User::factory()->create();
        $new_user_data = [
            'id' => $old_user->id,
            'email' => $old_user->email,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン',
            'password' => 'password',
            'role' => 'free',
        ];

        $response = $this->actingAs($master, 'admin')->patch(route('admin.users.update', $old_user), $new_user_data);

        $this->assertDatabaseHas('users', [
            'id' => $old_user->id,
            'email' => $old_user->email,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン',
        ]);
        $response->assertRedirect(route('admin.users.show', $old_user));
    }

    public function test_guest_cannot_access_admin_users_sales()
    {
        $user = User::factory()->create();

        $response = $this->get(route('admin.users.sales'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_users_sales()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.users.sales'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_cannot_access_admin_users_sales()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.users.sales'));

        $response->assertStatus(403);
    }

    public function test_manager_can_access_admin_users_sales()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.users.sales'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_users_destroy()
    {
        $user = User::factory()->create();

        $response = $this->delete(route('admin.users.destroy', $user));

        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_users_destroy()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.users.destroy', $user));

        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_cannot_access_admin_users_destroy()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $user = User::factory()->create();

        $response = $this->actingAs($master, 'admin')->delete(route('admin.users.destroy', $user));

        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $response->assertStatus(403);
    }

    public function test_manager_can_access_admin_users_destroy()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $user = User::factory()->create();

        $response = $this->actingAs($master, 'admin')->delete(route('admin.users.destroy', $user));

        $this->assertSoftDeleted('users', ['id' => $user->id]);
        $response->assertRedirect(route('admin.users.index'));
    }
}
