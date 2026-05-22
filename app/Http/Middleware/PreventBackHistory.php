<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PreventBackHistory
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Or skip for certain route names
        if ($request->routeIs('admin.logs.export') || $request->is('admin/reports/lead?export=csv') || $request->routeIs('admin.leads.download-pdf')) {
            return $response;
        }

        // Skip adding headers for StreamedResponse (used by Maatwebsite/Excel)
        if ($response instanceof StreamedResponse) {
            return $response;
        }
        
        return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
    }
}
