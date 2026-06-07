<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create() {
        return view('auth.register');
    }

    public function store(RegisterRequest $request) {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        if(!$user) {
            return back()->with([
                'message' => 'Could not create.',
                'status' => 'error'
            ]);
        }

        $user->userSettings()->create();

        // Auth::login($user);

        return redirect()->route('auth.login.index')->with([
            'message' => 'Account created!',
            'status' => 'success'
        ]);

    }
}
