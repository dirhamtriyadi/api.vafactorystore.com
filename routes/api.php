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

Route::get('orders/get/{order}', [App\Http\Controllers\API\OrdersController::class, 'getByOrder'])->name('orders.getByOrder');
//API route for registering a new user
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
//API route for logging user in
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login'])->name('login');
//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    Route::resource('user', App\Http\Controllers\API\UserController::class);
    Route::resource('payment-methods', App\Http\Controllers\API\PaymentMethodController::class)->except(['edit']);
    Route::resource('print-types', App\Http\Controllers\API\PrintTypeController::class)->except(['edit']);
    Route::get('products/new-code', [App\Http\Controllers\API\ProductController::class, 'getNewProductCode']);
    Route::resource('products', App\Http\Controllers\API\ProductController::class)->except(['edit']);
    Route::get('cash-flows/get-all', [App\Http\Controllers\API\CashFlowController::class, 'getAll']);
    Route::resource('cash-flows', App\Http\Controllers\API\CashFlowController::class)->except(['edit', 'update']);
    Route::resource('customers', App\Http\Controllers\API\CustomerController::class)->except(['edit']);
    Route::resource('transactions', App\Http\Controllers\API\TransactionController::class)->except(['create', 'edit']);

    Route::resource('orders', App\Http\Controllers\API\OrdersController::class);
    Route::resource('order-transactions', App\Http\Controllers\API\OrdersTransactionsController::class);
    Route::resource('tracking', App\Http\Controllers\API\TrackingController::class);
    Route::resource('order-trackings', App\Http\Controllers\API\OrdersTrackingController::class);
    Route::put('order-trackings/update/{id}', [App\Http\Controllers\API\OrdersTrackingController::class, 'updateProccess']);
    // Route::get('order-trackings/order/{id}', [App\Http\Controllers\API\OrdersTrackingController::class, 'indexByOrderId']);
    Route::resource('roles', App\Http\Controllers\API\RoleController::class)->except(['edit']);
    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
