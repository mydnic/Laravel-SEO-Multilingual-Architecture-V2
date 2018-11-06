<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LocaleController extends Controller
{
    public function switch(Request $request, $locale)
    {
        $previousRequest = $this->getPreviousRequest();

        // Get Query Parameters if applicable
        $queryBag = $previousRequest->query();

        // Store the segments of the last request as an array
        $segments = $previousRequest->segments();

        // Check if the first segment matches a language code
        if (array_key_exists($locale, config('app.locales'))) {
            $this->handleTranslatedRouteSegments($previousRequest, $queryBag, $locale);

            // Replace the first segment by the new language code
            $segments[0] = $locale;
            // Redirect to the required URL
            $redirectUrl = implode('/', $segments);
            $redirectUrl .= count($queryBag) ? '?' . http_build_query($queryBag) : '';
            return redirect()->to($redirectUrl);
        }

        return back();
    }

    private function getPreviousRequest()
    {
        // We Transform the URL on which the user was into a Request instance
        return request()->create(url()->previous());
    }

    private function handleTranslatedRouteSegments(Request $request, array $queryBag, string $locale)
    {
        // Gat the route name from the previous page
        $routeName = app('router')->getRoutes()->match($request)->getName();

        $segments = collect($request->segments())->map(function ($segment) use ($locale) {
            return trans($segment, [], $locale);
        });
        dd($segments);
        foreach ($segments as $segment) {
            if (Lang::has('routes.' . $segment, $locale)) {
                dd($segment);
                $translatedSegment = trans('routes.' . $routeName, [], $locale);
            }
        }

        if ($routeName) {
            // The previous URL has a route name
            $redirectUrl = $locale . '/' . trans('routes.' . $routeName, [], $locale);
            $redirectUrl .= count($queryBag) ? '?' . http_build_query($queryBag) : '';
        }

        if ($routeName && Lang::has('routes.' . $routeName, $locale)) {
            // Translate the route name to get the correct URI in the required language, and redirect to that URL.
            $redirectUrl = $locale . '/' . trans('routes.' . $routeName, [], $locale);
            $redirectUrl .= count($queryBag) ? '?' . http_build_query($queryBag) : '';

            return $redirectUrl;
        }

        return false;
    }
}
