<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services with strict security rate limiting.
     */
    public function boot(): void
    {
        // Rate limiter for RFP tender submissions (Anti-Spam & Anti-DDoS)
        RateLimiter::for('rfp-submission', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())->response(function () {
                return back()->with('error', 'Terlalu banyak permintaan tender dalam waktu singkat. Mohon tunggu beberapa saat sebelum mengirim kembali demi keamanan sistem.');
            });
        });

        // Rate limiter for customer complaint submissions
        RateLimiter::for('complaint-submission', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())->response(function () {
                return back()->with('error', 'Batas pengiriman keluhan tercapai (Anti-Spam). Mohon tunggu sejenak.');
            });
        });

        // Rate limiter for client testimonials
        RateLimiter::for('testimonial-submission', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())->response(function () {
                return back()->with('error', 'Batas pengiriman testimoni tercapai. Mohon tunggu sejenak.');
            });
        });

        // Rate limiter for cost estimator interactive API calculations
        RateLimiter::for('calculator', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip());
        });

        // Rate limiter for Admin Login attempts
        RateLimiter::for('admin-login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}
