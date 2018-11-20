<?php

namespace App\Providers;

use App\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $locale = request()->segment(1);

        Route::bind('post', function ($slug) use ($locale) {
            $post = Post::where('slug->' . $locale, $slug)->first();
            if ($post) {
                return $post;
            } else {
                foreach (config('app.locales') as $locale => $label) {
                    $postInLocale = Post::where('slug->' . $locale, $slug)->first();
                    if ($postInLocale) {
                        return redirect()->route('post.show', $postInLocale->slug)->send();
                    }
                }
                abort(404);
            }
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $locale = request()->segment(1);

        Route::middleware(['web', 'localized'])
        ->prefix($locale)
        ->namespace($this->namespace)
        ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
