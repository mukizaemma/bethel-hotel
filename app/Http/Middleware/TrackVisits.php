<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldTrack($request)) {
            return $response;
        }

        try {
            DB::table('visits')->insert([
                'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referrer' => $request->headers->get('referer'),
                'method' => $request->method(),
                'path' => Str::limit('/'.ltrim($request->path(), '/'), 512, ''),
                'url' => $request->fullUrl(),
                'country_code' => $this->resolveCountryCode($request),
                'visited_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (Throwable $e) {
            // Never break user requests if visit tracking fails.
        }

        return $response;
    }

    private function shouldTrack(Request $request): bool
    {
        if (! $request->isMethod('GET') || $request->ajax() || $request->expectsJson()) {
            return false;
        }

        $path = ltrim($request->path(), '/');
        $excludedPrefixes = [
            'admin',
            'dashboard',
            'content-management',
            'livewire',
            'storage',
            '_debugbar',
            'sanctum',
            'api',
        ];

        foreach ($excludedPrefixes as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix.'/')) {
                return false;
            }
        }

        $ua = strtolower((string) $request->userAgent());
        if ($ua !== '' && preg_match('/bot|crawl|spider|slurp|preview|headless|uptime/i', $ua) === 1) {
            return false;
        }

        return true;
    }

    private function resolveCountryCode(Request $request): ?string
    {
        $fromHeaders = $request->headers->get('CF-IPCountry')
            ?: $request->headers->get('X-AppEngine-Country')
            ?: $request->headers->get('CloudFront-Viewer-Country');

        if (! is_string($fromHeaders) || trim($fromHeaders) === '') {
            return null;
        }

        return strtoupper(substr(trim($fromHeaders), 0, 8));
    }
}
