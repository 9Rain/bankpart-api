<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\{
    UserController,
    AccountController,
    AuthController,
    PartitionController
};
use App\Http\Controllers\api\Staff\{
    UserController as StaffUserController,
    AccountController as StaffAccountController,
    PartitionController as StaffPartitionController,
};


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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);

        Route::group(['middleware' => 'auth.jwt'], function () {
            Route::get('me', [AuthController::class, 'me']);
            Route::post('logout', [AuthController::class, 'logout']);
        });
    });

    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::prefix('users/{userId}')->group(function () {
            Route::prefix('accounts/{accountId}')->group(function () {
                Route::prefix('partitions/{id}')->group(function () {
                    Route::patch('/addMoney', [PartitionController::class, 'addMoney']);
                    Route::patch('/removeMoney', [PartitionController::class, 'removeMoney']);
                });
                Route::apiResource('partitions', PartitionController::class);
            });
            Route::apiResource('accounts', AccountController::class);
        });
        Route::apiResource('users', UserController::class);

        Route::group(['middleware' => 'auth.staff', 'prefix' => 'admin'], function () {

            Route::prefix('users/{user}')->group(function () {

                Route::group(['middleware' => 'account.user', 'prefix' => 'accounts/{account}'], function () {

                    Route::group(['middleware' => 'partition.account', 'prefix' => 'partitions/{partition}'], function () {
                        Route::patch('/add-money', [StaffPartitionController::class, 'addMoney']);
                        Route::patch('/remove-money', [StaffPartitionController::class, 'removeMoney']);
                    });

                    Route::apiResource(
                        'partitions',
                        StaffPartitionController::class,
                        ['only' => ['show', 'update', 'destroy']]
                    )->middleware(['partition.account']);

                    Route::apiResource(
                        'partitions',
                        StaffPartitionController::class,
                        ['except' => ['show', 'update', 'destroy']]
                    );
                });

                Route::apiResource(
                    'accounts',
                    StaffAccountController::class,
                    ['only' => ['show', 'update', 'destroy']]
                )->middleware(['account.user']);

                Route::apiResource(
                    'accounts',
                    StaffAccountController::class,
                    ['except' => ['show', 'update', 'destroy']]
                );
            });

            Route::apiResource('users', StaffUserController::class);
        });
    });
});
