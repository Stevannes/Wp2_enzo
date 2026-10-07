<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CostEstimatorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryRfpController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - ENZO Construction Web Platform & Lead Generation Engine
|--------------------------------------------------------------------------
*/

// Wireframe 1: Beranda (Landing Page - PT MKP Style)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Wireframe 2: Portofolio Proyek & Fitur Before-After
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

// Wireframe 3: Kalkulator Estimasi Biaya Bangun (RAB Interaktif)
Route::get('/estimator', [CostEstimatorController::class, 'index'])->name('estimator.index');
Route::post('/estimator/calculate', [CostEstimatorController::class, 'calculate'])->name('estimator.calculate');

// Wireframe 4: Formulir Pengajuan Penawaran Tender (RFP) & Tracking
Route::get('/rfp', [InquiryRfpController::class, 'create'])->name('rfp.create');
Route::post('/rfp', [InquiryRfpController::class, 'store'])->name('rfp.store');
Route::get('/rfp/track', [InquiryRfpController::class, 'track'])->name('rfp.track');

// Wireframe 5: Dashboard Admin CMS & Lead Pipeline Tracker
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/rfp/{id}', [AdminDashboardController::class, 'rfpShow'])->name('rfp.show');
    Route::post('/rfp/{id}/status', [AdminDashboardController::class, 'rfpUpdateStatus'])->name('rfp.status');
    Route::get('/attachment/{id}/download', [AdminDashboardController::class, 'downloadAttachment'])->name('attachment.download');
});
