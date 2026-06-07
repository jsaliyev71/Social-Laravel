<?php

namespace App\Services;

use App\Models\Community;
use App\Models\Media;
use App\Models\Post;
use App\Models\PostReaction;
use App\Traits\HandleUploads;
use App\Traits\ReturnResult;
use Arr;

class PostService {

    use HandleUploads, ReturnResult;

    public function baseQuery() {
        return Post::query()
            ->withCount([
                'comments as comments_count' => function ($q) {$q->where('comment_status', 'published');},
                'reactions as likes_count' => function ($q) {$q->where('reaction_type', 'like');},
                'reactions as dislikes_count' => function ($q) {$q->where('reaction_type', 'dislike');}
            ])->addSelect([
                'my_reaction' => PostReaction::select('reaction_type')
                    ->whereColumn('post_id', 'posts.id')
                    ->where('user_id', auth()->id())
                    ->limit(1)
            ]);
    }

    public function managePosts(int $communityId, string $filter) {

        $posts = $this->baseQuery()->where('community_id', $communityId)

            ->when($filter === 'pending', function ($query) {
                $query->where('post_status', 'pending');
            })

            ->when($filter === 'pinned', function ($query) {
                $query->where('is_pinned', true);
            })

            ->when($filter === 'removed', function ($query) {
                $query->where('post_status', 'deleted');
            })
            ->with('user')
            ->latest()
            ->get();

        return $posts;
    }

    public function indexUser(int $userId) {
        $query = $this->baseQuery()
            ->where('user_id', $userId);

        $isOwner = auth()->id() === $userId;

        if (!$isOwner) {
            $query->where('post_status', 'published')
                ->where(function ($q) {
                    $q->whereNull('community_id')
                        ->orWhereHas('community', function ($q) {
                            $q->where('status', 'active')
                                ->where('visibility', 'public');
                        });
                })
                ->whereNotNull('published_at');
        }

        return $query
            ->orderByDesc('created_at')
            ->with('user', 'community', 'media')
            ->get();
    }

    public function index(?int $community_id = null) {
        $query = $this->baseQuery()->where('post_status', 'published')
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->with('user', 'community', 'media');
            
        if($community_id) {
            $query->where('community_id', $community_id);
        } else {
            $query->where(function($q) {
                $q->whereNull('community_id')
                    ->orWhereHas('community', function ($communityQuery) {
                        $communityQuery->where('status', 'active')
                            ->where('visibility', 'public');
                    });
            });
        }

        return $query->get();
    }

    public function store($user, array $data, array $media = []) {

        $community = null;

        if (!empty($data['community_id'])) {
            $community = Community::find($data['community_id']);
        }

        $data['post_status'] = 'published';
        $data['published_at'] = now();

        if ($community) {

            if($community->status !== 'active') {
                abort(403, 'Community not active.');
            }

            if ($community->owner_user_id !== $user->id) {

                $membership = $community->members()
                    ->where('user_id', $user->id)
                    ->first();

                if (!$membership || $membership->status !== 'active') {
                    abort(403, 'Not allowed to post here.');
                }

                if ($community->posting_mode === 'admins') {
                    abort(403, 'Only admins can post here.');
                }

                if ($community->posting_mode == 'request') {
                    $data['post_status'] = 'pending';
                    $data['published_at'] = null;
                }
            }
        }
        
        $data['user_id'] = $user->id;

        if ($data['post_type'] === 'text') {
            $data['content'] = $data['content'] ?? null;
        }

        $post = Post::create(Arr::except($data, ['media']));

        if ($data['post_type'] === 'image' && $media) {

            foreach ($media as $file) {
                if (!$file instanceof \Illuminate\Http\UploadedFile) {
                    continue;
                }

                $path = $this->uploadFile($file);
                
                Media::create([
                    'uploader_user_id' => $user->id,
                    'owner_type' => Post::class,
                    'owner_id' => $post->id,
                    'file_url' => $path,
                    'media_type' => str_starts_with($file->getMimeType(), 'image') ? 'image' : 'video',
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return $post;
    }

    public function show(int $post_id) {
        $post = $this->baseQuery()->with([
            'community.members',
            'user',
            'media'
        ])
        ->findOrFail($post_id);

        $isMember = $post->community ?
            $post->community->members()
                ->where('user_id', auth()->id())
                ->exists()
            : false;

        $isOwner = $post->user_id === auth()->id();

        $isPublished = $post->post_status === 'published';

        $isPublicCommunity =
            is_null($post->community_id) ||
            (
                $post->community &&
                $post->community->status === 'active' &&
                $post->community->visibility === 'public'
            );

        if (!(
            $isOwner ||
            ($isPublished && $isPublicCommunity) ||
            ($isPublished && $isMember)
        )) {
            abort(403);
        }

        return $post;
    }

    public function update($user, $post, array $data, array $media = []) {

        if ($post->post_type === 'text') {
            $data['content'] = $data['content'] ?? null;
        }

        $data['edited_at'] = now();

        $update = $post->update(Arr::except($data, ['media', 'deleted_media_ids']));
        
        if(!$update) {
            abort(500, 'Update failed.');
        }

        if ($post->post_type === 'image') {
            
            if(!empty($data['deleted_media_ids'])) {
                $mediaItems = Media::whereIn('id', $data['deleted_media_ids'])
                    ->where('owner_type', Post::class)
                    ->where('owner_id', $post->id)
                    ->get();

                foreach ($mediaItems as $media) {
                    $this->deleteFile($media->file_url);
                }

                Media::whereIn('id', $data['deleted_media_ids'])->delete();
            }

            if($media) {
                foreach ($media as $file) {
                    if (!$file instanceof \Illuminate\Http\UploadedFile) {
                        continue;
                    }

                    $path = $this->uploadFile($file);
                    
                    Media::create([
                        'uploader_user_id' => $user->id,
                        'owner_type' => Post::class,
                        'owner_id' => $post->id,
                        'file_url' => $path,
                        'media_type' => str_starts_with($file->getMimeType(), 'image') ? 'image' : 'video',
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                        'file_name' => $file->getClientOriginalName(),
                    ]);
                }
            }
        }

        return $post;
    }

    public function softDelete(int $post_id, int $user_id) {
            $post = Post::where('id', $post_id)->firstOrFail();

            if ($post->user_id !== $user_id) {
                abort(403);
            }

            $delete = $post->delete();

            if(!$delete) {
                return abort(500, 'Could not delete.');
            }

            return $post;
    }
}