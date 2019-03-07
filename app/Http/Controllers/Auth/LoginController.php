<?php

namespace App\Http\Controllers\Auth;

use Alert;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;

class LoginController extends Controller {
	/*
		    |--------------------------------------------------------------------------
		    | Login Controller
		    |--------------------------------------------------------------------------
		    |
		    | This controller handles authenticating users for the application and
		    | redirecting them to your home screen. The controller uses a trait
		    | to conveniently provide its functionality to your applications.
		    |
	*/

	use AuthenticatesUsers {
		attemptLogin as attemptLoginAtAuthenticatesUsers;
	}

	/**
	 * Show the application's login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	function showLoginForm() {
		return view('adminlte::auth.login');
	}

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	function __construct() {
		$this->middleware('guest', ['except' => 'logout']);
	}

	/**
	 * Returns field name to use at login.
	 *
	 * @return string
	 */
	function username() {
		return config('auth.providers.users.field', 'email');
	}

	protected function authenticated(Request $request, $user) {
		if ($user->active == 0) {

			$this->guard()->logout();
			Alert::warning('Warning!', 'User account is locked.');
			$errors[] = 'User account is locked.';
			return redirect()->back()->withErrors(['errors', $errors]);
		}
	}

	/**
	 * Attempt to log the user into the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return bool
	 */
	function attemptLogin(Request $request) {
		if ($this->username() === 'email') {
			return $this->attemptLoginAtAuthenticatesUsers($request);
		} else {
			return $this->attempLoginUsingUsernameAsAnEmail($request);
		}

	}
	/**
	 * Attempt to log the user into application using username as an email.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return bool
	 */
	function attempLoginUsingUsernameAsAnEmail(Request $request) {
		return $this->guard()->attempt(
			['username' => $request->input('username'), 'password' => $request->input('password')],
			$request->has('remember'));
	}

	/**
	 * Redirect the user to the Google authentication page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function redirectToProvider() {
		return Socialite::driver('google')->redirect();
	}
	/**
	 * Obtain the user information from Google.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function handleProviderCallback() {
		try {
			$user = Socialite::driver('google')->user();
		} catch (\Exception $e) {
			return redirect('/login');
		}
		// check if they're an existing user
		$existingUser = User::where('google_ID', $user->id)->first();
		if ($existingUser) {
			// log them in
			auth()->login($existingUser, true);
		}
		return redirect()->to('/home');
	}

}
