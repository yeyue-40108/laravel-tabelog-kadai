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

Route::get('/', [WebController::class, 'index'])->name('top');

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function() {
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

        Route::get('subscription/create', [SubscriptionController::class, 'create'])->name('subscription.create');
        Route::post('subscription', [SubscriptionController::class, 'store'])->name('subscription.store');
    });

    Route::middleware('paid')->group(function() {
        Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');

        Route::post('favorites/{shop_id}', [FavoriteController::class, 'store'])->name('favorites.store');
        Route::delete('favorites/{shop_id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

        Route::get('users/mypage/favorite', [UserController::class,'favorite'])->name('mypage.favorite');

        Route::resource('reservations', ReservationController::class);

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

    Route::resource('categories', AdminCategoryController::class);

    Route::resource('reviews', AdminReviewController::class);
    
    Route::resource('users', AdminUserController::class);

    Route::get('reservations', [AdminReservationController::class, 'index'])->name('reservations.index');

    Route::controller(AdminMasterController::class)->group(function() {
        Route::get('masters/mypage', 'mypage')->name('mypage');
        Route::get('masters/mypage/edit', 'edit')->name('mypage.edit');
        Route::put('masters/mypage', 'update')->name('mypage.update');
        Route::get('masters/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
        Route::put('masters/mypage/password', 'update_password')->name('mypage.update_password');
    });
});