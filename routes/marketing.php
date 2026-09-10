<?php

use App\Http\Controllers\MarketingDashboardController;
use Illuminate\Support\Facades\Route;


Route::prefix('{akses}/marketing')->group(function () {
    Route::get('master-marketing/marketing-staff', [MarketingDashboardController::class, 'marketing_staff'])->name('marketing_staff');
});
Route::post('/marketing-staff', [MarketingDashboardController::class, 'store'])->name('marketing-staff.store');
Route::post('marketing-staff/target', [MarketingDashboardController::class, 'storeTarget'])->name('marketing-target.store');
