<?php

namespace Tests\Feature;

use App\Models\Master;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_subscription_create()
    {
        $response = $this->get(route('subscription.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_free_user_can_access_subscription_create()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $response = $this->actingAs($user)->get(route('subscription.create'));

        $response->assertStatus(200);
    }

    public function test_paid_user_cannot_access_subscription_create()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);

        $response = $this->actingAs($user)->get(route('subscription.create'));

        $response->assertStatus(403);
    }

    public function test_manager_cannot_access_subscription_create()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('subscription.create'));

        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_subscription_store()
    {
        $request_parameter = [
            'paymentMethodId' => 'pm_card_visa'
        ];

        $response = $this->post(route('subscription.store'), $request_parameter);

        $response->assertRedirect(route('login'));
    }

    public function test_free_user_can_access_subscription_store()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $request_parameter = [
            'paymentMethodId' => 'pm_card_visa'
        ];

        $response = $this->actingAs($user)->post(route('subscription.store'), $request_parameter);

        $response->assertRedirect(route('mypage'));
        $this->assertEquals('paid', $user->fresh()->role);
    }

    public function test_paid_user_cannot_access_subscription_store()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);

        $request_parameter = [
            'paymentMethodId' => 'pm_card_visa'
        ];

        $response = $this->actingAs($user)->post(route('subscription.store'), $request_parameter);

        $response->assertStatus(403);
    }

    public function test_manager_cannot_access_subscription_store()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $request_parameter = [
            'paymentMethodId' => 'pm_card_visa'
        ];

        $response = $this->actingAs($master, 'admin')->post(route('subscription.store'), $request_parameter);

        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_subscription_edit()
    {
        $response = $this->get(route('subscription.edit'));

        $response->assertRedirect(route('login'));
    }

    public function test_free_user_cannot_access_subscription_edit()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $response = $this->actingAs($user)->get(route('subscription.edit'));

        $response->assertStatus(403);
    }

    public function test_paid_user_can_access_subscription_edit()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $user->newSubscription('paid', env('STRIPE_PAID_ID'))->create('pm_card_visa');

        $response = $this->actingAs($user)->get(route('subscription.edit'));

        $response->assertStatus(200);
    }

    public function test_manager_cannot_access_subscription_edit()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('subscription.edit'));

        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_subscription_update()
    {
        $request_parameter = [
            'paymentMethodId' => 'pm_card_mastercard'
        ];

        $response = $this->put(route('subscription.update'), $request_parameter);

        $response->assertRedirect(route('login'));
    }

    public function test_free_user_cannot_access_subscription_update()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $request_parameter = [
            'paymentMethodId' => 'pm_card_mastercard'
        ];

        $response = $this->actingAs($user)->put(route('subscription.update'), $request_parameter);

        $response->assertStatus(403);
    }

    public function test_paid_user_can_access_subscription_update()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $user->newSubscription('paid', env('STRIPE_PAID_ID'))->create('pm_card_visa');

        $original_payment_method_id = $user->defaultPaymentMethod()->id;

        $request_parameter = [
            'paymentMethodId' => 'pm_card_mastercard'
        ];

        $response = $this->actingAs($user)->put(route('subscription.update'), $request_parameter);

        $response->assertRedirect(route('mypage'));

        $user->refresh();
        $this->assertNotEquals($original_payment_method_id, $user->defaultPaymentMethod()->id);
    }

    public function test_manager_cannot_access_subscription_update()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $request_parameter = [
            'paymentMethodId' => 'pm_card_mastercard'
        ];

        $response = $this->actingAs($master, 'admin')->put(route('subscription.update'), $request_parameter);

        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_subscription_cancel()
    {
        $response = $this->get(route('subscription.cancel'));

        $response->assertRedirect(route('login'));
    }

    public function test_free_user_cannot_access_subscription_cancel()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $response = $this->actingAs($user)->get(route('subscription.cancel'));

        $response->assertStatus(403);
    }

    public function test_paid_user_can_access_subscription_cancel()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);

        $response = $this->actingAs($user)->get(route('subscription.cancel'));

        $response->assertStatus(200);
    }

    public function test_manager_cannot_access_subscription_cancel()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('subscription.cancel'));

        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_subscription_destroy()
    {
        $response = $this->delete(route('subscription.destroy'));

        $response->assertRedirect(route('login'));
    }

    public function test_free_user_cannot_access_subscription_destroy()
    {
        $user = User::factory()->create([
            'role' => 'free',
        ]);

        $response = $this->actingAs($user)->delete(route('subscription.destroy'));

        $response->assertStatus(403);
    }

    public function test_paid_user_can_access_subscription_destroy()
    {
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $user->newSubscription('paid', env('STRIPE_PAID_ID'))->create('pm_card_visa');

        $response = $this->actingAs($user)->delete(route('subscription.destroy'));

        $response->assertRedirect(route('mypage'));
        $this->assertEquals('free', $user->fresh()->role);
    }

    public function test_manager_cannot_access_subscription_destroy()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->delete(route('subscription.destroy'));

        $response->assertRedirect(route('admin.web.index'));
    }
}
