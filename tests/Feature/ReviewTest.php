<?php

namespace Tests\Feature;

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

    public function test_guest_cannot_access_reviews_store()
    {
        $shop = Shop::factory()->create();
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $review_data = [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'content' => 'テスト',
            'score' => 1,
            'display' => 1
        ];
        $response = $this->post(route('reviews.store'), $review_data);

        $this->assertDatabaseMissing('reviews', $review_data);
        $response->assertRedirect(route('login'));
    }

    public function test_free_user_cannot_access_reviews_store()
    {
        $free_user = User::factory()->create();
        $shop = Shop::factory()->create();
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $review_data = [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'content' => 'テスト',
            'score' => 1,
            'display' => 1
        ];

        $response = $this->actingAs($free_user)->post(route('reviews.store'), $review_data);

        $this->assertDatabaseMissing('reviews', $review_data);
        $response->assertStatus(403);
    }

    public function test_paid_user_can_access_reviews_store()
    {
        $shop = Shop::factory()->create();
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $review_data = [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'content' => 'テスト',
            'score' => 1,
            'display' => 1
        ];

        $response = $this->actingAs($user)->from(route('shops.show', $shop))->post(route('reviews.store'), $review_data);

        $this->assertDatabaseHas('reviews', $review_data);
        $response->assertRedirect(route('shops.show', $shop));
    }

    public function test_manager_cannot_access_reviews_store()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $shop = Shop::factory()->create();
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $review_data = [
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'content' => 'テスト',
            'score' => 1,
            'display' => 1
        ];

        $response = $this->actingAs($master, 'admin')->post(route('reviews.store'), $review_data);

        $this->assertDatabaseMissing('reviews', $review_data);
        $response->assertRedirect(route('admin.web.index'));
    }

    public function test_guest_cannot_access_reviews_update()
    {
        $shop = Shop::factory()->create();
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $old_review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
        ]);
        $new_review_data = [
            'id' => $old_review->id,
            'content' => 'テスト更新',
            'score' => 2
        ];
        $response = $this->put(route('reviews.update', $old_review), $new_review_data);

        $this->assertDatabaseMissing('reviews', $new_review_data);
        $response->assertRedirect(route('login'));
    }

    public function test_free_user_cannot_access_reviews_update()
    {
        $free_user = User::factory()->create();
        $shop = Shop::factory()->create();
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $old_review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
        ]);
        $new_review_data = [
            'id' => $old_review->id,
            'content' => 'テスト更新',
            'score' => 2
        ];

        $response = $this->actingAs($free_user)->put(route('reviews.update', $old_review), $new_review_data);

        $this->assertDatabaseMissing('reviews', $new_review_data);
        $response->assertStatus(403);
    }

    public function test_paid_user_can_access_reviews_update()
    {
        $shop = Shop::factory()->create();
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $old_review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
        ]);
        $new_review_data = [
            'id' => $old_review->id,
            'content' => 'テスト更新',
            'score' => 2
        ];

        $response = $this->actingAs($user)->from(route('shops.show', $shop))->put(route('reviews.update', $old_review), $new_review_data);

        $this->assertDatabaseHas('reviews', $new_review_data);
        $response->assertRedirect(route('shops.show', $shop));
    }

    public function test_manager_cannot_access_reviews_update()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $shop = Shop::factory()->create();
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $old_review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
        ]);
        $new_review_data = [
            'id' => $old_review->id,
            'content' => 'テスト更新',
            'score' => 2
        ];

        $response = $this->actingAs($master, 'admin')->put(route('reviews.update', $old_review), $new_review_data);

        $this->assertDatabaseMissing('reviews', $new_review_data);
        $response->assertRedirect(route('admin.web.index'));
    }
    
    public function test_guest_cannot_access_reviews_destroy()
    {
        $shop = Shop::factory()->create();
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id
        ]);

        $response = $this->delete(route('reviews.destroy', $review));

        $this->assertDatabaseHas('reviews', ['id' => $review->id]);
        $response->assertRedirect(route('login'));
    }

    public function test_free_user_cannot_access_reviews_destroy()
    {
        $free_user = User::factory()->create([
            'role' => 'free',
        ]);
        $shop = Shop::factory()->create();
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($free_user)->delete(route('reviews.destroy', $review));

        $this->assertDatabaseHas('reviews', ['id' => $review->id]);
        $response->assertStatus(403);
    }

    public function test_paid_user_can_access_reviews_destroy()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'shop_manager';
        $master->save();

        $shop = Shop::factory()->create();
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->from(route('shops.show', $shop))->delete(route('reviews.destroy', $review));

        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
        $response->assertRedirect(route('shops.show', $shop));
    }

    public function test_manager_cannot_access_reviews_destroy()
    {
        $master = new Master();
        $master->email = 'admin@example.com';
        $master->password = Hash::make('password');
        $master->role = 'manager';
        $master->save();

        $shop = Shop::factory()->create();
        $user = User::factory()->create([
            'role' => 'paid',
        ]);
        $review = Review::factory()->create([
            'shop_id' => $shop->id,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($master, 'admin')->delete(route('reviews.destroy', $review));

        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $response->assertRedirect(route('admin.web.index'));
    }
}
