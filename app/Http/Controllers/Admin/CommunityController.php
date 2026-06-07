<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommunityRequest;
use App\Services\CommunityService;
use App\Traits\HandleUploads;
use Illuminate\Http\Request;

class CommunityController extends Controller {
    use HandleUploads;

    public function __construct(
        private CommunityService $communityService
    ) {}

    public function index() {
        $items = $this->communityService->index();

        return view('admin.community.index', [
            'items' => $items
        ]);
    }

    public function create() {
        $categories = $this->communityService->create();

        return view('admin.community.create', [
            'categories' => $categories
        ]);
    }

    public function store(CommunityRequest $request) {

        $data = $request->validated();
        $profilePic = $request->file('profile_pic');
        $bannerImg = $request->file('banner_img');

        $result = $this->communityService->store($data, auth()->id(), $profilePic, $bannerImg);

        if($result['status'] === 'error') {
            return back()->with($result);
        }

        return redirect()->route('cp.communities.index')->with([
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }

    public function edit(Request $request) {

        $result = $this->communityService->edit($request->route('slug'), auth()->id());

        return view('admin.community.edit')->with($result);
    }

    public function show(Request $request) {

        $item = $this->communityService->show($request->route('slug'), auth()->id());

        return view('admin.community.show')->with([
            'item' => $item
        ]);
    }

    public function update(CommunityRequest $request) {
        $data = $request->validated();
        $profilePic = $request->file('profile_pic');
        $bannerImg = $request->file('banner_img');

        $result = $this->communityService->update($data, auth()->id(), $request->route('slug'), $profilePic, $bannerImg);

        if($result['status'] === 'error') {
            return back()->with($result);
        }

        return redirect()->route('cp.communities.index', [
            'slug' => $result['item']->slug
        ])->with([
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }

    public function delete(Request $request) {
        
        $result = $this->communityService->statusDelete($request->route('slug'));
        
        if($result['status'] === 'error') {
            return back()->with($result);
        }

        return redirect()->route('cp.communities.index')->with([
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
}
