<?php

namespace App\Http\Controllers;

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

        return view('pages.category.index', [
            'items' => $items
        ]);
    }

    public function show(Request $request) {
        $category = $this->categoryService->show($request->route('category_name'));

        
        $communities = $this->communityService->categoryCommunity($category->id);
        
        return view('pages.category.show')->with([
            'category' => $category,
            'communities' => $communities
        ]);
    }
}
