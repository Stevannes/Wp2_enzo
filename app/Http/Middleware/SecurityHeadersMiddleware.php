<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request and attach enterprise-grade HTTP security headers.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // Remove PHP fingerprint header
        if (function_exists('header_remove')) {
            @header_remove('X-Powered-By');
        }
        $response->headers->remove('X-Powered-By');

        // Prevent clickjacking attacks (iframe framing protection)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent MIME-type sniffing (Anti-MIME sniffing protection)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Legacy XSS filter activation
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer-Policy to prevent leaking sensitive URLs / tokens
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy (Feature Policy) to restrict sensitive hardware access
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        // Content Security Policy (CSP) tailored for the application
        $csp = "default-src 'self'; "
            ."script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://cdn.jsdelivr.net https://unpkg.com; "
            ."style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.tailwindcss.com; "
            ."font-src 'self' https://fonts.gstatic.com data:; "
            ."img-src 'self' data: https: blob:; "
            ."connect-src 'self' https:; "
            ."frame-ancestors 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
