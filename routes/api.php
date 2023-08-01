<?php

use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\Frontend\IndexController;
use App\Models\Delivery;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('delivery', [DeliveryController::class, 'store']);
Route::post('login/delivery', [DeliveryController::class, 'loginDelivery']);
Route::get('getDeliveryData', [DeliveryController::class, 'getDeliveryData']);
Route::get('getOrderData', [DeliveryController::class, 'getOrderData']);
Route::post('applyOrder', [DeliveryController::class, 'applyOrder']);
Route::post('updateOrder', [DeliveryController::class, 'updateOrderCondition']);

// Route::post('/delivery', function (Request $request) {
//     $delivery = new Delivery();
//     $delivery->name = $request->input('name');
//     $delivery->email = $request->input('email');
//     $delivery->address = $request->input('address');
//     $delivery->save();

//     return response()->json($delivery, 201);
// });
