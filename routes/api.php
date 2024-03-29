<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::middleware(['auth:api'])->group(function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('profile', 'AuthController@profile');
        Route::put('profile', 'AuthController@updateProfile');

        Route::resource('installations', InstallationController::class)->only(['index', 'store', 'show']);
        Route::resource('installation-payments', InstallationPaymentController::class)->only(['index', 'show']);
        Route::post('installation-payments/{installation}', 'InstallationPaymentController@store');

        Route::resource('feedbacks', FeedbackController::class)->only(['store', 'show', 'index']);

        Route::resource('services', ServiceController::class)->only(['index', 'show']);
        Route::resource('service-category', ServiceCategoryController::class)->only(['index', 'show']);

        Route::prefix('admin')->middleware(['is_admin'])->group(function () {
            Route::resource('feedbacks', FeedbackController::class)->only(['update', 'destroy']);
            Route::resource('service-category', ServiceCategoryController::class)->only(['store', 'update', 'destroy']);
            Route::resource('services', ServiceController::class)->only(['store', 'update', 'destroy']);

            Route::resource('installations', Admin\InstallationController::class)->only(['index', 'show']);
            Route::get('installations/{installation}/proceed', 'Admin\InstallationController@proceed');
            Route::get('installations/{installation}/finish', 'Admin\InstallationController@finish');
            Route::get('installations/{installation}/reject', 'Admin\InstallationController@reject');

            Route::resource('installation-payments', Admin\InstallationPaymentController::class)->only(['index', 'show']);
            Route::get('installation-payments/{installation_payment}/paid', 'Admin\InstallationPaymentController@paid');
            Route::get('installation-payments/{installation_payment}/reject', 'Admin\InstallationPaymentController@reject');
        });
    });
});
