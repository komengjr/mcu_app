<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\SignaturePadController;
use App\Http\Controllers\UploadFileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('log-eror', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('login', 'index')->name('login');
    // Route::get('registration', 'registration')->name('register');
    // Route::get('confrim_user', 'confrim_user')->name('confrim_user');
    // Route::get('register_status', 'register_status')->name('register_status');
    // Route::get('forget_password', 'forget_password')->name('forget_password');
    Route::get('logout', 'logout')->name('logout');
    // Route::post('post-registration', 'postRegistration')->name('register.post');
    Route::post('post-login', 'postLogin')->name('login.post');
    // Route::get('dashboard', [AuthController::class, 'dashboard']);
});

Route::prefix('dashboard')->group(function () {
    Route::get('home', [dashboardController::class, 'index'])->name('dashboard.home');
    Route::get('news', [dashboardController::class, 'news'])->name('dashboard.news');
    Route::get('actifity', [dashboardController::class, 'actifity'])->name('dashboard.actifity');
    Route::get('profile', [dashboardController::class, 'profile'])->name('dashboard.profile');
    Route::get('setting', [dashboardController::class, 'setting'])->name('dashboard.setting');
});
Route::prefix('{akses}/application')->group(function () {
    Route::get('home', [ApplicationController::class, 'home'])->name('home');
    Route::get('monitoring-mcu', [ApplicationController::class, 'monitoring_mcu'])->name('monitoring_mcu');
    Route::get('medical-check-up', [ApplicationController::class, 'medical_check_up'])->name('medical_check_up');
    Route::get('menu-service', [ApplicationController::class, 'menu_service'])->name('menu_service');
    Route::get('master-company', [ApplicationController::class, 'master_company'])->name('master_company');
    Route::get('mou-company', [ApplicationController::class, 'mou_company'])->name('mou_company');
    Route::get('agreement-perusahaan', [ApplicationController::class, 'agreement_perusahaan'])->name('agreement_perusahaan');
    Route::get('master-pemeriksaan', [ApplicationController::class, 'master_pemeriksaan'])->name('master_pemeriksaan');
    Route::get('master-access-mou', [ApplicationController::class, 'master_access_mou'])->name('master_access_mou');
    Route::get('master-user-cabang', [ApplicationController::class, 'master_user_cabang'])->name('master_user_cabang');
    Route::get('master-group-cabang', [ApplicationController::class, 'master_group_cabang'])->name('master_group_cabang');
    Route::get('laporan-rekap-mcu', [ApplicationController::class, 'laporan_rekap_mcu'])->name('laporan_rekap_mcu');
    Route::get('aplikasi', [ApplicationController::class, 'aplikasi_app'])->name('aplikasi_app');
});
Route::prefix('application')->group(function () {
    //MONITORING MCU
    Route::post('monitoring-mcu/cari-nama', [ApplicationController::class, 'monitoring_mcu_cari_nama'])->name('monitoring_mcu_cari_nama');
    Route::post('monitoring-mcu/detail', [ApplicationController::class, 'monitoring_mcu_detail'])->name('monitoring_mcu_detail');
    Route::post('monitoring-mcu/detail/belum', [ApplicationController::class, 'monitoring_mcu_detail_belum'])->name('monitoring_mcu_detail_belum');
    Route::post('monitoring-mcu/detail/sudah', [ApplicationController::class, 'monitoring_mcu_detail_sudah'])->name('monitoring_mcu_detail_sudah');
    Route::post('monitoring-mcu/rekap', [ApplicationController::class, 'monitoring_mcu_rekap'])->name('monitoring_mcu_rekap');
    Route::post('monitoring-mcu/rekap-full', [ApplicationController::class, 'monitoring_mcu_rekap_full'])->name('monitoring_mcu_rekap_full');


    Route::post('medical-check-up/detail', [ApplicationController::class, 'medical_check_up_detail'])->name('medical_check_up_detail');
    Route::post('medical-check-up/prosess', [ApplicationController::class, 'medical_check_up_prosess'])->name('medical_check_up_prosess');
    Route::post('medical-check-up/prosess-save', [ApplicationController::class, 'medical_check_up_prosess_save'])->name('medical_check_up_prosess_save');
    Route::post('medical-check-up/prosess-update', [ApplicationController::class, 'medical_check_up_prosess_update'])->name('medical_check_up_prosess_update');
    Route::post('medical-check-up/prosess-update-save', [ApplicationController::class, 'medical_check_up_prosess_update_save'])->name('medical_check_up_prosess_update_save');
    Route::post('medical-check-up/prosess-generate-absensi', [ApplicationController::class, 'medical_check_up_prosess_generate_absensi'])->name('medical_check_up_prosess_generate_absensi');
    Route::post('medical-check-up/prosess-cetak-absensi', [ApplicationController::class, 'medical_check_up_prosess_cetak_absensi'])->name('medical_check_up_prosess_cetak_absensi');
    Route::post('medical-check-up/prosess-cetak-absensi-mcu', [ApplicationController::class, 'medical_check_up_prosess_cetak_absensi_mcu'])->name('medical_check_up_prosess_cetak_absensi_mcu');
    Route::post('medical-check-up/summary', [ApplicationController::class, 'medical_check_up_summary'])->name('medical_check_up_summary');
    Route::post('medical-check-up/summary-save-persentasi', [ApplicationController::class, 'medical_check_up_summary_save_persentasi'])->name('medical_check_up_summary_save_persentasi');
    Route::post('medical-check-up/summary-save-executive', [ApplicationController::class, 'medical_check_up_summary_save_executive'])->name('medical_check_up_summary_save_executive');
    Route::post('medical-check-up/summary-save-healty-talk', [ApplicationController::class, 'medical_check_up_summary_save_healty_talk'])->name('medical_check_up_summary_save_healty_talk');

    Route::post('menu-servic/history', [ApplicationController::class, 'menu_service_history'])->name('menu_service_history');
    Route::post('menu-service/proses', [ApplicationController::class, 'menu_service_proses'])->name('menu_service_proses');
    Route::post('menu-service/proses-pemeriksaan-save', [ApplicationController::class, 'menu_service_proses_pemeriksaan_save'])->name('menu_service_proses_pemeriksaan_save');
    Route::post('menu-service/proses-konsultasi-save', [ApplicationController::class, 'menu_service_proses_konsultasi_save'])->name('menu_service_proses_konsultasi_save');
    Route::post('menu-service/proses-pengiriman-save', [ApplicationController::class, 'menu_service_proses_pengiriman_save'])->name('menu_service_proses_pengiriman_save');
    Route::post('menu-service/proses-penyelesaian-peserta-mcu', [ApplicationController::class, 'menu_service_proses_penyelesaian_peserta_mcu'])->name('menu_service_proses_penyelesaian_peserta_mcu');

    Route::post('master-company/add-company', [ApplicationController::class, 'master_company_add_company'])->name('master_company_add_company');
    Route::post('master-company/add-company/save', [ApplicationController::class, 'master_company_add_company_save'])->name('master_company_add_company_save');
    Route::post('master-company/edit-company', [ApplicationController::class, 'master_company_edit_company'])->name('master_company_edit_company');
    Route::post('master-company/edit-company/save', [ApplicationController::class, 'master_company_edit_company_save'])->name('master_company_edit_company_save');
    Route::post('master-company/data-mou-company', [ApplicationController::class, 'master_company_data_mou_company'])->name('master_company_data_mou_company');
    // MOU COMPANY
    Route::post('mou-company/add', [ApplicationController::class, 'mou_company_add'])->name('mou_company_add');
    Route::post('mou-company/save', [ApplicationController::class, 'mou_company_save'])->name('mou_company_save');
    Route::post('mou-company/peserta-mcu', [ApplicationController::class, 'mou_company_peserta_mcu'])->name('mou_company_peserta_mcu');
    Route::post('mou-company/insert-peserta-mcu', [ApplicationController::class, 'mou_company_insert_peserta_mcu'])->name('mou_company_insert_peserta_mcu');
    Route::post('mou-company/insert-peserta-mcu/manual', [ApplicationController::class, 'mou_company_insert_peserta_mcu_manual'])->name('mou_company_insert_peserta_mcu_manual');
    Route::post('mou-company/insert-peserta-mcu/manual-save', [ApplicationController::class, 'mou_company_insert_peserta_mcu_manual_save'])->name('mou_company_insert_peserta_mcu_manual_save');
    Route::post('mou-company/insert-peserta-mcu/upload', [ApplicationController::class, 'mou_company_insert_peserta_mcu_upload'])->name('mou_company_insert_peserta_mcu_upload');
    Route::post('mou-company/insert-peserta-mcu/upload-save', [ApplicationController::class, 'mou_company_insert_peserta_mcu_upload_save'])->name('mou_company_insert_peserta_mcu_upload_save');
    Route::post('mou-company/insert-peserta-mcu/upload-all', [ApplicationController::class, 'mou_company_insert_all_peserta_mcu_upload'])->name('mou_company_insert_all_peserta_mcu_upload');
    Route::post('mou-company/insert-peserta-mcu/upload-all-save', [ApplicationController::class, 'mou_company_insert_all_peserta_mcu_upload_save'])->name('mou_company_insert_all_peserta_mcu_upload_save');
    Route::post('mou-company/insert-pemeriksaan-mcu', [ApplicationController::class, 'mou_company_insert_pemeriksaan_mcu'])->name('mou_company_insert_pemeriksaan_mcu');
    Route::post('mou-company/insert-pemeriksaan-mcu/insert', [ApplicationController::class, 'mou_company_insert_pemeriksaan_mcu_insert'])->name('mou_company_insert_pemeriksaan_mcu_insert');
    Route::post('mou-company/activasi-mou', [ApplicationController::class, 'mou_company_activasi_mou'])->name('mou_company_activasi_mou');
    Route::post('mou-company/activasi-mou/save', [ApplicationController::class, 'mou_company_activasi_mou_save'])->name('mou_company_activasi_mou_save');
    Route::post('mou-company/generate-absesnsi-mou', [ApplicationController::class, 'mou_company_generetae_absesnsi_mcu'])->name('mou_company_generetae_absesnsi_mcu');
    Route::post('mou-company/generate-absesnsi-mou/report', [ApplicationController::class, 'mou_company_generetae_absesnsi_mcu_report'])->name('mou_company_generetae_absesnsi_mcu_report');
    Route::post('mou-company/sinkronisasi/nik-nip', [ApplicationController::class, 'mou_company_sinkronisasi_nik_nip'])->name('mou_company_sinkronisasi_nik_nip');
    // AGREMENT
    Route::post('agreement-perusahaan/add', [ApplicationController::class, 'agreement_perusahaan_add'])->name('agreement_perusahaan_add');
    Route::post('agreement-perusahaan/save', [ApplicationController::class, 'agreement_perusahaan_save'])->name('agreement_perusahaan_save');
    Route::post('agreement-perusahaan/update-save', [ApplicationController::class, 'agreement_perusahaan_update_save'])->name('agreement_perusahaan_update_save');
    Route::post('agreement-perusahaan/update', [ApplicationController::class, 'agreement_perusahaan_update'])->name('agreement_perusahaan_update');
    Route::post('agreement-perusahaan/add-pemeriksaan', [ApplicationController::class, 'agreement_perusahaan_add_pemeriksaan'])->name('agreement_perusahaan_add_pemeriksaan');
    Route::post('agreement-perusahaan/save-pemeriksaan', [ApplicationController::class, 'agreement_perusahaan_save_pemeriksaan'])->name('agreement_perusahaan_save_pemeriksaan');
    Route::post('agreement-perusahaan/remove-pemeriksaan', [ApplicationController::class, 'agreement_perusahaan_remove_pemeriksaan'])->name('agreement_perusahaan_remove_pemeriksaan');
    Route::post('agreement-perusahaan/remove-agreement', [ApplicationController::class, 'agreement_perusahaan_remove_agreement'])->name('agreement_perusahaan_remove_agreement');
    // AKSES MOU
    Route::post('master-access-mou/add', [ApplicationController::class, 'master_access_mou_add'])->name('master_access_mou_add');
    Route::post('master-access-mou/save', [ApplicationController::class, 'master_access_mou_save'])->name('master_access_mou_save');
    Route::post('master-access-mou/add-akses', [ApplicationController::class, 'master_access_mou_add_akses'])->name('master_access_mou_add_akses');
    Route::post('master-access-mou/add-akses-pilih', [ApplicationController::class, 'master_access_mou_add_akses_pilih'])->name('master_access_mou_add_akses_pilih');
    Route::post('master-access-mou/remove-akses', [ApplicationController::class, 'master_access_mou_remove_akses'])->name('master_access_mou_remove_akses');
    Route::post('master-access-mou/remove-akses-save', [ApplicationController::class, 'master_access_mou_remove_akses_save'])->name('master_access_mou_remove_akses_save');
    // PEMERIKSAAN
    Route::post('master-pemeriksaan/add', [ApplicationController::class, 'master_pemeriksaan_add'])->name('master_pemeriksaan_add');
    Route::post('master-pemeriksaan/save', [ApplicationController::class, 'master_pemeriksaan_save'])->name('master_pemeriksaan_save');
    Route::post('master-pemeriksaan/update', [ApplicationController::class, 'master_pemeriksaan_update'])->name('master_pemeriksaan_update');
    Route::post('master-pemeriksaan/update-save', [ApplicationController::class, 'master_pemeriksaan_update_save'])->name('master_pemeriksaan_update_save');
    //USER CABANG
    Route::post('master-user-cabang/add', [ApplicationController::class, 'master_user_cabang_add'])->name('master_user_cabang_add');
    Route::post('master-user-cabang/save', [ApplicationController::class, 'master_user_cabang_save'])->name('master_user_cabang_save');
    Route::post('master-user-cabang/update', [ApplicationController::class, 'master_user_cabang_update'])->name('master_user_cabang_update');
    Route::post('master-user-cabang/update-save', [ApplicationController::class, 'master_user_cabang_update_save'])->name('master_user_cabang_update_save');
    //USER CABANG
    Route::post('master-group-cabang/add', [ApplicationController::class, 'master_group_cabang_add'])->name('master_group_cabang_add');
    Route::post('master-group-cabang/save', [ApplicationController::class, 'master_group_cabang_save'])->name('master_group_cabang_save');
    Route::post('master-group-cabang/update-group', [ApplicationController::class, 'master_group_cabang_update_group'])->name('master_group_cabang_update_group');
    Route::post('master-group-cabang/save-group', [ApplicationController::class, 'master_group_cabang_save_group'])->name('master_group_cabang_save_group');
    Route::post('master-group-cabang/add-cabang', [ApplicationController::class, 'master_group_cabang_add_cabang'])->name('master_group_cabang_add_cabang');
    Route::post('master-group-cabang/save-cabang', [ApplicationController::class, 'master_group_cabang_save_cabang'])->name('master_group_cabang_save_cabang');
    Route::post('master-group-cabang/remove-cabang', [ApplicationController::class, 'master_group_cabang_remove_cabang'])->name('master_group_cabang_remove_cabang');
    Route::post('master-group-cabang/save-remove-cabang', [ApplicationController::class, 'master_group_cabang_save_remove_cabang'])->name('master_group_cabang_save_remove_cabang');
    // LAPORAN REKAP MCU
    Route::post('laporan-rekap-mcu/cari-data', [ApplicationController::class, 'laporan_rekap_mcu_cari_data'])->name('laporan_rekap_mcu_cari_data');
    Route::post('laporan-rekap-mcu/pilih-data', [ApplicationController::class, 'laporan_rekap_mcu_pilih_data'])->name('laporan_rekap_mcu_pilih_data');
    Route::post('laporan-rekap-mcu/kehadiran-peserta-mcu', [ApplicationController::class, 'laporan_rekap_mcu_kehadiran_peserta_mcu'])->name('laporan_rekap_mcu_kehadiran_peserta_mcu');
    Route::post('laporan-rekap-mcu/kehadiran-peserta-mcu/report', [ApplicationController::class, 'laporan_rekap_mcu_kehadiran_peserta_mcu_report'])->name('laporan_rekap_mcu_kehadiran_peserta_mcu_report');
    Route::post('laporan-rekap-mcu/kehadiran-peserta-mcu/report-group', [ApplicationController::class, 'laporan_rekap_mcu_kehadiran_peserta_mcu_report_group'])->name('laporan_rekap_mcu_kehadiran_peserta_mcu_report_group');
    Route::get('laporan-rekap-mcu/kehadiran-peserta-mcu/export-excel/{id}', [ApplicationController::class, 'laporan_rekap_excel_mcu_kehadiran_peserta_mcu'])->name('laporan_rekap_excel_mcu_kehadiran_peserta_mcu');
});

Route::prefix('master-data')->group(function () {
    Route::get('access', [MasterController::class, 'master_access'])->name('master_access');
    Route::post('access/add', [MasterController::class, 'master_access_add'])->name('master_access_add');
    Route::post('access/save', [MasterController::class, 'master_access_save'])->name('master_access_save');
    Route::get('user', [MasterController::class, 'master_user'])->name('master_user');
    Route::post('user/add', [MasterController::class, 'master_user_add'])->name('master_user_add');
    Route::post('user/save', [MasterController::class, 'master_user_save'])->name('master_user_save');
    Route::get('cabang', [MasterController::class, 'master_cabang'])->name('master_cabang');
    Route::get('menu', [MasterController::class, 'master_menu'])->name('master_menu');
    Route::post('menu/add', [MasterController::class, 'master_menu_add'])->name('master_menu_add');
    Route::post('menu/save', [MasterController::class, 'master_menu_save'])->name('master_menu_save');
    Route::get('menu-access', [MasterController::class, 'master_menu_access'])->name('master_menu_access');
    Route::post('menu-access/setting', [MasterController::class, 'master_menu_access_setting'])->name('master_menu_access_setting');
    Route::post('menu-access/setting-change', [MasterController::class, 'master_menu_access_setting_change'])->name('master_menu_access_setting_change');
});

// UPLOAD CHUNK
Route::post('file-upload/upload-file-persentasi', [UploadFileController::class, 'upload_persentasi'])->name('file-upload.data_persentasi');
Route::post('file-upload/upload-file-executive', [UploadFileController::class, 'upload_executive'])->name('file-upload.data_executive');
Route::post('file-upload/upload-file-healty-talk', [UploadFileController::class, 'upload_healty_talk'])->name('file-upload.data_healty_talk');


Route::get('signaturepad', [SignaturePadController::class, 'index']);
Route::get('contoh', [SignaturePadController::class, 'contoh']);
Route::get('signaturepad/data-kehadiran-mcu/detail/{id}', [SignaturePadController::class, 'sign'])->name('sign-data-baru');
Route::get('absensi/data-kehadiran-mcu/perusahaan/{id}', [SignaturePadController::class, 'sign_perusahaan']);
Route::post('absensi/data-kehadiran-mcu/perusahaan/cari-peserta/data', [SignaturePadController::class, 'cari_data_peserta'])->name('cari_data_absensi_peserta_mcu');

Route::post('signaturepad', [SignaturePadController::class, 'upload'])->name('signaturepad.upload');
Route::post('signaturepad-update', [SignaturePadController::class, 'update'])->name('signaturepad.update');
Route::post('signaturepad-update-pemeriksaan', [SignaturePadController::class, 'update_pemeriksaan'])->name('signaturepad.update_pemeriksaan');
Route::post('signaturepad-update-pemeriksaan-save', [SignaturePadController::class, 'update_pemeriksaan_save'])->name('signaturepad.update_pemeriksaan_save');
Route::post('signaturepad-update-save', [SignaturePadController::class, 'save_signiture'])->name('signaturepad.save_signiture');
