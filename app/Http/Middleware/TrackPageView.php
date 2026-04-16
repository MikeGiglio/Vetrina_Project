<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track GET requests
        if ($request->isMethod('GET')) {
            $path = $request->path();

            // Skip admin, api, assets, livewire
            $skipPrefixes = ['admin', 'api', '_debugbar', 'livewire', 'up'];
            foreach ($skipPrefixes as $prefix) {
                if ($path === $prefix || str_starts_with($path, $prefix . '/')) {
                    return $response;
                }
            }

            // Skip static asset extensions
            if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|ico|woff|woff2|ttf|map|avif|webp)$/i', $path)) {
                return $response;
            }

            // Skip bots and internal dev tools
            $ua = $request->userAgent() ?? '';
            if (preg_match('/bot|crawl|spider|curl|wget|Herd\/|Electron\//i', $ua)) {
                return $response;
            }

            try {
                $ip = $request->ip();
                // Normalize IPv6 loopback and LAN to a single local identifier
                if (in_array($ip, ['::1', '0:0:0:0:0:0:0:1'])) {
                    $ip = '127.0.0.1';
                }

                PageView::create([
                    'ip_address' => $ip,
                    'user_agent' => $ua ?: null,
                    'page'       => '/' . $path,
                    'referer'    => $request->header('referer') ?: null,
                    'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                ]);
            } catch (\Throwable) {
                // Never break the request if tracking fails
            }
        }

        return $response;
    }
}
