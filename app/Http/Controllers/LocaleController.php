<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LocaleController extends Controller
{
    public function switch($locale)
    {
        $previousRequest = $this->getPreviousRequest();

        // Get Query Parameters if applicable
        $queryBag = $previousRequest->query();

        // Store the segments of the last request as an array
        $segments = $previousRequest->segments();

        // Check if the first segment matches a language code
        if (array_key_exists($locale, config('app.locales'))) {
            // Replace the first segment by the new language code
            $segments[0] = $locale;

            $newRoute = $this->translateRouteSegments($segments, $locale);

            // Redirect to the required URL
            $redirectUrl = implode('/', $newRoute->toArray());
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

    private function translateRouteSegments($segments, string $locale)
    {
        $translatedSegments = collect();

        foreach ($segments as $segment) {
            if ($key = array_search($segment, Lang::get('routes'))) {
                $translatedSegments->push(trans('routes.' . $key, [], $locale));
            } else {
                $translatedSegments->push($segment);
            }
        }

        return $translatedSegments;
    }
}
