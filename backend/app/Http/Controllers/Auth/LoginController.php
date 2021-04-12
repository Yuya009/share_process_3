<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //ゲストユーザーログインID
     private const GUEST_USER_ID = 8;

    //ゲストログイン処理
    public function guest_login()
    {
      // id=8のユーザーがあればログイン
      if (Auth::loginUsingId(self::GUEST_USER_ID)) {
        return redirect('/top');
      }

      return redirect('/top');
    }

    //ログアウト
    protected function loggedOut() {
        Auth::logout();
        return redirect('/top');
    }
}
