<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Traits\ReturnResult;
use Illuminate\Http\Request;

class CommunityManageMemberController extends Controller
{
    use ReturnResult;

    public function index(Request $request, string $slug) {
        $community = Community::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $community->owner_user_id) {
            abort(403);
        }

        $tab = $request->input('tab', 'requests');

        $members = $community->members()
            ->with('user')

            ->when($tab === 'requests', function ($query) {
                $query->where('status', 'request');
            })

            ->when($tab === 'members', function ($query) {
                $query->where('status', 'active');
            })

            ->when($tab === 'banned', function ($query) {
                $query->where('status', 'banned');
            })

            ->latest()
            ->get();

        return view('pages.community.manage.members', compact('community', 'members'));
    }

    public function accept(string $slug, int $user_id) {
        $community = Community::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $community->owner_user_id) {
            return $this->returnJsonResult('error', 'Unauthorized.', 403);
        }

        $member = $community->members()
            ->where('user_id', $user_id)
            ->firstOrFail();

        if ($member->status !== 'request') {
            return $this->returnJsonResult(
                'error',
                'Member is not in request state.',
                422
            );
        }

        $member->update([
            'status' => 'active',
        ]);

        if (!$member->joined_at) {
            $member->update([
                'joined_at' => now()
            ]);
        }

        return $this->returnJsonResult(
            'success',
            'Added.'
        );
    }

    public function reject(string $slug, int $user_id)
    {
        $community = Community::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $community->owner_user_id) {
            return $this->returnJsonResult('error', 'Unauthorized.', 403);
        }

        $member = $community->members()
            ->where('user_id', $user_id)
            ->firstOrFail();

        if ($member->status !== 'request') {
            return $this->returnJsonResult(
                'error',
                'Member is not in request state.',
                422
            );
        }

        $member->update([
            'status' => 'rejected',
        ]);

        return $this->returnJsonResult(
            'success',
            'Rejected.'
        );
    }

    public function remove(string $slug, int $user_id)
    {
        $community = Community::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $community->owner_user_id) {
            return $this->returnJsonResult('error', 'Unauthorized.', 403);
        }

        $member = $community->members()
            ->where('user_id', $user_id)
            ->firstOrFail();

        if ($member->status !== 'active') {
            return $this->returnJsonResult(
                'error',
                'Member is not active.',
                422
            );
        }

        $member->update([
            'status' => 'removed',
        ]);

        return $this->returnJsonResult(
            'success',
            'Removed.'
        );
    }

    public function ban(string $slug, int $user_id)
    {
        $community = Community::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $community->owner_user_id) {
            return $this->returnJsonResult('error', 'Unauthorized.', 403);
        }

        $member = $community->members()
            ->where('user_id', $user_id)
            ->firstOrFail();

        $member->update([
            'status' => 'banned',
        ]);

        return $this->returnJsonResult(
            'success',
            'Banned.'
        );
    }

    public function unban(string $slug, int $user_id)
    {
        $community = Community::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $community->owner_user_id) {
            return $this->returnJsonResult('error', 'Unauthorized.', 403);
        }

        $member = $community->members()
            ->where('user_id', $user_id)
            ->firstOrFail();

        if ($member->status !== 'banned') {
            return $this->returnJsonResult(
                'error',
                'Member is not banned.',
                422
            );
        }

        $member->update([
            'status' => 'active',
        ]);

        return $this->returnJsonResult(
            'success',
            'Unbanned.'
        );
    }
}