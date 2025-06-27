<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Admin\WebController as AdminWebController;
use App\Http\Controllers\Admin\ShopController as AdminShopController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\MasterController as AdminMasterController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Paid;
use App\Http\Middleware\Free;
use App\Http\Middleware\ShopManager;
use App\Http\Middleware\Manager;
use App\Http\Middleware\RedirectIfAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

route::group(['middleware' => 'guest:admin'], function() {
    Route::get('/', [WebController::class, 'index'])->name('top');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified', 'admin.deny'])->group(function() {
    Route::resource('shops', ShopController::class);

    Route::controller(UserController::class)->group(function() {
        Route::get('users/mypage', 'mypage')->name('mypage');
        Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
        Route::put('users/mypage', 'update')->name('mypage.update');
        Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
        Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
    });

    Route::middleware('free')->group(function() {
        Route::get('users/mypage/paid/edit', [UserController::class, 'edit_paid'])->name('mypage.edit_paid');
        Route::put('users/mypage/paid', [UserController::class, 'update_paid'])->name('mypage.update_paid');
        Route::delete('users/mypage/delete', [UserController::class, 'destroy'])->name('mypage.destroy');

        Route::get('subscription/create', [SubscriptionController::class, 'create'])->name('subscription.create');
        Route::post('subscription', [SubscriptionController::class, 'store'])->name('subscription.store');
    });

    Route::middleware('paid')->group(function() {
        Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::put('reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::post('favorites/{shop_id}', [FavoriteController::class, 'store'])->name('favorites.store');
        Route::delete('favorites/{shop_id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

        Route::get('users/mypage/favorite', [UserController::class,'favorite'])->name('mypage.favorite');

        Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/shops/{shop}/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
        Route::post('/shops/{shop}/reservations', [ReservationController::class, 'store'])->name('reservations.store');
        Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

        Route::controller(SubscriptionController::class)->group(function() {
            Route::get('subscription/edit', 'edit')->name('subscription.edit');
            Route::put('subscription', 'update')->name('subscription.update');
            Route::get('subscription/cancel', 'cancel')->name('subscription.cancel');
            Route::delete('subscription', 'destroy')->name('subscription.destroy');
        });
    });
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'],function() {
    Route::get('web', [AdminWebController::class, 'index'])->name('web.index');

    Route::resource('shops', AdminShopController::class);

    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews/{review}', [AdminReviewController::class, 'show'])->name('reviews.show');

    Route::get('reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::get('reservations/{reservation}', [AdminReservationController::class, 'show'])->name('reservations.show');

    Route::middleware('manager')->group(function() {
        Route::resource('categories', AdminCategoryController::class);

        Route::put('reviews/{review}', [AdminReviewController::class, 'update'])->name('reviews.update');

        Route::post('users/export', [AdminUserController::class, 'export'])->name('users.export');
        Route::get('users/sales', [AdminUserController::class, 'sales'])->name('users.sales');
        Route::resource('users', AdminUserController::class);

        Route::resource('masters', AdminMasterController::class)->only(['index', 'update', 'destroy']);
    });
});