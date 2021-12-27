<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\{
    AuthController
};
use App\Http\Controllers\Api\{
    UserController,
    AccountController,
    PartitionController,
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

        Route::apiResource('users', UserController::class, ['only' => ['index', 'show']]);

        Route::group(['middleware' => ['account.user', 'set.user'], 'prefix' => 'accounts/{account}'], function () {

            Route::group(['middleware' => 'partition.account', 'prefix' => 'partitions/{partition}'], function () {
                Route::patch('/add-money', [PartitionController::class, 'addMoney']);
                Route::patch('/remove-money', [PartitionController::class, 'removeMoney']);
            });

            Route::apiResource(
                'partitions',
                PartitionController::class,
                ['only' => ['show', 'update', 'destroy']]
            )->middleware(['partition.account']);

            Route::apiResource(
                'partitions',
                PartitionController::class,
                ['except' => ['show', 'update', 'destroy']]
            );
        });

        Route::apiResource(
            'accounts',
            AccountController::class,
            ['only' => ['show', 'update', 'destroy']]
        )->middleware(['account.user', 'set.user']);

        Route::apiResource(
            'accounts',
            AccountController::class,
            ['except' => ['show', 'update', 'destroy']]
        )->middleware(['set.user']);

        Route::group(['middleware' => 'auth.staff', 'prefix' => 'admin'], function () {

            Route::prefix('users/{user}')->group(function () {

                Route::group(['middleware' => 'account.user', 'prefix' => 'accounts/{account}'], function () {

                    Route::group(['middleware' => 'partition.account', 'prefix' => 'partitions/{partition}'], function () {
                        Route::patch('/add-money', [PartitionController::class, 'addMoney']);
                        Route::patch('/remove-money', [PartitionController::class, 'removeMoney']);
                    });

                    Route::apiResource(
                        'partitions',
                        PartitionController::class,
                        ['only' => ['show', 'update', 'destroy']]
                    )->middleware(['partition.account']);

                    Route::apiResource(
                        'partitions',
                        PartitionController::class,
                        ['except' => ['show', 'update', 'destroy']]
                    );
                });

                Route::apiResource(
                    'accounts',
                    AccountController::class,
                    ['only' => ['show', 'update', 'destroy']]
                )->middleware(['account.user']);

                Route::apiResource(
                    'accounts',
                    AccountController::class,
                    ['except' => ['show', 'update', 'destroy']]
                );
            });

            Route::apiResource('users', UserController::class);
        });
    });
});
