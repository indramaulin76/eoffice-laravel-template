<?php

use App\Http\Controllers\ArsipSuratKeluarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanDinasController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerjalananDinasController;
use App\Http\Controllers\RapatController;
use App\Http\Controllers\SppdController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\VerifikasiLaporanDinasController;
use App\Http\Controllers\VerifikasiSuratKeluarController;
use App\Http\Controllers\VerifikasiTugasController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/rapat', [RapatController::class, 'index'])->name('rapat.index')->middleware('auth');
Route::post('/rapat/store', [RapatController::class, 'store'])->name('rapat.store')->can('buat rapat');
Route::get('/rapat/create', [RapatController::class, 'create'])->name('rapat.create')->can('buat rapat');
Route::get('/rapat/{rapat}/', [RapatController::class, 'show'])->name('rapat.show')->middleware('auth');
Route::patch('/rapat/{rapat}/presensi/peserta/{peserta}', [RapatController::class, 'updatePresensiPeserta'])->name('rapat.attendance.update')->middleware('auth');
Route::patch('/rapat/update/{rapat}', [RapatController::class, 'update'])->name('rapat.update')->middleware('auth');
Route::delete('/rapat/destroy/{rapat}', [RapatController::class, 'destroy'])->name('rapat.destroy')->middleware('auth');

Route::get('/surat-masuk', [SuratMasukController::class, 'index'])->name('surat-masuk.index')->middleware('auth');
Route::get('/surat-masuk/create', [SuratMasukController::class, 'create'])->name('surat-masuk.create')->can('buat surat');
Route::post('/surat-masuk/store', [SuratMasukController::class, 'store'])->name('surat-masuk.store')->can('buat surat');;
Route::get('/surat-masuk/show/{surat}', [SuratMasukController::class, 'show'])->name('surat-masuk.show')->middleware('auth');
Route::get('/surat-masuk/edit/{surat}', [SuratMasukController::class, 'edit'])->name('surat-masuk.edit')->middleware('auth');
Route::patch('/surat-masuk/update/{surat}', [SuratMasukController::class, 'update'])->name('surat-masuk.update')->middleware('auth');
Route::delete('/surat-masuk/destroy/{surat}', [SuratMasukController::class, 'destroy'])->name('surat-masuk.destroy')->middleware('auth');

Route::get('/surat-keluar', [SuratKeluarController::class, 'index'])->name('surat-keluar.index')->middleware('auth');
Route::get('/surat-keluar/show/{surat}', [SuratKeluarController::class, 'show'])->name('surat-keluar.show')->middleware('auth');

Route::get('/surat-keluar/create', [SuratKeluarController::class, 'create'])->name('surat-keluar.create')->can('buat surat');;
Route::post('/surat-keluar/store', [SuratKeluarController::class, 'store'])->name('surat-keluar.store')->can('buat surat');;
Route::get('/surat-keluar/edit/{surat}', [SuratKeluarController::class, 'edit'])->name('surat-keluar.edit')->middleware('auth');
Route::patch('/surat-keluar/update/{surat}', [SuratKeluarController::class, 'update'])->name('surat-keluar.update')->middleware('auth');
Route::delete('/surat-keluar/destroy/{surat}', [SuratKeluarController::class, 'destroy'])->name('surat-keluar.destroy')->middleware('auth');

Route::middleware('can:revisi')->group(function () {
    Route::get('/surat-keluar/verifikasi', [VerifikasiSuratKeluarController::class, 'index'])->name('surat-keluar.verifikasi.index');
    Route::post('/surat-keluar/verifikasi/{surat:nomor_surat}/terima', [VerifikasiSuratKeluarController::class, 'terima'])->name('surat-keluar.verifikasi.terima');
    Route::post('/surat-keluar/verifikasi/{surat:nomor_surat}/tolak', [VerifikasiSuratKeluarController::class, 'tolak'])->name('surat-keluar.verifikasi.tolak');
    Route::get('/surat-keluar/verifikasi/show/{surat:nomor_surat}', [VerifikasiSuratKeluarController::class, 'show'])->name('surat-keluar.verifikasi.show');
});

Route::get('/surat-keluar/arsip', [ArsipSuratKeluarController::class, 'index'])->name('surat-keluar.arsip.index')->middleware('auth');
Route::get('/surat-keluar/arsip/show/{surat}', [ArsipSuratKeluarController::class, 'show'])->name('surat-keluar.arsip.show')->middleware('auth');
Route::patch('/surat-keluar/arsip/update/{surat}', [ArsipSuratKeluarController::class, 'update'])->name('surat-keluar.arsip.update')->middleware('auth');

Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index')->middleware('auth');
Route::get('/tugas/create', [TugasController::class, 'create'])->name('tugas.create')->middleware('auth');
Route::post('/tugas/store', [TugasController::class, 'store'])->name('tugas.store')->middleware('auth');
Route::get('/tugas/show/{tugas}', [TugasController::class, 'show'])->name('tugas.show')->middleware('auth');
Route::get('/tugas/edit/{tugas}', [TugasController::class, 'edit'])->name('tugas.edit')->middleware('auth');
Route::patch('/tugas/update/{tugas}', [TugasController::class, 'update'])->name('tugas.update')->middleware('auth');
Route::delete('/tugas/destroy/{tugas}', [TugasController::class, 'destroy'])->name('tugas.destroy')->middleware('auth');

Route::middleware('can:revisi')->prefix('/tugas/verifikasi')->group(function () {
    Route::get('/', [VerifikasiTugasController::class, 'index'])->name('tugas.verifikasi.index');
    Route::get('/{tugas}', [VerifikasiTugasController::class, 'show'])->name('tugas.verifikasi.show');
    Route::post('/{tugas}/terima', [VerifikasiTugasController::class, 'terima'])->name('tugas.verifikasi.terima');
    Route::post('/{tugas}/tolak', [VerifikasiTugasController::class, 'tolak'])->name('tugas.verifikasi.tolak');
});

Route::get('/perjalanan-dinas', [PerjalananDinasController::class, 'index'])->name('perjalanan-dinas.index')->middleware('auth');

Route::get('/perjalanan-dinas/sppd', [SppdController::class, 'index'])->name('sppd.index')->middleware('auth');
Route::get('/perjalanan-dinas/sppd/create', [SppdController::class, 'create'])->name('sppd.create')->can('buat sppd');
Route::post('/perjalanan-dinas/sppd/store', [SppdController::class, 'store'])->name('sppd.store')->can('buat sppd');
Route::get('/perjalanan-dinas/sppd/show/{sppd}', [SppdController::class, 'show'])->name('sppd.show')->middleware('auth');
Route::get('/perjalanan-dinas/sppd/edit/{sppd}', [SppdController::class, 'edit'])->name('sppd.edit')->middleware('auth');
Route::patch('/perjalanan-dinas/sppd/update/{sppd}', [SppdController::class, 'update'])->name('sppd.update')->middleware('auth');
Route::delete('/perjalanan-dinas/sppd/destroy/{sppd}', [SppdController::class, 'destroy'])->name('sppd.destroy')->middleware('auth');

Route::get('/perjalanan-dinas/laporan', [LaporanDinasController::class, 'index'])->name('laporan-dinas.index')->middleware('auth');
Route::get('/perjalanan-dinas/laporan/create', [LaporanDinasController::class, 'create'])->name('laporan-dinas.create')->middleware('auth');
Route::post('/perjalanan-dinas/laporan/store', [LaporanDinasController::class, 'store'])->name('laporan-dinas.store')->middleware('auth');
Route::get('/perjalanan-dinas/laporan/show/{perjalananDinas}', [LaporanDinasController::class, 'show'])->name('laporan-dinas.show')->middleware('auth');
Route::get('/perjalanan-dinas/laporan/edit/{laporan}', [LaporanDinasController::class, 'edit'])->name('laporan-dinas.edit')->middleware('auth');
Route::patch('/perjalanan-dinas/laporan/update/{laporan}', [LaporanDinasController::class, 'update'])->name('laporan-dinas.update')->middleware('auth');
Route::delete('/perjalanan-dinas/laporan/destroy/{laporan}', [LaporanDinasController::class, 'destroy'])->name('laporan-dinas.destroy')->middleware('auth');

Route::middleware('can:revisi')->group(function() {
    Route::get('/perjalanan-dinas/laporan/verifikasi', [VerifikasiLaporanDinasController::class, 'index'])->name('laporan-dinas.verifikasi.index');
    Route::get('/perjalanan-dinas/laporan/verifikasi/{laporan}', [VerifikasiLaporanDinasController::class, 'show'])->name('laporan-dinas.verifikasi.show');
    Route::post('/perjalanan-dinas/laporan/verifikasi/{laporan}/terima', [VerifikasiLaporanDinasController::class, 'terima'])->name('laporan-dinas.verifikasi.terima');
    Route::post('/perjalanan-dinas/laporan/verifikasi/{laporan}/tolak', [VerifikasiLaporanDinasController::class, 'tolak'])->name('laporan-dinas.verifikasi.tolak');
});

Route::get('/log', [LogController::class, 'index'])->name('log.index')->middleware('auth');
Route::get('/log/{log}', [LogController::class, 'show'])->name('log.show')->middleware('auth');
