<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostReaction;
use App\Traits\ReturnResult;
use Illuminate\Http\Request;

class PostReactionController extends Controller
{
    use ReturnResult;

    public function react(Request $request, int $post_id) {

        if(auth()->user()->is_banned) {
            return $this->returnJsonResult('error', 'Banned user.', 403);
        }

        $type = $request->input('reaction_type');

        $currentReaction = null;

        $post = Post::where('id', $post_id)->firstOrFail();

        if ($post->post_status !== 'published') {
            return $this->returnJsonResult(
                'error',
                'Post is not published.',
                422
            );
        }

        if (!in_array($type, ['like', 'dislike'])) {
            return $this->returnJsonResult(
                'error',
                'Invalid reaction type.',
                422
            );
        }

        $reaction = PostReaction::where('post_id', $post->id)
            ->where('user_id', auth()->id())
            ->first();


        if ($type === 'like') {

            if ($reaction && $reaction->reaction_type === 'like') {

                $reaction->delete();

                $currentReaction = null;
            }

            else {

                PostReaction::updateOrCreate(
                    [
                        'post_id' => $post->id,
                        'user_id' => auth()->id(),
                    ],
                    [
                        'reaction_type' => 'like'
                    ]
                );

                $currentReaction = 'like';
            }
        }

        if ($type === 'dislike') {

            if ($reaction && $reaction->reaction_type === 'dislike') {

                $reaction->delete();

                $currentReaction = null;
            }

            else {

                PostReaction::updateOrCreate(
                    [
                        'post_id' => $post->id,
                        'user_id' => auth()->id(),
                    ],
                    [
                        'reaction_type' => 'dislike'
                    ]
                );

                $currentReaction = 'dislike';
            }
        }

        $likesCount = PostReaction::where('post_id', $post->id)
            ->where('reaction_type', 'like')
            ->count();

        $dislikesCount = PostReaction::where('post_id', $post->id)
            ->where('reaction_type', 'dislike')
            ->count();

        return $this->returnJsonResult(
            'success',
            'Reaction updated.',
            200,
            [
                'current_reaction' => $currentReaction,
                'likes_count' => $likesCount,
                'dislikes_count' => $dislikesCount,
            ]
        );
    }
}