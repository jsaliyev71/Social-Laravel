<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ReturnResult;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ReturnResult;

    public function index(){
        $users = User::whereNot('id', auth()->id())->latest()->get();

        return view('admin.user.index', compact('users'));
    }

    public function show(User $user, int $user_id) {
        $user = User::where('id', $user_id)->firstOrFail();

        if($user->id === auth()->id()) {
            abort(403);
        }

        return view('admin.user.show', compact('user'));
    }

    public function ban(User $user, int $user_id) {
        $user = User::where('id', $user_id)->firstOrFail();

        if($user->id === auth()->id()) {
            abort(403);
        }

        $user->update(['is_banned' => true]);

        return back()->with('success', 'User banned.');
    }

    public function unban(User $user, int $user_id) {
        $user = User::where('id', $user_id)->firstOrFail();

        if($user->id === auth()->id()) {
            abort(403);
        }

        $user->update(['is_banned' => false]);

        return back()->with('success', 'User unbanned.');
    }

    public function delete(User $user, int $user_id) {
        $user = User::where('id', $user_id)->firstOrFail();

        if($user->id === auth()->id()) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'User deleted.');
    }
}
