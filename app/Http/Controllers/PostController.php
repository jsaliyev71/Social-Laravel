<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunitySection;
use App\Models\Post;
use App\Services\CommentService;
use App\Services\CommunityService;
use App\Services\PostService;
use App\Traits\ReturnResult;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ReturnResult;

    public function __construct(
        private PostService $postService,
        private CommentService $commentService,
        private CommunityService $communityService
    ) {}

    public function index() {
        $posts = $this->postService->index();

        return view('pages.post.index', compact('posts'));
    }

    public function create() {

        if(auth()->user()->is_banned) {
            return back()->with($this->errorMessage('Banned User.'));
        }

        $communityIds = auth()->user()->follows
            ->where('status', 'active')
            ->pluck('community_id');

        $communities = Community::where('owner_user_id', auth()->id())->where('status', 'active')
            ->orWhereIn('id', $communityIds)
            ->select('id', 'slug', 'name', 'owner_user_id', 'profile_pic')
            ->get();

        return view('pages.post.create', compact('communities'));
    }

    public function store(PostStoreRequest $request) {

        if(auth()->user()->is_banned) {
            return back()->with($this->errorMessage('Banned User.'));
        }

        $data = $request->validated();

        $data['comments_enabled'] = $request->boolean('comments_enabled');
        $data['is_sensitive'] = $request->boolean('is_sensitive');

        $media = $request->file('media') ?? [];

        $post = $this->postService->store(auth()->user(), $data, $media);

        return redirect()->route('posts.show', ['post_id' => $post->id]);
    }
    
    public function show(Request $request) {
        $post_id = $request->route('post_id');
        $slug = $request->route('slug') ?? null;
        
        $post = $this->postService->show($post_id);

        $community = null;

        if($request->route('slug')) {
            $community = $this->communityService->show($request->route('slug'), auth()->id());
        }

        $comments = $this->commentService->index($post->id);

        return view('pages.post.show', compact('post', 'comments', 'community'));
    }

    public function edit(int $post_id) {

        if(auth()->user()->is_banned) {
            return back()->with($this->errorMessage('Banned User.'));
        }

        $post = Post::where('id', $post_id)->with('media')->firstOrFail();

        if($post->user_id !== auth()->id()) {
            abort(403);
        }

        if($post->post_status === 'deleted') {
            abort(403, 'Cannot edit deleted post.');
        }

        $sections = [];

        if($post->community_id) {
            $sections = CommunitySection::where('community_id', $post->community_id)->get();
        }

        return view('pages.post.edit', compact('post', 'sections'));
    }

    public function update(PostUpdateRequest $request, int $post_id) {

        if(auth()->user()->is_banned) {
            return back()->with($this->errorMessage('Banned User.'));
        }

        $post = Post::where('id', $post_id)->firstOrFail();

        if($post->user_id !== auth()->id()) {
            abort(403);
        }

        if($post->post_status === 'deleted') {
            abort(403, 'Cannot edit deleted post.');
        }

        $data = $request->validated();

        $data['comments_enabled'] = $request->boolean('comments_enabled');
        $data['is_sensitive'] = $request->boolean('is_sensitive');

        $media = $request->file('media') ?? [];

        $post = $this->postService->update(auth()->user(), $post, $data, $media);

        return redirect()->route('posts.show', ['post_id' => $post->id]);
    }

    public function delete(int $post_id, Request $request) {

        if(auth()->user()->is_banned) {
            return back()->with($this->errorMessage('Banned User.'));
        }

        $post = $this->postService->softDelete($post_id, auth()->id());

        return response()->json([
            'message' => 'Deleted.',
            'status' => 'success'
        ]);
    }
}
