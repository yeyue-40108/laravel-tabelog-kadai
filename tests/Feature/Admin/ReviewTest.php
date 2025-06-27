<?php

namespace Tests\Feature\Admin;

use App\Models\Master;
use App\Models\User;
use App\Models\Shop;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_reviews_index()
    {
        $response = $this->get(route('admin.reviews.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_reviews_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.reviews.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_can_access_admin_reviews_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.reviews.index'));

        $response->assertStatus(200);
    }

    public function test_manager_can_access_admin_reviews_index()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $response = $this->actingAs($master, 'admin')->get(route('admin.reviews.index'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_reviews_show()
    {
        $shop = Shop::factory()->create();
        $user = User::factory()->create();
        $review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get(route('admin.reviews.show', $review));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_reviews_show()
    {
        $shop = Shop::factory()->create();
        $user = User::factory()->create();
        $review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('admin.reviews.show', $review));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_manager_can_access_admin_reviews_show()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $shop = Shop::factory()->create();
        $user = User::factory()->create();
        $review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($master, 'admin')->get(route('admin.reviews.show', $review));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_reviews_update()
    {
        $shop = Shop::factory()->create();
        $user = User::factory()->create();
        $old_review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
        ]);
        $new_review_data = [
            'id' => $old_review->id,
            'display' => 0
        ];

        $response = $this->put(route('admin.reviews.update', $old_review), $new_review_data);

        $this->assertDatabaseMissing('reviews', [
            'id' => $old_review->id,
            'display' => 0
        ]);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_user_cannot_access_admin_reviews_update()
    {
        $shop = Shop::factory()->create();
        $user = User::factory()->create();
        $old_review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
        ]);
        $new_review_data = [
            'id' => $old_review->id,
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'content' => $old_review->content,
            'score' => $old_review->score,
            'display' => 0
        ];

        $response = $this->actingAs($user)->put(route('admin.reviews.update', $old_review), $new_review_data);

        $this->assertDatabaseMissing('reviews', [
            'id' => $old_review->id,
            'display' => 0
        ]);
        $response->assertRedirect(route('admin.login'));
    }

    public function test_shop_manager_cannot_access_admin_reviews_update()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $shop = Shop::factory()->create();
        $user = User::factory()->create();
        $old_review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
        ]);
        $new_review_data = [
            'id' => $old_review->id,
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'content' => $old_review->content,
            'score' => $old_review->score,
            'display' => 0
        ];

        $response = $this->actingAs($master, 'admin')->put(route('admin.reviews.update', $old_review), $new_review_data);

        $this->assertDatabaseMissing('reviews', [
            'id' => $old_review->id,
            'display' => 0
        ]);
        $response->assertStatus(403);
    }

    public function test_manager_can_access_admin_reviews_update()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $shop = Shop::factory()->create();
        $user = User::factory()->create();
        $old_review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
        ]);
        $new_review_data = [
            'id' => $old_review->id,
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'content' => $old_review->content,
            'score' => $old_review->score,
            'display' => 0
        ];

        $response = $this->actingAs($master, 'admin')->put(route('admin.reviews.update', $old_review), $new_review_data);

        $this->assertDatabaseHas('reviews', [
            'id' => $old_review->id,
            'display' => 0
        ]);
        $response->assertRedirect(route('admin.reviews.show', $old_review));
    }
}
