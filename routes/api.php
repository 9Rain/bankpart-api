<?php

use App\Http\Controllers\api\{
    UserController,
    AccountController,
    PartitionController
};

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

Route::apiResource('users', UserController::class);

Route::prefix('users/{userId}')->group(function () {
    Route::apiResource('accounts', AccountController::class);

    Route::prefix('accounts/{accountId}')->group(function () {
        Route::apiResource('partitions', PartitionController::class);

        Route::prefix('partitions/{id}')->group(function () {
            Route::patch('/addMoney', [PartitionController::class, 'addMoney']);
            Route::patch('/removeMoney', [PartitionController::class, 'removeMoney']);
        });
    });
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
