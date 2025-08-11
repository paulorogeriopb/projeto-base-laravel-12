<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', config('app.locale'));

        // Garante que o locale existe na pasta lang
        $availableLocales = ['pt_BR', 'en', 'es'];

        if (in_array($locale, $availableLocales)) {
            app()->setLocale($locale);
        } else {
            app()->setLocale(config('app.locale'));
        }

        return $next($request);
    }
}