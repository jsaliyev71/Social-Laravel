<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        private PostService $postService
    ) {}

    public function index() {
        $posts = $this->postService->index();

        return view('pages.post.index', [
            'title' => 'HomePage',
            'posts' => $posts
        ]);
    }
}
