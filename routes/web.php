<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicController;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/profil', [PublicController::class, 'profil'])->name('profil');
Route::get('/maps', [PublicController::class, 'peta'])->name('peta');
Route::get('/struktur', [PublicController::class, 'struktur'])->name('struktur');
Route::get('/daily-report', [PublicController::class, 'dailyReport'])->name('daily-report');
Route::get('/pengumuman', [PublicController::class, 'pengumuman'])->name('pengumuman');
Route::get('/data-warga', [PublicController::class, 'dataWarga'])->name('data-warga');
Route::get('/rt/{id}', [PublicController::class, 'rt'])->name('rt');
Route::get('/karang-taruna', [PublicController::class, 'karangTaruna'])->name('karang-taruna');
Route::get('/kegiatan', [PublicController::class, 'kegiatan'])->name('kegiatan');
Route::get('/galeri', [PublicController::class, 'galeri'])->name('galeri');
Route::get('/aspirasi', [PublicController::class, 'aspirasi'])->name('aspirasi');
Route::post('/aspirasi', [PublicController::class, 'storeAspirasi'])->name('aspirasi.store');
Route::get('/kontak', [PublicController::class, 'kontak'])->name('kontak');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

// Admin CRUD Routes
Route::middleware('role:admin_rw')->group(function () {
    Route::resource('admin/rw-profile', App\Http\Controllers\Admin\RwProfileController::class, ['as' => 'admin']);
    Route::resource('admin/rt', App\Http\Controllers\Admin\RtController::class, ['as' => 'admin']);
    Route::resource('admin/map-location', App\Http\Controllers\Admin\MapLocationController::class, ['as' => 'admin']);
    Route::resource('admin/daily-report', App\Http\Controllers\Admin\DailyReportController::class, ['as' => 'admin']);
    Route::resource('admin/pengumuman', App\Http\Controllers\Admin\AnnouncementController::class, ['as' => 'admin']);
    Route::resource('admin/aspirasi', App\Http\Controllers\Admin\AspirationController::class, ['as' => 'admin']);
    Route::resource('admin/kontak', App\Http\Controllers\Admin\ContactController::class, ['as' => 'admin']);
});

Route::middleware('role:admin_rw,admin_rt001,admin_rt002,admin_rt003,admin_karang_taruna')->group(function () {
    Route::resource('admin/pengurus', App\Http\Controllers\Admin\OrganizationalMemberController::class, ['as' => 'admin']);
    Route::resource('admin/data-warga', App\Http\Controllers\Admin\ResidentsStatisticController::class, ['as' => 'admin']);
});

Route::middleware('role:admin_rw,admin_karang_taruna')->group(function () {
    Route::resource('admin/kegiatan', App\Http\Controllers\Admin\EventController::class, ['as' => 'admin']);
    Route::resource('admin/galeri', App\Http\Controllers\Admin\GalleryController::class, ['as' => 'admin']);
    Route::get('admin/karang-taruna', [App\Http\Controllers\Admin\KarangTarunaController::class, 'index'])->name('admin.karang-taruna.index');
    Route::put('admin/karang-taruna/update-profile', [App\Http\Controllers\Admin\KarangTarunaController::class, 'updateProfile'])->name('admin.karang-taruna.update-profile');
});

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('role:admin_rw,admin_rt001,admin_rt002,admin_rt003,admin_karang_taruna')
    ->name('admin.index');
});
