<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\CommunityMember;
use App\Models\Post;
use App\Services\CommentService;
use App\Services\PostService;
use App\Traits\ReturnResult;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use ReturnResult;

    public function __construct(
        private PostService $postService,
        private CommentService $commentService
    ) {}

    public function store(CommentRequest $request, int $post_id) {

        if(auth()->user()->is_banned) {
            return $this->returnJsonResult('error', 'Banned user.', 403);
        }

        $post = Post::where('id', $post_id)->firstOrFail();

        if($post->post_status !== 'published' || !$post->comments_enabled) {
            return $this->returnJsonResult('error', 'Cannot comment.', 403);
        }

        $community = $post->community;

        if($community && $community->commenting_mode === 'members') {
            $isMember = CommunityMember::query()
            ->where('community_id', $community->id)
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->exists();

            $isOwner = $community->owner_user_id === auth()->id();

            if (!$isOwner && !$isMember) {
                return $this->returnJsonResult('error', 'Only members can comment.', 403);
            }
        }

        $data = $request->validated();

        $data['user_id'] = auth()->id();
        $data['post_id'] = $post->id;
        $data['comment_status'] = 'published';
        $data['parent_comment_id'] = $request->parent_comment_id ?? null;

        if($data['parent_comment_id']) {
            $parent = Comment::where('id', $request->parent_comment_id)->firstOrFail();
            if($parent->comment_status !== 'published') {
                return $this->returnJsonResult('error','Something went wrong.', 500);
            }
        }

        $store = Comment::create($data);

        $store->load('user');

        if(!$store) {
            return $this->returnJsonResult('error', 'Something went wrong.', 500);
        }

        return $this->returnJsonResult('success', 'Created.', 200, [
            'comment' => $store,
            'permissions' => [
                'op' => $store ->user_id === $post->user_id,
                'delete_user' => auth()->id() === $store->user_id,

                'delete_admin' =>
                    $post->community &&
                    $post->community->owner_user_id === auth()->id(),
            ]
        ]);
    }

    public function show(Request $request) {
        
        $post = $this->postService->show($request->route('post_id'));
        $comments = $this->commentService->show($request->route('comment_id'), $post->id);

        $goToPost = true;

        return view('pages.post.show', compact('comments', 'post', 'goToPost'));
    }

    public function update(Request $request) {

        if(auth()->user()->is_banned) {
            return $this->returnJsonResult('error', 'Banned user.', 403);
        }

        $comment = Comment::where('id', $request->route('comment_id'))->firstOrFail();

        if($comment->user_id === auth()->id()) {
            $content = $request->input('content');

            $comment->content = $content;
            $comment->save();

            return $this->returnJsonResult('success', 'Success', 200, [
                'comment' => $comment
            ]);
        }

        return $this->returnJsonResult('error', 'Unauthorized.', 403);
    }

    public function delete(Request $request) {

        if(auth()->user()->is_banned) {
            return $this->returnJsonResult('error', 'Banned user.', 403);
        }

        $delete_type = $request->input('delete_type');

        $comment = Comment::where('id', $request->route('comment_id'))
            ->with('post.community')->firstOrFail();

        if($delete_type === 'user' && $comment->user_id === auth()->id()) {
            $comment->comment_status = 'deleted_user';
            $comment->save();

            return $this->returnJsonResult('success', 'Success', 200, [
                'delete_type' => $delete_type,
            ]);
        }

        if($delete_type === 'admin' && $comment->post->community &&
            $comment->post->community->owner_user_id === auth()->id()) {
            $comment->comment_status = 'deleted_admin';
            $comment->save();

            return $this->returnJsonResult('success', 'Success', 200, [
                'delete_type' => $delete_type
            ]);
        }

        return $this->returnJsonResult('error', 'Unauthorized.', 403);
    }
}
