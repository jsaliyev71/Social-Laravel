<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Traits\ReturnResult;
use Illuminate\Http\Request;

class CommunityMemberController extends Controller
{

    use ReturnResult;

   public function follow(Request $request, string $slug) {

        if(auth()->user()->is_banned) {
            return $this->returnJsonResult('error', 'Banned user.', 403);
        }

        $action = $request->input('action');

        $community = Community::where('slug', $slug)->firstOrFail();

        if (auth()->user()->is_banned) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are banned.'
            ], 403);
        }

        if ($community->owner_user_id === auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are owner of this community.'
            ], 403);
        }

        if ($community->visibility === 'private' || $community->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot access.'
            ], 403);
        }

        $member = $community->members()
            ->where('user_id', auth()->id())
            ->first();

        if ($action === 'follow') {

            if($member && $member->status === 'banned') {
                return $this->returnJsonResult('error', 'Unauthorized', 403);
            }

            $member = $community->members()->updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'status' => $community->requires_join_approval
                        ? 'request'
                        : 'active'
                ]
            );

            if (!$member->joined_at) {
                $member->update([
                    'joined_at' => now()
                ]);
            }

            return response()->json([
                'button_status' => $member->status,
                'status' => 'success'
            ]);
        }

        if ($action === 'unfollow') {

            if (!$member) {
                return response()->json([
                    'status' => 'none'
                ]);
            }

            $member->update([
                'status' => $member->status === 'request'
                    ? 'cancelled'
                    : 'left'
            ]);

            return response()->json([
                'button_status' => $member->status,
                'status' => 'success'
            ]);
        }

        return $this->returnJsonResult('error', 'Something went wrong.', [
            'button_status' => 'none',
        ]);
    }
}
