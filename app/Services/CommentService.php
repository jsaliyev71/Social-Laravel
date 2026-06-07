<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\CommentReaction;
use Illuminate\Database\Eloquent\Collection;

class CommentService {

    public function baseQuery() {
        return Comment::query()
            ->select('comments.*')
            ->withCount([
                'reactions as likes_count' => function ($q) {$q->where('reaction_type', 'like');},
                'reactions as dislikes_count' => function ($q) {$q->where('reaction_type', 'dislike');}
            ])->addSelect([
                'my_reaction' => CommentReaction::select('reaction_type')
                    ->whereColumn('comment_id', 'comments.id')
                    ->where('user_id', auth()->id())
                    ->limit(1)
            ]);
    }

    private function buildTree($comments, $parentId = null) {

        $branch = new Collection();

        foreach ($comments as $comment) {
            if ($comment->parent_comment_id === $parentId) {
                $comment->setRelation(
                    'replies',
                    $this->buildTree($comments, $comment->id)
                );

                $branch->push($comment);
            }
        }

        return $branch;
    }

    private function findInTree($comments, $id) {
        foreach ($comments as $comment) {

            if ($comment->id == $id) {
                return $comment;
            }

            if ($comment->replies && $comment->replies->count() > 0) {
                $found = $this->findInTree($comment->replies, $id);

                if ($found) {
                    return $found;
                }
            }
        }

        return null;
    }

    public function index(int $post_id) {
        $comments = $this->baseQuery()->where('post_id', $post_id)
            ->with('user')
            ->orderBy('created_at')->get()->map(function ($comment) {

            if ($comment->comment_status !== 'published') {
                $comment->content = null;
            }

            return $comment;
        });

        return $this->buildTree($comments);
    }

    public function indexUser(int $user_id) {
        $comments = $this->baseQuery()->where('user_id', $user_id)
                    ->where('comment_status', 'published')
                    ->orderByDesc('created_at')->get();

        return $comments;
    }

    public function show(int $comment_id, int $post_id) {
        $comments = $this->index($post_id);

        $target = $this->findInTree($comments, $comment_id);

        return collect([$target]);
    }
}