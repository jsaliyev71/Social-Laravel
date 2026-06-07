<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Post;
use App\Services\PostService;
use App\Traits\ReturnResult;
use Illuminate\Http\Request;

class CommunityManagePostController extends Controller
{
    use ReturnResult;

    public function __construct(
        private PostService $postService
    ) {}

    public function index(Request $request, string $slug) {

        $community = Community::where('slug', $slug)->firstOrFail();

        if($community->owner_user_id !== auth()->id()) {
            abort(403);
        }

        $tab = $request->input('tab', 'pending');

        $posts = $this->postService->managePosts($community->id, $tab);

        return view('pages.community.manage.posts', compact('posts', 'community'));
    }

    public function accept(string $slug, int $post_id) {
        $community = Community::where('slug', $slug)->firstOrFail();

        if($community->owner_user_id !== auth()->id()) {
            return $this->returnJsonResult('error', 'Unauthorized.', 403);
        }

        $post = Post::where('id', $post_id)->firstOrFail();

        if($post->community_id !== $community->id) {
            return $this->returnJsonResult('error', 'Post not found.', 422);
        }

        if($post->post_status !== 'pending') {
            return $this->returnJsonResult('error', 'Post is not requested.', 422);
        }

        $post->post_status = 'published';
        $post->published_at = now();
        $post->save();

        return $this->returnJsonResult('success', 'Accepted.');
    }

    public function reject(string $slug, int $post_id) {
        $community = Community::where('slug', $slug)->firstOrFail();

        if($community->owner_user_id !== auth()->id()) {
            return $this->returnJsonResult('error', 'Unauthorized.', 403);
        }

        $post = Post::where('id', $post_id)->firstOrFail();

        if($post->community_id !== $community->id) {
            return $this->returnJsonResult('error', 'Post not found.', 422);
        }

        if($post->post_status !== 'pending') {
            return $this->returnJsonResult('error', 'Post is not requested.', 422);
        }

        $post->post_status = 'rejected';
        $post->save();

        return $this->returnJsonResult('success', 'Rejected.');
    }

    public function pin(string $slug, int $post_id) {
        $community = Community::where('slug', $slug)->firstOrFail();

        if($community->owner_user_id !== auth()->id()) {
            return $this->returnJsonResult('error', 'Unauthorized.', 403);
        }

        $post = Post::where('id', $post_id)->firstOrFail();

        if($post->community_id !== $community->id) {
            return $this->returnJsonResult('error', 'Post not found.', 422);
        }

        if($post->post_status !== 'published') {
            return $this->returnJsonResult('error', 'Post is not active.', 422);
        }

        if($post->is_pinned) {
            return $this->returnJsonResult('error', 'Post is pinned.', 422);
        }

        $post->is_pinned = true;
        $post->save();

        return $this->returnJsonResult('success', 'Pinned.', 200, [
            'is_pinned' => true
        ]);
    }
    
    public function unpin(string $slug, int $post_id) {
        $community = Community::where('slug', $slug)->firstOrFail();

        if($community->owner_user_id !== auth()->id()) {
            return $this->returnJsonResult('error', 'Unauthorized.', 403);
        }

        $post = Post::where('id', $post_id)->firstOrFail();

        if($post->community_id !== $community->id) {
            return $this->returnJsonResult('error', 'Post not found.', 422);
        }

        if($post->is_pinned === false) {
            return $this->returnJsonResult('error', 'Post is not pinned.', 422);
        }

        $post->is_pinned = false;
        $post->save();

        return $this->returnJsonResult('success', 'Unpinned.', 200, [
            'is_pinned' => false
        ]);
    }

    public function remove(string $slug, int $post_id) {
        $community = Community::where('slug', $slug)->firstOrFail();

        if($community->owner_user_id !== auth()->id()) {
            return $this->returnJsonResult('error', 'Unauthorized.', 403);
        }

        $post = Post::where('id', $post_id)->firstOrFail();

        if($post->community_id !== $community->id) {
            return $this->returnJsonResult('error', 'Post not found.', 422);
        }

        if($post->post_status !== 'published') {
            return $this->returnJsonResult('error', 'Post is not active.', 422);
        }

        if($post->is_pinned) {
            $post->is_pinned = false;
        }

        $post->post_status = 'deleted';
        $post->save();

        return $this->returnJsonResult('success', 'Deleted.', 200);
    }
}
