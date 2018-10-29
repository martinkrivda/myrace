<?php

namespace App\Providers;

use DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // You can use a class for composer
        // you will need NavComposer@compose method
        // which will be called everythime partials.nav is requested
        View::composer(
            'adminlte::layouts.partials.sidebar', 'App\Http\ViewComposers\NavigationComposer'
        );

        // You can use Closure based composers
        // which will be used to resolve any data
        // in this case we will pass menu items from database
        View::composer('adminlte::layouts.partials.sidebar', function ($view) {
            $navigation = DB::table('raceedition')
                ->select('edition_ID', 'editionname', 'race_abbr', 'edition_nr')
                ->leftJoin('race', 'raceedition.race_ID', '=', 'race.race_ID')
                ->get();
            $view->with('menu', $navigation);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
