<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\News\NewsController;
use App\Http\Controllers\Api\News\NewsSourceController;
use App\Http\Controllers\Api\User\UserPreferenceController;
use App\Http\Controllers\Api\User\UserProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/register', RegisterController::class);
        Route::post('/login', LoginController::class)->name('login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', LogoutController::class);

        Route::get('/profile', UserProfileController::class);
        Route::post('/preferences', UserPreferenceController::class);
        Route::get('/news-sources', NewsSourceController::class);
        Route::get('/authors', AuthorController::class);
        Route::get('/categories', CategoryController::class);
        Route::get('/news', NewsController::class);
    });
});
