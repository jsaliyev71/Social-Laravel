<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CommentService;
use App\Services\CommunityService;
use App\Services\PostService;
use App\Traits\ReturnResult;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        private PostService $postService,
        private CommunityService $communityService,
        private CommentService $commentService
    ) {}

    use ReturnResult;

    public function show(Request $request) {
        $user = User::where('username', $request['username'])->firstOrFail();

        if($user->id !== auth()->id() && $user->userSettings->profile_visibility !== 'public') {
            return view('pages.profile.index', [
                'user' => $user,
                'user_status' => 'private'
            ]);
        }

        $posts = $this->postService->indexUser($user->id);

        return view('pages.profile.index', compact('user', 'posts'));
    }

    public function comments(Request $request) {
        $user = User::where('username', $request['username'])->firstOrFail();

        if($user->id !== auth()->id() && $user->userSettings->profile_visibility !== 'public') {
            return view('pages.profile.index', [
                'user' => $user,
                'user_status' => 'private'
            ]);
        }

        $comments = $this->commentService->indexUser($user->id);

        return view('pages.profile.comments', [
            'user' => $user,
            'comments' => $comments
        ]);
    }

    public function communities(Request $request) {
        $user = User::where('username', $request['username'])->firstOrFail();

        if($user->id !== auth()->id() && $user->userSettings->profile_visibility !== 'public') {
            return view('pages.profile.index', [
                'user' => $user,
                'user_status' => 'private'
            ]);
        }

        $communities = $this->communityService->userCommunity($user->id);

        return view('pages.profile.communities', [
            'user' => $user,
            'communities' => $communities
        ]);
    }
    
    public function about(Request $request) {
        $user = User::where('username', $request['username'])->firstOrFail();

        if($user->id !== auth()->id() && $user->userSettings->profile_visibility !== 'public') {
            return view('pages.profile.index', [
                'user' => $user,
                'user_status' => 'private'
            ]);
        }

        return view('pages.profile.about', [
            'user' => $user
        ]);
    }

    public function saved(Request $request) {
        $user = User::where('username', $request['username'])->firstOrFail();

        if($user->id !== auth()->user()->id) {
            return back()->with($this->errorMessage('Anauthorized to access.'));
        }

        return view('pages.profile.saved', [
            'user' => $user
        ]);
    }

    public function hidden(Request $request) {
        $user = User::where('username', $request['username'])->firstOrFail();

        if($user->id !== auth()->user()->id) {
            return back()->with($this->errorMessage('Anauthorized to access.'));
        }

        return view('pages.profile.hidden', [
            'user' => $user
        ]);
    }

    public function history(Request $request) {
        $user = User::where('username', $request['username'])->firstOrFail();

        if($user->id !== auth()->user()->id) {
            return back()->with($this->errorMessage('Anauthorized to access.'));
        }

        return view('pages.profile.history', [
            'user' => $user
        ]);
    }

    public function reacted(Request $request) {
        $user = User::where('username', $request['username'])->firstOrFail();

        if($user->id !== auth()->user()->id) {
            return back()->with($this->errorMessage('Anauthorized to access.'));
        }

        return view('pages.profile.reacted', [
            'user' => $user
        ]);
    }

}
