<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Post;
use App\Services\CommunityService;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function __construct(
        private CommunityService $communityService
    ) {}

    public function index(Request $request) {
        $query = $request->input('search');
        $type = $request->input('type', 'all');

        $posts = collect();
        $communities = collect();

        if (!$query) {
            return view('pages.search.index', compact('posts', 'communities', 'query', 'type'));
        }

        if ($type === 'all' || $type === 'posts') {
            $posts = Post::where('post_status', 'published')
                ->where('title', 'like', "%{$query}%")
                ->with('user')
                ->get();
        }

        if ($type === 'all' || $type === 'communities') {
            $communities = $this->communityService->baseQuery()->where('status', 'active')
                ->where('visibility', 'public')
                    ->where(function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%")
                        ->orWhere('slug', 'like', "%{$query}%");
                    })
                ->get();
        }

        return view('pages.search.index', compact('posts', 'communities', 'query', 'type'));
    }
}
