<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Validator;

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
    protected $redirectTo = '/dashboard/index';

    protected $connection = 'mysql'; 


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /*protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required|active_user', 'password' => 'required',
        ], [
            $this->loginUsername() . '.active_user' => 'Invalid user login',
        ]);
    }*/

    protected function authenticated(Request $request, $user)
    {    
       
        if($user->role == 'admin') {

            return redirect('/dashboard/index');
        } else {

            return redirect('/home');
        }
    }


    public function logout(Request $request)
    {
        if(auth()->user()->role == 'admin')
            $redirect = 'dashboard';
        else 
            $redirect = '';

        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/'.$redirect);
    }
}
