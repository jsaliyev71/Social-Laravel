<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\CommunitySection;
use App\Traits\HandleUploads;
use App\Traits\ReturnResult;
use Illuminate\Http\Request;

class CommunitySectionController extends Controller
{
    use ReturnResult, HandleUploads;

    public function index(Request $request, string $slug) {
        $community = Community::where('slug', $slug)->firstOrFail();

        if($community->owner_user_id !== auth()->id()) {
            abort(403);
        }

        return view('pages.community.manage.sections', [
            'community' => $community,
            'sections' => $community->sections
        ]);
    }

    public function store(Request $request, string $slug) {
        $community = Community::where('slug', $slug)->firstOrFail();

        if($community->owner_user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:20'],
            'section_pic' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        if($request->hasFile('section_pic')) {
            $data['section_pic'] = $this->uploadFile($data['section_pic']);
        }

        $store = $community->sections()->create($data);

        if(!$store) {
            return back()->with($this->errorMessage('Could not store.'));
        }

        return back()->with($this->successMessage('Stored.'));
    }

    public function update(Request $request, string $slug) {

        $community = Community::where('slug', $slug)->firstOrFail();

        if($community->owner_user_id !== auth()->user()->id) {
            abort(403);
        }

        $section = CommunitySection::where('id', $request->route('section_id'))->firstOrFail();

        if($section->community_id !== $community->id) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:20'],
            'section_pic' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        if($request->hasFile('section_pic')) {
            $data['section_pic'] = $this->uploadFile($data['section_pic'], $section->section_pic);
        }

        $update = $section->update($data);

        if(!$update) {
            return back()->with($this->errorMessage('Could not update.'));
        }

        return back()->with($this->successMessage('Updated.'));
    }

    public function delete(Request $request, string $slug) {

        $community = Community::where('slug', $slug)->firstOrFail();

        if($community->owner_user_id !== auth()->id()) {
            abort(403);
        }

        $section = CommunitySection::where('id', $request->route('section_id'))->firstOrFail();

        if($section->community_id !== $community->id) {
            abort(403);
        }

        if($section->section_pic) {
            $this->deleteFile($section->section_pic);
        }

        $delete = $section->delete();

        if(!$delete) {
            return back()->with($this->errorMessage('Could not delete.'));
        }

        return back()->with($this->successMessage('Deleted.'));
    }
}
