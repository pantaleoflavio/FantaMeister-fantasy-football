<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $defaultLocale = config('app.locale');
        $locale = $request->session()->get('locale', $defaultLocale);

        app()->setLocale(in_array($locale, config('admin.supported_locales', []), true) ? $locale : $defaultLocale);

        return $next($request);
    }
}
