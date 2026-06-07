<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\CommunitySection;
use Illuminate\Http\Request;

class AjaxSectionController extends Controller
{
    public function index(int $community_id) {
        $sections = CommunitySection::where('community_id', $community_id)
            ->select('id', 'name', 'color')
            ->get();

            return response()->json($sections);
    } 
}
