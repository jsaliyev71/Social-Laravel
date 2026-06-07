<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReaction;
use App\Traits\ReturnResult;
use Illuminate\Http\Request;

class CommentReactionController extends Controller
{
    use ReturnResult;

    public function react(Request $request, int $comment_id) {

        if(auth()->user()->is_banned) {
            return $this->returnJsonResult('error', 'Banned user.', 403);
        }

        $type = $request->input('reaction_type');

        $currentReaction = null;

        $comment = Comment::where('id', $comment_id)->firstOrFail();

        if ($comment->comment_status !== 'published') {
            return $this->returnJsonResult(
                'error',
                'Comment is not published.',
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

        $reaction = CommentReaction::where('comment_id', $comment->id)
            ->where('user_id', auth()->id())
            ->first();


        if ($type === 'like') {

            if ($reaction && $reaction->reaction_type === 'like') {

                $reaction->delete();

                $currentReaction = null;
            } else {

                CommentReaction::updateOrCreate(
                    [
                        'comment_id' => $comment->id,
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

                CommentReaction::updateOrCreate(
                    [
                        'comment_id' => $comment->id,
                        'user_id' => auth()->id(),
                    ],
                    [
                        'reaction_type' => 'dislike'
                    ]
                );

                $currentReaction = 'dislike';
            }
        }

        $likesCount = CommentReaction::where('comment_id', $comment->id)
            ->where('reaction_type', 'like')
            ->count();

        $dislikesCount = CommentReaction::where('comment_id', $comment->id)
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
