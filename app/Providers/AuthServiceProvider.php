<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider {
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		'App\Model' => 'App\Policies\ModelPolicy',
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->registerPolicies();

		Gate::resource('clubs', 'App\Policies\ClubPolicy');
		Gate::resource('registrations', 'App\Policies\RegistrationPolicy');
		Gate::resource('starttime', 'App\Policies\StartTimePolicy');
		Gate::define('starttime.generate', 'App\Policies\StartTimePolicy@generate');
		Gate::define('registrations.audit', 'App\Policies\RegistrationPolicy@audit');
		//Result lists
		Gate::resource('results', 'App\Policies\ResultListPolicy');

		Passport::routes();
	}
}
