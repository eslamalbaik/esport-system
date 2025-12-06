<?php

namespace App\Http\Middleware;

use App\Models\SiteVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackSiteVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->shouldTrack($request)) {
            $this->recordVisit($request);
        }

        return $next($request);
    }

    protected function shouldTrack(Request $request): bool
    {
        if (app()->runningInConsole()) {
            return false;
        }

        if (! $request->isMethod('GET')) {
            return false;
        }

        if ($request->expectsJson()) {
            return false;
        }

        if ($request->is('admin') || $request->is('admin/*')) {
            return false;
        }

        return true;
    }

    protected function recordVisit(Request $request): void
    {
        try {
            SiteVisit::create([
                'session_id' => $request->session()->getId(),
                'ip_address' => $request->ip(),
                'user_agent' => (string) $request->header('User-Agent'),
                'url' => $request->fullUrl(),
            ]);

            Cache::forget('site_visits_total');
        } catch (\Throwable $exception) {
            report($exception);
        }
    }
}
