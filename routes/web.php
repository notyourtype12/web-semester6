<?php

use Illuminate\Support\Facades\Route;

// ADMIN
use App\Http\Controllers\Admin\AkunRtController;
use App\Http\Controllers\Admin\AkunRwController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GeneratePDFController;
use App\Http\Controllers\Admin\KartuKeluargaController;
use App\Http\Controllers\Admin\LandingpageController;
use App\Http\Controllers\Admin\PendudukController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\SuratController;
use App\Http\Controllers\Admin\SuratDitolakController;
use App\Http\Controllers\Admin\SuratMasukController;
use App\Http\Controllers\Admin\SuratSelesaiController;


// RW
use App\Http\Controllers\RW\DashboardRWController;
use App\Http\Controllers\RW\SuratMasukRWController;
use App\Http\Controllers\RW\SuratSelesaiRWController;


// RT
use App\Http\Controllers\RT\DashboardRTController;
use App\Http\Controllers\RT\SuratMasukRTController;
use App\Http\Controllers\RT\SuratDitolakRTController;
use App\Http\Controllers\RT\SuratSelesaiRTController;


// USER
use App\Http\Controllers\LandingBeritaController;
use App\Http\Controllers\LoginController;



// DASHBOARD
Route::get('/', [LandingpageController::class, 'tampil'])->name('website');

Route::get('/check-nama-nik', function () {
    return view('cekk');
})->middleware('auth');  // Pastikan hanya yang login yang bisa mengakses

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.proses')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/landingpage', [LandingBeritaController::class, 'index'])->name('landingpage.index');
Route::get('/landingpage/{id_berita}', [LandingBeritaController::class, 'show'])->name('landingpage.show');


// RT
Route::middleware(['auth', 'role:3'])->prefix('rt')->group(function () {

    Route::get('/dashboard-rt', [DashboardRTController::class, 'index'])->name('dashboard.rt');

    // SURAT MASUK
    Route::get('/surat-masuk', [SuratMasukRTController::class, 'index'])->name('rt.suratmasuk.index');
    Route::post('/surat-masuk/setujui/{id_pengajuan}', [SuratMasukRTController::class, 'setujui'])->name('rt.suratmasuk.setuju');
    Route::post('/surat-masuk/tolak/{id_pengajuan}', [SuratMasukRTController::class, 'tolak'])->name('rt.suratmasuk.tolak');

    // SURAT SELESAI
    Route::get('/surat-selesai', [SuratSelesaiRTController::class, 'index'])->name('rt.suratselesai.index');
    Route::get('/surat-selesai/{id}', [SuratSelesaiRTController::class, 'show'])->name('rt.suratselesai.show');
    Route::delete('/surat-selesai/{id}', [SuratSelesaiRTController::class, 'destroy'])->name('rt.suratselesai.destroy');

    // SURAT DITOLAK
    Route::get('/surat-ditolak', [SuratDitolakRTController::class, 'index'])->name('rt.suratditolak.index');
    Route::get('/surat-ditolak/{id}', [SuratDitolakRTController::class, 'show'])->name('rt.suratditolak.show');
    Route::post('/surat-ditolak/alasan', [SuratDitolakRTController::class, 'alasanPenolakan'])->name('rt.suratditolak.alasan');
    Route::delete('/rt/surat-ditolak/{id}', [SuratDitolakRTController::class, 'destroy'])->name('rt.suratditolak.destroy');

});


// RW
Route::middleware(['auth', 'role:2'])->prefix('rw')->group(function () {

    Route::get('/dashboard-rw', [DashboardRWController::class, 'index'])->name('rw.dashboard');

    // SURAT MASUK
    Route::get('/surat-masuk', [SuratMasukRWController::class, 'index'])->name('rw.suratmasuk.index');
    Route::get('/surat-masuk/{id_pengajuan}', [SuratMasukRWController::class, 'show'])->name('rw.suratmasuk.show');
    Route::post('/surat-masuk/setujui/{id_pengajuan}', [SuratMasukRWController::class, 'setujui'])->name('rw.suratmasuk.setujui');
    Route::delete('/surat-masuk/{id_pengajuan}', [SuratMasukRWController::class, 'destroy'])->name('rw.suratmasuk.destroy');

    // SURAT SELESAI
    Route::get('/surat-selesai', [SuratSelesaiRWController::class, 'index'])->name('rw.suratselesai.index');
    Route::get('/surat-selesai/{id_pengajuan}', [SuratSelesaiRWController::class, 'show'])->name('rw.suratselesai.show');
    Route::delete('/surat-selesai/{id}', [SuratSelesaiRWController::class, 'destroy'])->name('rw.suratselesai.destroy');
});


// ADMIN
Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // BERITA
    Route::resource('berita', BeritaController::class);
    Route::get('upload/berita', [BeritaController::class, 'index'])->name('admin.berita.index');
    Route::get('upload/berita/create', [BeritaController::class, 'create'])->name('admin.berita.create');
    Route::post('upload/berita/create', [BeritaController::class, 'store'])->name('admin.berita.store');
    Route::get('upload/berita/{id}/edit', [BeritaController::class, 'edit'])->name('admin.berita.edit');
    Route::put('upload/berita/{id}', [BeritaController::class, 'update'])->name('admin.berita.update');
    Route::delete('upload/berita/{id}/delete', [BeritaController::class, 'destroy'])->name('admin.berita.destroy');
    Route::post('/upload-image', [BeritaController::class, 'uploadImage'])->name('upload.image');

    // KARTU KELUARGA
    Route::get('master_kartukeluarga', [KartuKeluargaController::class, 'index'])->name('kartukeluarga.view');
    Route::post('master_kartukeluarga/masuk', [KartuKeluargaController::class, 'masuk'])->name('kartukeluarga.masuk');
    Route::put('master_kartukeluarga/{no_kk}', [KartuKeluargaController::class, 'update'])->name('kartukeluarga.update');
    Route::delete('master_kartukeluarga/{no_kk}', [KartuKeluargaController::class, 'delete'])->name('kartukeluarga.delete');
    Route::get('get-data-kk/{no_kk}', [KartuKeluargaController::class, 'getDataKK']);

    // MASTER PENDUDUK
    Route::get('master_penduduk', [PendudukController::class, 'index']);
    Route::post('master_penduduk/masuk', [PendudukController::class, 'masuk']);
    Route::put('master_penduduk/{nik}', [PendudukController::class, 'update']);
    Route::get('master_penduduk/{nik}', [PendudukController::class, 'delete'])->name('penduduk.delete');
    Route::get('master_penduduk/cetak-draft-kk/{no_kk}', [GeneratePDFController::class, 'draftKK'])->name('draftkk');

    // MASTER AKUN RW
    Route::get('akunrw/create', [AkunRwController::class, 'create']);
    Route::get('/akunrw', [AkunRwController::class, 'index'])->name('akunrw');
    Route::post('akunrw/store', [AkunRwController::class, 'store'])->name('akunrw.store');
    Route::put('akunrw/update/{id}', [AkunRwController::class, 'update'])->name('akunrw.update');
    Route::delete('akunrw/{id}', [AkunRwController::class, 'destroy'])->name('akun.destroy');
    Route::get('get-nama-rw', [AkunRwController::class, 'getNamaRw']);

    // MASTER AKUN RT
    Route::get('akunrt/create', [AkunRtController::class, 'create']);
    Route::get('/akunrt', [AkunRtController::class, 'index'])->name('akunrt');
    Route::post('akunrt/store', [AkunRtController::class, 'store'])->name('akun.store');
    Route::put('akunrt/update/{id}', [AkunRtController::class, 'update'])->name('akun.update');
    Route::get('akunrt/{id_rtrw}', [AkunRtController::class, 'destroy'])->name('akunrt.destroy');
    Route::get('get-nama-by-nik', [AkunRtController::class, 'getNamaByNik']); 

    // LANDINGPAGE
    Route::get('/landingpage', [LandingpageController::class, 'index'])->name('homepage.index');
    Route::post('/landingpage', [LandingpageController::class, 'update'])->name('homepage.update');

    // SURAT MASUK
    Route::get('/suratmasuk', [SuratMasukController::class, 'index'])->name('pengajuan.masuk');
    Route::post('/suratmasuk/{id_pengajuan}/setuju', [SuratMasukController::class, 'setuju'])->name('pengajuan.setuju');
    Route::post('/suratmasuk/{id_pengajuan}/tolak', [SuratMasukController::class, 'tolak'])->name('pengajuan.tolak');
    Route::delete('/suratmasuk/{id_pengajuan}/delete', [SuratMasukController::class, 'destroy'])->name('pengajuan.hapus');
    Route::get('/suratmasuk/{id_pengajuan}/cetak', [GeneratePDFController::class, 'generateAndStorePdf']);

    // SURAT DITOLAK
    Route::get('/suratditolak', [SuratditolakController::class, 'index'])->name('suratditolak.tampil');
    Route::delete('/suratditolak/{id_pengajuan}/delete', [SuratditolakController::class, 'destroy'])->name('suratditolak.hapus');

    // SURAT SELESAI
    Route::get('/suratselesai', [SuratSelesaiController::class, 'index'])->name('suratselesai.index');

    // MASTER SURAT
    Route::get('/mastersurat', [SuratController::class, 'index'])->name('mastersurat.index');
    Route::post('/mastersurat/masuk', [SuratController::class, 'store'])->name('mastersurat.store');
    Route::put('/mastersurat/update/{id}', [SuratController::class, 'update'])->name('mastersurat.update');
    Route::delete('/mastersurat/delete/{id}', [SuratController::class, 'destroy'])->name('mastersurat.destroy');
    Route::get('suratmasuk/{id}/cetak', [GeneratePDFController::class, 'generateAndStorePdf']);

    // MASTER PENGADUAN
    Route::get('pengaduan', [PengaduanController::class, 'index'])->name('master-pengaduan.index');
    Route::get('pengaduan/create', [PengaduanController::class, 'create'])->name('master-pengaduan.create');
    Route::post('pengaduan', [PengaduanController::class, 'store'])->name('master-pengaduan.store');
    Route::get('pengaduan/{id}', [PengaduanController::class, 'show'])->name('master-pengaduan.show');
    Route::delete('pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('master-pengaduan.destroy');
    Route::post('/pengaduan/{id}/feedback', [PengaduanController::class, 'feedback'])->name('pengaduan.feedback');
});