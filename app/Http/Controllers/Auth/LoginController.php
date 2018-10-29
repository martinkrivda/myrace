<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
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
    function showLoginForm()
    {
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
    function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Returns field name to use at login.
     *
     * @return string
     */
    function username()
    {
        return config('auth.providers.users.field', 'email');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    function attemptLogin(Request $request)
    {
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
    function attempLoginUsingUsernameAsAnEmail(Request $request)
    {
        return $this->guard()->attempt(
            ['username' => $request->input('username'), 'password' => $request->input('password')],
            $request->has('remember'));
    }
}
