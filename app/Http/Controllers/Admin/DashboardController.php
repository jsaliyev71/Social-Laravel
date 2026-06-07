<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() {

        return view('admin.dashboard.index', [
            'usersCount' => User::count(),
            'communitiesCount' => Community::count(),
            'categoriesCount' => Category::count(),
            'postsCount' => Post::count(),
            'commentsCount' => Comment::count()
        ]);
    }
}
