<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Get the 'Accept-Language' header from the request
        // $locale = $request->getPreferredLanguage(['en', 'ar']); // Default to 'en' and 'ar'

        // // Set the locale for the application
        // App::setLocale($locale);

        $lang = $request->route('lang', session('lang', 'en')); // Default to 'en' if not set

        // Set the application locale
        App::setLocale($lang);

        // Store language in session for subsequent requests
        session(['lang' => $lang]);

        return $next($request);
    }
}
