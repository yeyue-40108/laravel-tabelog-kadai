<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\WebController as AdminWebController;
use App\Http\Controllers\Admin\ShopController as AdminShopController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use Illuminate\Support\Facades\Route;

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

    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::post('favorites/{shop_id}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('favorites/{shop_id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    Route::resource('reservations', ReservationController::class);

    Route::controller(UserController::class)->group(function() {
        Route::get('users/mypage', 'mypage')->name('mypage');
        Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
        Route::put('users/mypage', 'update')->name('mypage.update');
        Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
        Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
        Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');
        Route::get('users/mypage/paid/edit', 'edit_paid')->name('mypage.edit_paid');
        Route::put('users/mypage/paid', 'update_paid')->name('mypage.update_paid');
        Route::get('users/mypage/cash/edit', 'edit_cash')->name('mypage.edit_cash');
        Route::put('users/mypage/cash', 'update_cash')->name('mypage.update_cash');
        Route::get('users/mypage/cancel/edit', 'edit_cancel')->name('mypage.edit_cancel');
        Route::put('users/mypage/cancel', 'update_cancel')->name('mypage.update_cancel');
    });
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'],function() {
    Route::get('web', [AdminWebController::class, 'index'])->name('web.index');

    Route::resource('shops', AdminShopController::class);

    Route::resource('categories', AdminCategoryController::class);

    Route::resource('reviews', AdminReviewController::class);
    
    Route::resource('users', AdminUserController::class);

    Route::get('reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
});