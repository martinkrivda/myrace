<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Cache;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Cache::forever('settings', \App\Setting::all());
		if (env('APP_ENV') === 'remote') {
			URL::forceScheme('https');
		}
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		if ($this->app->environment('local', 'testing')) {
			$this->app->register(DuskServiceProvider::class);
		}
	}
}
