<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CostEstimatorController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\DesignLayoutController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryRfpController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SpecificationComparisonController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - ENZO Construction Web Platform & Lead Generation Engine
| Mengakomodasi 10 Poin Evaluasi & Masukan Dosen + Hardened Security
|--------------------------------------------------------------------------
*/

// Wireframe 1: Beranda (Landing Page - PT MKP Style)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Wireframe 2 & Poin 10: Portofolio Proyek & Fitur Before-After + Privasi Residensial
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

// Poin 2 Evaluasi Dosen: Katalog Referensi Desain & Pemilihan Tata Letak (Layout Siap Bangun)
Route::get('/layouts', [DesignLayoutController::class, 'index'])->name('layouts.index');
Route::get('/layouts/{slug}', [DesignLayoutController::class, 'show'])->name('layouts.show');

// Poin 3 Evaluasi Dosen: Matriks Komparatif Spesifikasi Teknis Material Rinci
Route::get('/specifications', [SpecificationComparisonController::class, 'index'])->name('specifications.index');

// Wireframe 3: Kalkulator Estimasi Biaya Bangun (RAB Interaktif) + Rate Limiting
Route::get('/estimator', [CostEstimatorController::class, 'index'])->name('estimator.index');
Route::post('/estimator/calculate', [CostEstimatorController::class, 'calculate'])
    ->middleware('throttle:calculator')
    ->name('estimator.calculate');

// Wireframe 4 & Poin 6, 7, 8, 9: Formulir Tender (RFP), Tracking Progres Mandor, Komplain & Testimoni (Protected: Wajib Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/rfp', [InquiryRfpController::class, 'create'])->name('rfp.create');
    Route::post('/rfp', [InquiryRfpController::class, 'store'])
        ->middleware('throttle:rfp-submission')
        ->name('rfp.store');
    Route::get('/rfp/track', [InquiryRfpController::class, 'track'])->name('rfp.track');
    Route::post('/rfp/{id}/complaint', [InquiryRfpController::class, 'storeComplaint'])
        ->middleware('throttle:complaint-submission')
        ->name('rfp.complaint.store');
    Route::post('/rfp/{id}/testimonial', [InquiryRfpController::class, 'storeTestimonial'])
        ->middleware('throttle:testimonial-submission')
        ->name('rfp.testimonial.store');
});

// ========================================================
// CUSTOMER AUTHENTICATION (SIGN IN & SIGN UP)
// ========================================================
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register'])
        ->middleware('throttle:5,1')
        ->name('register.submit');
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
});

// Direct friendly aliases for standard login & register
Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');

// Google OAuth Authentication
Route::prefix('auth/google')->name('auth.google.')->group(function () {
    Route::get('/redirect', [GoogleAuthController::class, 'redirectToGoogle'])->name('redirect');
    Route::get('/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('callback');
});

// Password Reset / Update via Email Verification Code (Two-Stage Flow)
Route::get('/forgot-password', [PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetCode'])
    ->middleware('throttle:5,1')
    ->name('password.email');

// Stage 1: Input & Verify 6-digit code
Route::get('/verify-password-code', [PasswordResetController::class, 'showVerifyForm'])->name('password.verify');
Route::post('/verify-password-code', [PasswordResetController::class, 'verifyCode'])
    ->middleware('throttle:10,1')
    ->name('password.verify.submit');

// Stage 2: Set New Password (only accessible after Stage 1 verification)
Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
    ->middleware('throttle:5,1')
    ->name('password.update');

// Customer Dashboard & Profile (Secured with auth middleware)
Route::prefix('customer')->name('customer.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::post('/profile', [CustomerDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/send-password-code', [PasswordResetController::class, 'sendDashboardVerificationCode'])
        ->middleware('throttle:3,1')
        ->name('password.send-code');
});

// ========================================================
// ADMIN CMS & EXECUTIVE DASHBOARD
// ========================================================
// Admin Authentication Routes (Protected by Anti-Brute-Force Throttle)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:admin-login')
        ->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Wireframe 5 & Poin 4, 5, 9: Dashboard Admin CMS (Secured with 'admin.auth' Role-Based Middleware)
Route::prefix('admin')->name('admin.')->middleware(['admin.auth'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/rfp/{id}', [AdminDashboardController::class, 'rfpShow'])->name('rfp.show');
    Route::post('/rfp/{id}/status', [AdminDashboardController::class, 'rfpUpdateStatus'])->name('rfp.status');
    Route::post('/rfp/{id}/assign', [AdminDashboardController::class, 'rfpAssign'])->name('rfp.assign');
    Route::post('/rfp/{id}/negotiate', [AdminDashboardController::class, 'rfpNegotiate'])->name('rfp.negotiate');
    Route::post('/rfp/{id}/progress-log', [AdminDashboardController::class, 'storeProgressLog'])->name('rfp.progressLog');
    Route::post('/rfp/{id}/publish-portfolio', [AdminDashboardController::class, 'publishToPortfolio'])->name('rfp.publishPortfolio');
    Route::get('/attachment/{id}/download', [AdminDashboardController::class, 'downloadAttachment'])->name('attachment.download');
});
