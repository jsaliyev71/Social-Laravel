<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $people = User::where('is_banned', false)->get();

        return view('pages.people.index', compact('people'));
    }
}
