<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\LoggingService;

class LogActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Log successful page views and API calls
        if ($request->user() && $response->status() < 400) {
            $path = $request->path();
            
            // Skip logging for certain paths
            $skipPaths = ['logs', 'backups', 'dashboard', 'home'];
            $shouldSkip = false;
            
            foreach ($skipPaths as $skip) {
                if (str_starts_with($path, $skip)) {
                    $shouldSkip = true;
                    break;
                }
            }
            
            if (!$shouldSkip && $request->method() === 'GET') {
                LoggingService::logView(
                    'Page',
                    0,
                    "Accessed {$path}",
                );
            }
        }

        return $response;
    }
}
