<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionRead
{
    /**
    * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    public function handle(Request $request, Closure $next): Response
    {

        $segment = $request->segment(1);
        $perm = 'r_' . strtolower($segment);

        if (! $request->user() || ! $request->user()->can($perm)) {
            abort(403);
        }
        return $next($request);
    }
}
