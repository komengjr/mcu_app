<?php

use App\Http\Controllers\MarketingDashboardController;
use Illuminate\Support\Facades\Route;


Route::prefix('{akses}/marketing')->group(function () {
    Route::get('menu-marketing/penilaian', [MarketingDashboardController::class, 'marketing_penilaian'])->name('marketing_penilaian');
    // API / AJAX Endpoints
    Route::get('menu-marketing/penilaian-data', [MarketingDashboardController::class, 'get_data_penilaian'])->name('marketing_penilaian.data');
    Route::get('menu-marketing/penilaian/get-form/{staff_id}', [MarketingDashboardController::class, 'getFormPenilaian'])->name('marketing_penilaian.get_form');
    Route::post('menu-marketing/penilaian/store', [MarketingDashboardController::class, 'storePenilaian'])->name('marketing_penilaian.store');
    Route::get('menu-marketing/penilaian/print-all', [MarketingDashboardController::class, 'printAll']);
    Route::get('menu-marketing/penilaian/print-person/{staff_id}', [MarketingDashboardController::class, 'printPerson']);

    Route::get('master-marketing/marketing-staff', [MarketingDashboardController::class, 'marketing_staff'])->name('marketing_staff');
    Route::get('master-marketing/marketing-cabang', [MarketingDashboardController::class, 'marketing_cabang'])->name('marketing_cabang');
    Route::get('master-marketing/marketing-setting', [MarketingDashboardController::class, 'marketing_setting'])->name('marketing_setting');

    // Menu Master Akses & Hierarki Penilaian
    Route::get('menu-marketing/master-akses', [MarketingDashboardController::class, 'master_akses'])->name('marketing_akses');
    Route::post('menu-marketing/master-akses/store-cabang', [MarketingDashboardController::class, 'storeAksesCabang'])->name('marketing_akses.store_cabang');
    Route::delete('menu-marketing/master-akses/delete-cabang/{id}', [MarketingDashboardController::class, 'deleteAksesCabang'])->name('marketing_akses.delete_cabang');

    Route::post('menu-marketing/master-akses/store-hierarki', [MarketingDashboardController::class, 'storeHierarki'])->name('marketing_akses.store_hierarki');
    Route::delete('menu-marketing/master-akses/delete-hierarki/{id}', [MarketingDashboardController::class, 'deleteHierarki'])->name('marketing_akses.delete_hierarki');

    Route::get('menu-marketing/master-akses/get-staff-by-cabang/{kode_cabang}', [MarketingDashboardController::class, 'getStaffByCabang'])->name('marketing_akses.get_staff');
    Route::post('menu-marketing/master-akses/store-user-akun', [MarketingDashboardController::class, 'storeUserAkun'])->name('marketing_akses.store_user');
});

Route::post('/marketing-staff', [MarketingDashboardController::class, 'store'])->name('marketing-staff.store');
Route::post('master-marketing/marketing-cabang', [MarketingDashboardController::class, 'marketing_cabang_store'])->name('marketing-cabang.store');
Route::post('marketing-staff/target', [MarketingDashboardController::class, 'storeTarget'])->name('marketing-target.store');

// Route AJAX CRUD Indikator KPI
Route::post('master-marketing/marketing-setting/kpi/store', [MarketingDashboardController::class, 'storeKpi'])->name('marketing_setting.kpi.store');
Route::post('master-marketing/marketing-setting/kpi/update', [MarketingDashboardController::class, 'updateKpi'])->name('marketing_setting.kpi.update');
Route::delete('master-marketing/marketing-setting/kpi/delete/{id}', [MarketingDashboardController::class, 'destroyKpi'])->name('marketing_setting.kpi.delete');
