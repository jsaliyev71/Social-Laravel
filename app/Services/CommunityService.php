<?php

namespace App\Services;

use App\Models\{
    Category,
    Community
};
use App\Traits\{
    HandleUploads,
    ReturnResult,
};
use Str;

class CommunityService {
    
    use HandleUploads, ReturnResult;

    public function baseQuery() {
        return Community::query()
            ->with('myMembership')
            ->withCount([
                'members as members_count' => function ($query) {
                    $query->where('status', 'active');
                }
            ]);
    }

    public function index() {
        return $this->baseQuery()
            ->where('visibility', 'public')
            ->where('status', 'active')
            ->get();
    }

    public function userCommunity(int $userId) {
        return $this->baseQuery()
            ->where('owner_user_id', $userId)
            ->when(auth()->id() !== $userId, function ($query) {
                $query->where('visibility', 'public')
                    ->where('status', 'active');
            })->get();
    }

    public function categoryCommunity(int $category_id) {
        return $this->baseQuery()
            ->where('category_id', $category_id)
            ->where('visibility', 'public')
            ->where('status', 'active')
            ->get();
    }

    public function create() {
        return Category::orderBy('name', 'asc')->get();
    }

    public function store(array $data, int $userId, $profilePic = null, $bannerImg = null): array {

        $data['owner_user_id'] = $userId;
        
        $data['profile_pic'] = $this->uploadFile($profilePic);
        $data['banner_img'] = $this->uploadFile($bannerImg);

        $create = Community::create($data);

        if(!$create) {
           return $this->errorMessage('Failed to create');
        }

        return $this->successMessage('Successfully created');
    }

    public function edit(string $slug, int $userId): array {
        $community = Community::where('slug', $slug)->firstOrFail();
        
        if(!$userId || $community->owner_user_id !== $userId) {
            return $this->errorMessage('Unauthorized to edit.');
        }

        if($community->status == 'deleted') {
            return $this->errorMessage('You cannot edit deleted communities.');
        }

        $categories = Category::orderBy('name', 'asc')->get();
            
        return $this->successMessage('Loaded successfully.', [
            'item' => $community,
            'categories' => $categories
        ]);
    }

    public function show(string $slug, int $userId) {

        return Community::query()
            ->where('slug', $slug)
            ->where(function ($query) use ($userId) {
                $query
                    ->where(function ($q) {
                        $q->where('visibility', 'public')
                        ->where('status', 'active');
                    })
                    ->orWhere('owner_user_id', $userId);
            })
            ->with('category:id,name')
            ->withCount([
                'members as members_count' => function ($query) {
                    $query->where('status', 'active');
                }
            ])
            ->firstOrFail();
    }

    public function update(array $data, int $userId, string $slug, $profilePic = null, $bannerImg = null): array {

        $item = Community::where('slug', $slug)->firstOrFail();

        if(!$userId || $item->owner_user_id !== $userId) {
            abort(403);
        }

        if($item->status == 'deleted') {
            return $this->errorMessage('You cannot edit deleted communities.');
        }

        $data['profile_pic'] = $this->uploadFile($profilePic, $item->profile_pic);
        $data['banner_img'] = $this->uploadFile($bannerImg, $item->banner_img);

        $update = $item->update($data);

        if(!$update) {
            return $this->errorMessage('Failed to update.');
        }

        return $this->successMessage('Successfully updated.', [
            'item' => $item->fresh()
        ]);
    }

    public function statusDelete(string $slug): array {
    
        $item = Community::where('slug', $slug)->first();
        
        if (!$item) {
            abort(404);
        }

        if(!app(AuthService::class)->isSuperAdmin(auth()->user())) {
            abort(403);
        }

        $item->slug = $item->slug . '_deleted_by_admins' . $item->id . '_' . Str::random(10);
        $item->status = 'deleted';
        $delete = $item->save();


        if(!$delete) {
            return $this->errorMessage('Failed to delete.');
        }

        return $this->successMessage('Successfully deleted.');
    }

    public function softDelete(int $userId, string $slug): array {
    
        $item = Community::where('slug', $slug)->first();
        
        if (!$item) {
            abort(404);
        }

        if(!$userId || $item->owner_user_id !== $userId) {
            abort(403);
        }

        // $this->deleteFile($item->profile_pic);
        // $this->deleteFile($item->banner_img);

        $item->slug = $item->slug . '_deleted_' . $item->id . '_' . Str::random(10);
        $item->save();

        $delete = $item->delete();

        if(!$delete) {
            return $this->errorMessage('Failed to delete.');
        }

        return $this->successMessage('Successfully deleted.');
    }
}