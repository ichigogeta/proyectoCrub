<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Socialite;
use Carbon\Carbon;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Handle Social login request
     *
     * @return response
     */
    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();

    }

    /**
     * Obtain the user information from Social Logged in.
     * @param $social
     * @return Response
     */
    public function handleProviderCallback($social)
    {
        if (!request()->get('code'))
            return null; //El usuario ha rechazado el login

        $userSocial = Socialite::driver($social)->user();
        $user = User::where('email', $userSocial->email)->first();

        if ($user) {
            if ($user->provider == $social) {
                return $this->authAndRedirect($user);
            }

        } else {
            $user = new User();
            $user->fill([
                'name' => $userSocial->name,
                'email' => $userSocial->email,
                'avatar' => $userSocial->avatar,
            ]);
            $user->provider = $social;
            $user->email_verified_at = Carbon::now()->toDateTimeString();
            $user->save();
            return $this->authAndRedirect($user);
        }

    }

    public function authAndRedirect($user)
    {
        Auth::login($user);
        return redirect()->action('IndexController@index');
    }

}
