<?php

namespace Tests\Feature\Admin\Auth;

use App\Models\Master;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }

    public function test_masters_can_authenticate_using_the_login_screen(): void
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->save();

        $response = $this->post('/admin/login', [
            'email' => $master->email,
            'password' => 'password',
        ]);

        $this->assertTrue(Auth::guard('admin')->check());
        $response->assertRedirect(RouteServiceProvider::ADMIN_HOME);
    }

    public function test_masters_can_not_authenticate_with_invalid_password(): void
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->save();

        $this->post('/admin/login', [
            'email' => $master->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_masters_can_logout(): void
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->save();

        $response = $this->actingAs($master, 'admin')->post('/admin/logout');

        $this->assertGuest();
        $response->assertRedirect('/admin/login');
    }
}
