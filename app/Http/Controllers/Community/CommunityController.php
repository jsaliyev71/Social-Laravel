<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommunityRequest;
use App\Services\CategoryService;
use App\Services\CommunityService;
use App\Services\PostService;
use App\Traits\HandleUploads;
use App\Traits\ReturnResult;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    use HandleUploads, ReturnResult;

    public function __construct(
        private CommunityService $communityService,
        private CategoryService $categoryService,
        private PostService $postService
    ) {}

    public function index() {
        $communities = $this->communityService->index();
        
        $categories = $this->categoryService->index();

        return view('pages.community.index', compact('communities', 'categories'));
    }

    public function create() {

        if(auth()->user()->is_banned) {
            return back()->with($this->errorMessage('Banned User.'));
        }

        $categories = $this->communityService->create();

        return view('pages.community.create', [
            'categories' => $categories
        ]);
    }

    public function store(CommunityRequest $request) {

        if(auth()->user()->is_banned) {
            return back()->with($this->errorMessage('Banned User.'));
        }

        $data = $request->validated();
        $profilePic = $request->file('profile_pic');
        $bannerImg = $request->file('banner_img');

        $result = $this->communityService->store($data, auth()->id(), $profilePic, $bannerImg);

        if($result['status'] === 'error') {
            return back()->with($result);
        }

        return redirect()->route('communities.index')->with([
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }

    public function edit(Request $request) {

        $result = $this->communityService->edit($request->route('slug'), auth()->id());

        if($result['status'] == 'error') {
            return back()->with($result);
        }

        return view('pages.community.edit')->with($result);
    }

    public function show(Request $request) {

        $community = $this->communityService->show($request->route('slug'), auth()->id());

        $posts = $this->postService->index($community->id);

        $membership = $community->members()
            ->where('user_id', auth()->id())
            ->first();

        return view('pages.community.show', compact('community', 'membership', 'posts'));
    }

    public function about(Request $request) {
        
        $community = $this->communityService->show($request->route('slug'), auth()->id());

        $membership = $community->members()
            ->where('user_id', auth()->id())
            ->first();

        return view('pages.community.about', compact('community', 'membership'));
    }

    public function update(CommunityRequest $request) {
        $data = $request->validated();
        $profilePic = $request->file('profile_pic');
        $bannerImg = $request->file('banner_img');

        $result = $this->communityService->update($data, auth()->id(), $request->route('slug'), $profilePic, $bannerImg);

        if($result['status'] === 'error') {
            return back()->with($result);
        }

        return redirect()->route('communities.show', [
            'slug' => $result['item']->slug
        ])->with([
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }

    public function delete(Request $request) {
        
        $result = $this->communityService->softDelete(auth()->id(), $request->route('slug'));
        

        if($result['status'] === 'error') {
            return back()->with($result);
        }

        return redirect()->route('communities.index')->with([
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
}
