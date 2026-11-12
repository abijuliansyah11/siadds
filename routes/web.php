<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AlumniLamaController;
use App\Http\Controllers\ArsipDigitalController;
use App\Http\Controllers\ArsipFisikController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalonSiswaAksiController;
use App\Http\Controllers\CalonSiswaController;
use App\Http\Controllers\CetakLabelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardDataController;
use App\Http\Controllers\DaftarUlangController;
use App\Http\Controllers\KelengkapanDokumenController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PendaftaranDataController;
use App\Http\Controllers\SeleksiController;
use App\Http\Controllers\SiswaAktifController;
use App\Http\Controllers\SklController;
use App\Http\Controllers\SiswaBaruController;
use App\Http\Controllers\SiswaDetailController;
use App\Http\Controllers\UploadDokumenController;
use App\Http\Controllers\VerifikasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman untuk tamu (belum login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::view('/', 'login')->name('login');
    Route::redirect('/login', '/');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/auth/{provider}/redirect', [\App\Http\Controllers\SocialAuthController::class, 'redirect'])->name('auth.social.redirect');
    Route::get('/auth/{provider}/callback', [\App\Http\Controllers\SocialAuthController::class, 'callback'])->name('auth.social.callback');
});

/*
|--------------------------------------------------------------------------
| Halaman publik — verifikasi keaslian ijazah alumni (tujuan QR Code)
|--------------------------------------------------------------------------
*/
Route::get('/verifikasi-alumni/{nomor}', [AlumniController::class, 'verifikasiPublik'])
    ->where('nomor', '[A-Za-z0-9\-]+')->name('alumni.verifikasi');

/*
|--------------------------------------------------------------------------
| Halaman untuk pengguna yang sudah login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Route::view('/dashboard', 'dashboard')->name('dashboard');   // diganti controller (data dari database)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardDataController::class, 'data'])->name('dashboard.data');
    Route::get('/dashboard/cari', [DashboardDataController::class, 'cari'])->name('dashboard.cari');

    /* ============================================================
       PENERIMAAN — Dilayani controller supaya bisa ambil data DB
       ============================================================ */
    Route::get('/penerimaan', [CalonSiswaController::class, 'index'])->name('penerimaan');

    Route::view('/pendaftaran', 'pendaftaran')->name('pendaftaran');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.simpan');
    Route::view('/calon-siswa', 'calon-siswa')->name('calon');
    Route::get('/calon-siswa/data', [PendaftaranDataController::class, 'index'])->name('calon.data');
    Route::put('/calon-siswa/{id}', [CalonSiswaAksiController::class, 'update'])->whereNumber('id')->name('calon.ubah');
    Route::delete('/calon-siswa/{id}', [CalonSiswaAksiController::class, 'destroy'])->whereNumber('id')->name('calon.hapus');
    // Route::view('/verifikasi', 'verifikasi')->name('verifikasi');   // diganti controller (data dari database)
    Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi');
    Route::put('/verifikasi/{id}', [VerifikasiController::class, 'update'])->whereNumber('id')->name('verifikasi.update');
    // Route::view('/seleksi', 'seleksi')->name('seleksi');   // diganti controller (data dari database)
    Route::get('/seleksi', [SeleksiController::class, 'index'])->name('seleksi');
    Route::post('/seleksi/massal', [SeleksiController::class, 'massal'])->name('seleksi.massal');
    Route::put('/seleksi/{id}', [SeleksiController::class, 'update'])->whereNumber('id')->name('seleksi.update');
    // Route::view('/daftar-ulang', 'daftar-ulang')->name('daftarulang');   // diganti controller (data dari database)
    Route::get('/daftar-ulang', [DaftarUlangController::class, 'index'])->name('daftarulang');
    Route::post('/daftar-ulang/massal', [DaftarUlangController::class, 'massal'])->name('daftarulang.massal');
    Route::post('/daftar-ulang/{id}/syarat', [DaftarUlangController::class, 'syarat'])->whereNumber('id')->name('daftarulang.syarat');
    Route::post('/daftar-ulang/{id}/konversi', [DaftarUlangController::class, 'konversi'])->whereNumber('id')->name('daftarulang.konversi');

    /* ============================================================
       DATA SISWA — Siswa Aktif
       ============================================================ */
    Route::get('/siswa-aktif', [SiswaAktifController::class, 'index'])->name('siswa.aktif');
    Route::get('/siswa-aktif/ekspor', [SiswaAktifController::class, 'ekspor'])->name('siswa.aktif.ekspor');
    Route::get('/siswa-aktif/template-impor', [SiswaAktifController::class, 'template'])->name('siswa.aktif.template');
    Route::post('/siswa-aktif/impor', [SiswaAktifController::class, 'impor'])->name('siswa.aktif.impor');
    Route::put('/siswa-aktif/{id}', [SiswaAktifController::class, 'update'])->whereNumber('id')->name('siswa.aktif.update');
    Route::post('/siswa-aktif/{id}/dokumen', [SiswaAktifController::class, 'unggah'])->whereNumber('id')->name('siswa.aktif.unggah');
    Route::get('/siswa-aktif/{id}/buku-induk', [SiswaAktifController::class, 'bukuInduk'])->whereNumber('id')->name('siswa.aktif.buku');
    Route::get('/siswa-baru', [SiswaBaruController::class, 'create'])->name('siswa.baru');
    Route::get('/siswa-baru/cek', [SiswaBaruController::class, 'cek'])->name('siswa.baru.cek');
    Route::post('/siswa-baru', [SiswaBaruController::class, 'store'])->name('siswa.baru.simpan');
    Route::get('/siswa-detail/{id?}', [SiswaDetailController::class, 'show'])->whereNumber('id')->name('siswa.detail');
    Route::post('/siswa-detail/{id}/dokumen', [SiswaDetailController::class, 'unggah'])->whereNumber('id')->name('siswa.detail.unggah');
    Route::put('/siswa-detail/{id}', [SiswaDetailController::class, 'update'])->whereNumber('id')->name('siswa.detail.update');
    Route::post('/siswa-dokumen/{id}/verifikasi', [SiswaDetailController::class, 'verifikasi'])->whereNumber('id')->name('siswa.dokumen.verifikasi');

    /* ============================================================
       DATA ALUMNI
       ============================================================ */
    Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni');
    Route::get('/alumni/ekspor', [AlumniController::class, 'ekspor'])->name('alumni.ekspor');
    Route::post('/alumni/proses-kelulusan', [AlumniController::class, 'proses'])->name('alumni.proses');
    Route::post('/alumni/{id}/dokumen', [AlumniController::class, 'unggah'])->whereNumber('id')->name('alumni.unggah');
    Route::post('/alumni/{id}/ijazah', [AlumniController::class, 'ijazah'])->whereNumber('id')->name('alumni.ijazah');
    Route::put('/alumni/{id}', [AlumniController::class, 'update'])->whereNumber('id')->name('alumni.update');
    Route::get('/alumni/template-impor', [AlumniController::class, 'template'])->name('alumni.template');
    Route::post('/alumni/impor', [AlumniController::class, 'impor'])->name('alumni.impor');
    Route::get('/alumni/{id}/cetak', [AlumniController::class, 'cetak'])->whereNumber('id')->name('alumni.cetak');
    Route::post('/alumni/{id}/batal-kelulusan', [AlumniController::class, 'batal'])->whereNumber('id')->name('alumni.batal');
    Route::post('/alumni/tambah-lama', [AlumniLamaController::class, 'store'])->name('alumni.lama');
    Route::post('/alumni/{id}/arsip-fisik', [AlumniLamaController::class, 'catat'])->whereNumber('id')->name('alumni.arsipfisik');

    /* ============================================================
       API CRUD — Calon Siswa
       ============================================================ */
    Route::prefix('api/calon-siswa')->name('calon-siswa.')->group(function () {
        Route::get   ('/',              [CalonSiswaController::class, 'index'])->name('index');
        Route::post  ('/',              [CalonSiswaController::class, 'store'])->name('store');
        Route::put   ('/{id}',          [CalonSiswaController::class, 'update'])->name('update');
        Route::delete('/{id}',          [CalonSiswaController::class, 'destroy'])->name('destroy');
        Route::get   ('/export/{fmt}',  [CalonSiswaController::class, 'export'])->name('export');
    });

    /* ============================================================
       ARSIP DIGITAL & FISIK — Direktori Arsip Digital
       ============================================================ */
    Route::get('/arsip-digital', [ArsipDigitalController::class, 'index'])->name('arsip.digital');
    Route::get('/arsip-digital/ekspor', [ArsipDigitalController::class, 'ekspor'])->name('arsip.digital.ekspor');
    Route::get('/arsip-digital/{id}/lihat', [ArsipDigitalController::class, 'lihat'])->whereNumber('id')->name('arsip.digital.lihat');
    Route::get('/arsip-digital/{id}/unduh', [ArsipDigitalController::class, 'unduh'])->whereNumber('id')->name('arsip.digital.unduh');
    Route::post('/arsip-digital/{id}/keputusan', [ArsipDigitalController::class, 'putuskan'])->whereNumber('id')->name('arsip.digital.putuskan');
    Route::get('/arsip-digital/{id}/hash', [ArsipDigitalController::class, 'hash'])->whereNumber('id')->name('arsip.digital.hash');
    Route::post('/arsip-digital/massal', [ArsipDigitalController::class, 'massal'])->name('arsip.digital.massal');
    Route::post('/arsip-digital/zip', [ArsipDigitalController::class, 'zip'])->name('arsip.digital.zip');

    /* ============================================================
       ARSIP DIGITAL & FISIK — Upload Dokumen
       ============================================================ */
    Route::get('/upload-dokumen', [UploadDokumenController::class, 'index'])->name('upload.dokumen');
    Route::get('/upload-dokumen/cari', [UploadDokumenController::class, 'cari'])->name('upload.dokumen.cari');
    Route::post('/upload-dokumen', [UploadDokumenController::class, 'simpan'])->name('upload.dokumen.simpan');

    /* ============================================================
       ARSIP DIGITAL & FISIK — Kelengkapan Dokumen
       ============================================================ */
    Route::get('/kelengkapan-dokumen', [KelengkapanDokumenController::class, 'index'])->name('kelengkapan.dokumen');
    Route::get('/kelengkapan-dokumen/ekspor', [KelengkapanDokumenController::class, 'ekspor'])->name('kelengkapan.dokumen.ekspor');

    /* ============================================================
       ARSIP DIGITAL & FISIK — Lokasi Arsip Fisik
       ============================================================ */
    Route::get('/arsip-fisik', [ArsipFisikController::class, 'index'])->name('arsip.fisik');
    Route::post('/arsip-fisik', [ArsipFisikController::class, 'simpanArsip'])->name('arsip.fisik.simpan');
    Route::post('/arsip-fisik/lokasi', [ArsipFisikController::class, 'simpanLokasi'])->name('arsip.fisik.lokasi');
    Route::post('/arsip-fisik/sinkron', [ArsipFisikController::class, 'sinkron'])->name('arsip.fisik.sinkron');
    Route::post('/arsip-fisik/massal', [ArsipFisikController::class, 'pindahMassal'])->name('arsip.fisik.massal');
    Route::post('/arsip-fisik/{id}/pindah', [ArsipFisikController::class, 'pindah'])->whereNumber('id')->name('arsip.fisik.pindah');
    Route::post('/arsip-fisik/{id}/pinjam', [ArsipFisikController::class, 'pinjam'])->whereNumber('id')->name('arsip.fisik.pinjam');
    Route::post('/arsip-fisik/{id}/kembali', [ArsipFisikController::class, 'kembali'])->whereNumber('id')->name('arsip.fisik.kembali');
    Route::post('/arsip-fisik/{id}/kondisi', [ArsipFisikController::class, 'kondisi'])->whereNumber('id')->name('arsip.fisik.kondisi');
    Route::post('/arsip-fisik/{id}/koreksi', [ArsipFisikController::class, 'koreksi'])->whereNumber('id')->name('arsip.fisik.koreksi');

    /* ============================================================
       ARSIP DIGITAL & FISIK — Cetak Label QR Code
       ============================================================ */
    Route::get('/cetak-label', [CetakLabelController::class, 'index'])->name('label.qr');
    Route::get('/cetak-label/ekspor', [CetakLabelController::class, 'ekspor'])->name('label.qr.ekspor');
    Route::post('/cetak-label/buat', [CetakLabelController::class, 'buat'])->name('label.qr.buat');
    Route::post('/cetak-label/cetak', [CetakLabelController::class, 'cetak'])->name('label.qr.cetak');

    // Cetak SKL (Surat Keterangan Lulus) di halaman Cetak Label QR Code
    Route::get('/cetak-label/skl', [SklController::class, 'daftar'])->name('label.skl.daftar');
    Route::get('/cetak-label/skl/cetak', [SklController::class, 'cetak'])->name('label.skl.cetak');
    Route::post('/cetak-label/skl/catat', [SklController::class, 'catat'])->name('label.skl.catat');
    Route::post('/cetak-label/skl/pengaturan', [SklController::class, 'simpanPengaturan'])->name('label.skl.pengaturan');
    Route::get('/cetak-label/skl/{id}', [SklController::class, 'detail'])->whereNumber('id')->name('label.skl.detail');
    Route::put('/cetak-label/skl/{id}', [SklController::class, 'simpan'])->whereNumber('id')->name('label.skl.simpan');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});