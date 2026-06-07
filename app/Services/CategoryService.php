<?php

namespace App\Services;

use App\Models\{
    Category, Community
};
use App\Traits\{
    HandleUploads,
    ReturnResult
};

class CategoryService {
    use HandleUploads, ReturnResult;

    public function __construct(
        private CommunityService $communityService
    ) {}

    public function index() {
        return Category::orderBy('id', 'desc')->get();
    }

    public function create() {
    }

    public function store(array $data, $image = null) {

        $data['image'] = $this->uploadFile($image);

        $create = Category::create($data);

        if(!$create) {
           return $this->errorMessage('Failed to create');
        }

        return $this->successMessage('Successfully created');
    }

    public function edit(string $categoryName) {
        $item = Category::where('name',$categoryName)->firstOrFail();

        return $this->successMessage('Loaded successfully.', [
            'item' => $item
        ]);
    }

    public function show(string $categoryName) {
        return Category::where('name', $categoryName)->firstOrFail();
    }

    public function update(array $data, string $categoryName, $image = null) {

        $item = Category::where('name', $categoryName)->first();

        if (!$item) {
            abort(404);
        }

        $data['image'] = $this->uploadFile($image, $item->image);

        $update = $item->update($data);

        if(!$update) {
           return $this->errorMessage('Failed to update.');
        }

        return $this->successMessage('Successfully updated');
    }

    public function delete(string $categoryName) {
        $item = Category::where('name', $categoryName)->first();

        if (!$item) {
            abort(404);
        }

        $this->deleteFile($item->image);

        $delete = $item->delete();

        if(!$delete) {
           return $this->errorMessage('Failed to delete.');
        }

        return $this->successMessage('Successfully deleted');
    }
}