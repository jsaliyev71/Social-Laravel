<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Community;
use App\Traits\HandleUploads;
use App\Traits\ReturnResult;
use Illuminate\Http\Request;
use Str;

class CommunityManageController extends Controller
{
    use ReturnResult, HandleUploads;

    public function index(Request $request) {
        $community = Community::where('slug', $request->route('slug'))->firstOrFail();

        if($community->owner_user_id !== auth()->user()->id) {
            abort(403);
        }

        $categories = Category::orderBy('name')->get();

        return view('pages.community.manage.index', compact('community', 'categories'));
    }

    public function preferences(Request $request) {
        $community = Community::where('slug', $request->route('slug'))->firstOrFail();
        
        if($community->owner_user_id !== auth()->user()->id) {
            abort(403);
        }

        return view('pages.community.manage.preferences', compact('community'));
    }

    public function privacy(Request $request) {
        $community = Community::where('slug', $request->route('slug'))->firstOrFail();
        
        if($community->owner_user_id !== auth()->user()->id) {
            abort(403);
        }

        return view('pages.community.manage.privacy', compact('community'));
    }

    public function updateGeneral(Request $request, string $slug) {
        $community = Community::where('slug', $slug)->firstOrFail();

        if($community->owner_user_id !== auth()->user()->id) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['sometimes', 'string', 'min:3', 'max:100'],
            'description' => ['sometimes', 'nullable', 'string', 'max:1000'],
            'category_id' => ['sometimes', 'exists:categories,id'],
            'profile_pic' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:100'],
            'banner_img' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:500'],
        ]);

        if ($request->filled('name')) {
            $data['name'] = $request->name;
        }

        if ($request->has('description')) {
            $data['description'] = $request->description;
        }

        if ($request->hasFile('profile_pic')) {
            $data['profile_pic'] = $this->uploadFile(
                $request->file('profile_pic'),
                $community->profile_pic
            );
        }

        if ($request->hasFile('banner_img')) {
            $data['banner_img'] = $this->uploadFile(
                $request->file('banner_img'),
                $community->banner_img
            );
        }

        if ($request->filled('category_id')) {
            $data['category_id'] = $request->category_id;
        }

        $community->update($data);

        return back()->with($this->successMessage('Updated.'));
    }

    public function updatePrivacy(Request $request, string $slug) {
        $community = Community::where('slug', $slug)->firstOrFail();

        if($community->owner_user_id !== auth()->user()->id) {
            abort(403);
        }

        $data = $request->validate([
            'visibility' => ['sometimes', 'in:public,private'],
            'posting_mode' => ['sometimes', 'in:members,request,admins'],
            'commenting_mode' => ['sometimes', 'in:everyone,members'],
            'requires_join_approval' => ['sometimes', 'boolean'],
        ]);

        $update = $community->update($data);

        if(!$update) {
            return back()->with($this->errorMessage('Could not update'));
        }

        return back()->with($this->successMessage('Updated.'));
    }

    public function communityDelete(Request $request, string $slug) {
        $community = Community::where('slug', $slug)->firstOrFail();

        if($community->owner_user_id !== auth()->user()->id) {
            abort(403);
        }

        $request->validate([
            'confirm' => ['required', 'in:' . $request->route('slug')],
        ]);

        $community->slug = $community->slug . '_deleted_' . $community->id . '_' . Str::random(10);
        $community->save();

        $delete = $community->delete();

        if(!$delete) {
            return back()->with($this->errorMessage('Could not delete.'));
        }

        return redirect()->route('home.index')->with($this->successMessage('Deleted successfully.'));
    }
}

