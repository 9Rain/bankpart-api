<?php

use App\Http\Controllers\api\{
    UserController,
    AccountController,
    PartitionController
};
use App\Http\Requests\StoreUpdateUser;
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

Route::name('api.')->group(function () {
    Route::apiResource('users', UserController::class);

    Route::apiResource('users/{userId}/accounts', AccountController::class);

    Route::apiResource('users/{userId}/accounts/{accountId}/partitions', PartitionController::class);
    Route::patch('users/{userId}/accounts/{accountId}/partitions/{id}/addMoney', [PartitionController::class, 'addMoney']);
    Route::patch('users/{userId}/accounts/{accountId}/partitions/{id}/removeMoney', [PartitionController::class, 'removeMoney']);
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
