<?php

namespace Tests\Feature\Admin;

use App\Models\Master;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WebTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_web_index()
    {
        $response = $this->get(route('admin.web.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_web_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.web.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_can_access_admin_web_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.web.index'));

        $response->assertStatus(200);
    }

    public function test_manager_can_access_admin_web_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.web.index'));

        $response->assertStatus(200);
    }
}
