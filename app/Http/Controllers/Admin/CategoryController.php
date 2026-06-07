<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Services\CategoryService;
use App\Services\CommunityService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct(
        private CategoryService $categoryService,
        private CommunityService $communityService
    ) {}

    public function index() {
        $items = $this->categoryService->index();

        return view('admin.category.index', [
            'items' => $items
        ]);
    }

    public function create() {
        return view('admin.category.create');
    }

    public function store(CategoryRequest $request) {
        $data = $request->validated();
        $image = $request->file('image');

        $result = $this->categoryService->store($data, $image);

        if($result['status'] === 'error') {
            return back()->with($result);
        }

        return redirect()->route('cp.categories.index')->with($result);
    }

    public function edit(Request $request) {
        $result = $this->categoryService->edit($request->route('category_name'));

        return view('admin.category.edit')->with($result);
    }

    public function show(Request $request) {
        $category = $this->categoryService->show($request->route('category_name'));

        
        $communities = $this->communityService->categoryCommunity($category->id);
        
        return view('admin.category.show', compact('category', 'communities'));
    }

    public function update(CategoryRequest $request) {
        $data = $request->validated();
        $image = $request->file('image');

        $result = $this->categoryService->update($data, $request->route('category_name'), $image);

        if($result['status'] === 'error') {
            return back()->with($result);
        }

        return redirect()->route('cp.categories.index')->with($result);
    }

    public function delete(Request $request) {
        $result = $this->categoryService->delete($request->route('category_name'));

        if($result['status'] === 'error') {
            return back()->with($result);
        }

        return redirect()->route('cp.categories.index')->with($result);
    }
}
