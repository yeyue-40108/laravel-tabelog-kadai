<?php

namespace Tests\Feature\Admin;

use App\Models\Master;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MasterTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_masters_index()
    {
        $response = $this->get(route('admin.masters.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_masters_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.masters.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_cannot_access_admin_masters_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.masters.index'));

        $response->assertStatus(403);
    }

    public function test_manager_can_access_admin_masters_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.masters.index'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_masters_update()
    {
        $old_master = Master::factory()->create();
        $new_master_data = [
            'id' => $old_master->id,
            'email' => 'mnagoyameshi@example.com',
            'password' => 'password',
            'role' => 'manager',
        ];

        $response = $this->patch(route('admin.masters.update', $old_master), $new_master_data);

        $this->assertDatabaseMissing('masters', [
            'id' => $old_master->id,
            'email' => 'nagoyameshi@example.com',
            'role' => 'manager',
        ]);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_masters_update()
    {
        $user = User::factory()->create();
        $old_master = Master::factory()->create();
        $new_master_data = [
            'id' => $old_master->id,
            'email' => 'nagoyameshi@example.com',
            'password' => 'password',
            'role' => 'manager',
        ];

        $response = $this->actingAs($user)->patch(route('admin.masters.update', $old_master), $new_master_data);

        $this->assertDatabaseMissing('masters', [
            'id' => $old_master->id,
            'email' => 'nagoyameshi@example.com',
            'role' => 'manager',
        ]);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_cannot_access_admin_masters_update()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $old_master = Master::factory()->create();
        $new_master_data = [
            'id' => $old_master->id,
            'email' => 'nagoyameshi@example.com',
            'password' => 'password',
            'role' => 'manager',
        ];

        $response = $this->actingAs($master, 'admin')->patch(route('admin.masters.update', $old_master), $new_master_data);

        $this->assertDatabaseMissing('masters', [
            'id' => $old_master->id,
            'email' => 'nagoyameshi@example.com',
            'role' => 'manager',
        ]);
        $response->assertStatus(403);
    }

    public function test_manager_can_access_admin_masters_update()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $old_master = Master::factory()->create();
        $new_master_data = [
            'id' => $old_master->id,
            'email' => $old_master->email,
            'password' => 'password',
            'role' => 'manager',
        ];

        $response = $this->actingAs($master, 'admin')->patch(route('admin.masters.update', $old_master), $new_master_data);

        $this->assertDatabaseHas('masters', [
            'id' => $old_master->id,
            'email' => $old_master->email,
            'role' => 'manager',
        ]);
        $response->assertRedirect(route('admin.masters.index'));
    }

    public function test_guest_cannot_access_admin_masters_destroy()
    {
        $other_master = Master::factory()->create();

        $response = $this->delete(route('admin.masters.destroy', $other_master));

        $this->assertDatabaseHas('masters', ['id' => $other_master->id]);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_masters_destroy()
    {
        $user = User::factory()->create();
        $other_master = Master::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.masters.destroy', $other_master));

        $this->assertDatabaseHas('masters', ['id' => $other_master->id]);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_cannot_access_admin_masters_destroy()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $other_master = Master::factory()->create();

        $response = $this->actingAs($master, 'admin')->delete(route('admin.masters.destroy', $other_master));

        $this->assertDatabaseHas('masters', ['id' => $other_master->id]);
        $response->assertStatus(403);
    }

    public function test_manager_can_access_admin_masters_destroy()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $other_master = Master::factory()->create();

        $response = $this->actingAs($master, 'admin')->delete(route('admin.masters.destroy', $other_master));

        $this->assertDatabaseMissing('masters', ['id' => $other_master->id]);
        $response->assertRedirect(route('admin.masters.index'));
    }
}
