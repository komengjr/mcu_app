<?php

use App\Http\Controllers\ApiController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('gateway')->group(function () {
    Route::get('email', [ApiController::class, 'gateway_email'])->name('gateway_email');
    Route::get('whatsapp/check/{cabang}', [ApiController::class, 'gateway_whatsapp'])->name('gateway_whatsapp');
    Route::get('whatsapp/verify/{id}', [ApiController::class, 'verify_gateway_whatsapp'])->name('verify_gateway_whatsapp');
    // Route::post('setup-notification', [DashboardController::class, 'dashboard_setup_notification'])->name('dashboard_setup_notification');
});
