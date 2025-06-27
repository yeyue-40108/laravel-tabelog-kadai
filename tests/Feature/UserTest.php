<?php

namespace Tests\Feature;

use App\Models\Master;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_mypage()
    {
        $response = $this->get(route('mypage'));

        $response->assertRedirect(route('login'));
    }

    public function test_free_user_can_access_mypage()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $response = $this->actingAs($user)->get(route('mypage'));

        $response->assertStatus(200);
    }

    public function test_paid_user_can_access_mypage()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);

        $response = $this->actingAs($user)->get(route('mypage'));

        $response->assertStatus(200);
    }

    public function test_manager_cannot_access_mypage()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('mypage'));

        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_users_edit()
    {
        $user = User::factory()->create();
        
        $response = $this->get(route('mypage.edit', $user));

        $response->assertRedirect(route('login'));
    }

    public function test_free_user_can_access_users_edit()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $response = $this->actingAs($user)->get(route('mypage.edit', $user));

        $response->assertStatus(200);
    }

    public function test_paid_user_can_access_users_edit()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);

        $response = $this->actingAs($user)->get(route('mypage.edit', $user));

        $response->assertStatus(200);
    }

    public function test_manager_cannot_access_users_edit()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();
        $user = User::factory()->create();

        $response = $this->actingAs($master, 'admin')->get(route('mypage.edit', $user));

        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_users_update()
    {
        $old_user = User::factory()->create();
        $new_user_data = [
            'id' => $old_user->id,
            'email' => $old_user->email,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン',
            'password' => 'password',
        ];
        
        $response = $this->put(route('mypage.update', $old_user), $new_user_data);

        $this->assertDatabaseMissing('users', [
            'id' => $old_user->id,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン'
        ]);
        $response->assertRedirect(route('login'));
    }

    public function test_free_user_can_access_users_update()
    {
        $old_user = User::factory()->create([
            'role' => 'free',
        ]);
        $new_user_data = [
            'id' => $old_user->id,
            'email' => $old_user->email,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン',
            'password' => 'password',
        ];

        $response = $this->actingAs($old_user)->put(route('mypage.update', $old_user), $new_user_data);

        $this->assertDatabaseHas('users', [
            'id' => $old_user->id,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン'
        ]);
        $response->assertRedirect(route('mypage'));
    }

    public function test_paid_user_can_access_users_update()
    {
        $old_user = User::factory()->create([
            'role' => 'paid',
        ]);
        $new_user_data = [
            'id' => $old_user->id,
            'email' => $old_user->email,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン',
            'password' => 'password',
        ];

        $response = $this->actingAs($old_user)->put(route('mypage.update', $old_user), $new_user_data);

        $this->assertDatabaseHas('users', [
            'id' => $old_user->id,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン'
        ]);
        $response->assertRedirect(route('mypage'));
    }

    public function test_manager_cannot_access_users_update()
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
        ];

        $response = $this->actingAs($master, 'admin')->put(route('mypage.update', $old_user), $new_user_data);

        $this->assertDatabaseMissing('users', [
            'id' => $old_user->id,
            'name' => 'テスト更新',
            'furigana' => 'テストコウシン'
        ]);
        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_users_edit_password()
    {
        $user = User::factory()->create();
        
        $response = $this->get(route('mypage.edit_password', $user));

        $response->assertRedirect(route('login'));
    }

    public function test_free_user_can_access_users_edit_password()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $response = $this->actingAs($user)->get(route('mypage.edit_password', $user));

        $response->assertStatus(200);
    }

    public function test_paid_user_can_access_users_edit_password()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);

        $response = $this->actingAs($user)->get(route('mypage.edit_password', $user));

        $response->assertStatus(200);
    }

    public function test_manager_cannot_access_users_edit_password()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();
        $user = User::factory()->create();

        $response = $this->actingAs($master, 'admin')->get(route('mypage.edit_password', $user));

        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_users_destroy()
    {
        $user = User::factory()->create();
        
        $response = $this->delete(route('mypage.destroy', $user));

        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $response->assertRedirect(route('login'));
    }

    public function test_free_user_can_access_users_destroy()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $response = $this->actingAs($user)->delete(route('mypage.destroy', $user));

        $this->assertSoftDeleted('users', ['id' => $user->id]);
        $response->assertRedirect(route('top'));
    }

    public function test_paid_user_cannot_access_users_destroy()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);

        $response = $this->actingAs($user)->delete(route('mypage.destroy', $user));

        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $response->assertStatus(403);
    }

    public function test_manager_cannot_access_users_destroy()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();
        $user = User::factory()->create();

        $response = $this->actingAs($master, 'admin')->delete(route('mypage.destroy', $user));

        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_favorite()
    {
        $response = $this->get(route('mypage.favorite'));

        $response->assertRedirect(route('login'));
    }

    public function test_free_user_cannot_access_favorite()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $response = $this->actingAs($user)->get(route('mypage.favorite'));

        $response->assertStatus(403);
    }

    public function test_paid_user_can_access_favorite()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);

        $response = $this->actingAs($user)->get(route('mypage.favorite'));

        $response->assertStatus(200);
    }

    public function test_manager_cannot_access_favorite()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('mypage.favorite'));

        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_users_edit_paid()
    {
        $user = User::factory()->create();
        
        $response = $this->get(route('mypage.edit_paid', $user));

        $response->assertRedirect(route('login'));
    }

    public function test_free_user_can_access_users_edit_paid()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $response = $this->actingAs($user)->get(route('mypage.edit_paid', $user));

        $response->assertStatus(200);
    }

    public function test_paid_user_cannot_access_users_edit_paid()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);

        $response = $this->actingAs($user)->get(route('mypage.edit_paid', $user));

        $response->assertStatus(403);
    }

    public function test_manager_cannot_access_users_edit_paid()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();
        $user = User::factory()->create();

        $response = $this->actingAs($master, 'admin')->get(route('mypage.edit_paid', $user));

        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_users_update_paid()
    {
        $old_user = User::factory()->create();
        $new_user_data = [
            'id' => $old_user->id,
            'phone' => '1234567890',
            'work' => 'company',
            'birthday' => '2000-12-12'
        ];
        
        $response = $this->put(route('mypage.update_paid', $old_user), $new_user_data);

        $this->assertDatabaseMissing('users', [
            'id' => $old_user->id,
            'phone' => '1234567890',
            'work' => 'company',
            'birthday' => '2000-12-12'
        ]);
        $response->assertRedirect(route('login'));
    }

    public function test_free_user_can_access_users_update_paid()
    {
        $old_user = User::factory()->create([
            'role' => 'free',
        ]);
        $new_user_data = [
            'id' => $old_user->id,
            'phone' => '1234567890',
            'work' => 'company',
            'birthday' => '2000-12-12'
        ];

        $response = $this->actingAs($old_user)->put(route('mypage.update_paid', $old_user), $new_user_data);

        $this->assertDatabaseHas('users', [
            'id' => $old_user->id,
            'phone' => '1234567890',
            'work' => 'company',
            'birthday' => '2000-12-12'
        ]);
        $response->assertRedirect(route('subscription.create'));
    }

    public function test_paid_user_cannot_access_users_update_paid()
    {
        $old_user = User::factory()->create([
            'role' => 'paid',
        ]);
        $new_user_data = [
            'id' => $old_user->id,
            'phone' => '1234567890',
            'work' => 'company',
            'birthday' => '2000-12-12'
        ];

        $response = $this->actingAs($old_user)->put(route('mypage.update_paid', $old_user), $new_user_data);

        $this->assertDatabaseMissing('users', [
            'id' => $old_user->id,
            'phone' => '1234567890',
            'work' => 'company',
            'birthday' => '2000-12-12'
        ]);
        $response->assertStatus(403);
    }

    public function test_manager_cannot_access_users_update_paid()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();
        $old_user = User::factory()->create();
        $new_user_data = [
            'id' => $old_user->id,
            'phone' => '1234567890',
            'work' => 'company',
            'birthday' => '2000-12-12'
        ];

        $response = $this->actingAs($master, 'admin')->put(route('mypage.update_paid', $old_user), $new_user_data);

        $this->assertDatabaseMissing('users', [
            'id' => $old_user->id,
            'phone' => '1234567890',
            'work' => 'company',
            'birthday' => '2000-12-12'
        ]);
        $response->assertRedirect(route('admin.web.index'));
    }
}
