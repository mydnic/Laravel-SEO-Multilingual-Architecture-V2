<?php

namespace App\Http\Middleware;

use Closure;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locales = config('app.locales');

        // Check if the first segment matches a language code
        if (!array_key_exists($request->segment(1), config('app.locales'))) {
            // Store segments in array
            $segments = $request->segments();

            // Set the default language code as the first segment
            $segments = array_prepend($segments, config('app.fallback_locale'));

            // Redirect to the correct url
            return redirect()->to(implode('/', $segments));
        }

        // The request already contains the language code
        return $next($request);
    }
}
