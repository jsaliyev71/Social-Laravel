<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() {
        return view('auth.login');
    }



    public function login(LoginRequest $request) {

        if(!Auth::attempt($request->only('username', 'password'))) {
            return back()->withErrors([
                'auth' => 'Username or password is incorrect'
            ])->withInput();
        }

        $request->session()->regenerate();

        return redirect()->route('home.index')->with([
            'message' => 'Login successfull!',
            'status' => 'success'
        ]);
    }


    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login.index');
    }
}
