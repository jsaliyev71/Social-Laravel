<?php

namespace App\Http\Controllers;

use App\Traits\HandleUploads;
use App\Traits\ReturnResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

class UserSettingsController extends Controller
{
    use HandleUploads, ReturnResult;

    public function index() {return view('pages.settings.index');}

    public function preferences() {return view('pages.settings.preferences');}

    public function privacy() {return view('pages.settings.privacy');}


    public function updateProfile(Request $request) {

        $data = $request->validate([
            'display_name' => ['sometimes', 'required', 'string', 'min:4', 'max:100'],
            'profile_pic' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'banner_img' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'bio' => ['sometimes', 'nullable', 'string', 'max:500'],
            'gender' => ['sometimes', 'nullable', 'in:female,male'],
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_pic')) {
            $data['profile_pic'] = $this->uploadFile($request->file('profile_pic'), $user->profile_pic);
        }

        if ($request->hasFile('banner_img')) {
            $data['banner_img'] = $this->uploadFile($request->file('banner_img'), $user->banner_img);
        }

        $update = $user->update($data);

        $message = $update
            ? $this->successMessage('Updated.')
            : $this->errorMessage('Failed to update.');

        return back()->with($message);
    }


    public function updatePreferences(Request $request) {
        $data = $request->validate([
            'language' => ['sometimes', 'required', 'in:en,az,ru'],
            'is_notifications_muted' => ['sometimes', 'required', 'boolean'],
            'theme' => ['sometimes', 'required', 'in:light,dark'],
        ]);

        $settings = auth()->user()->userSettings()->firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $update = $settings->update($data);

        $message = $update
            ? $this->successMessage('Updated.')
            : $this->errorMessage('Failed to update.');

        return back()->with($message);
    }


    public function updatePrivacy(Request $request) {
        $data = $request->validate([
            'comment_visibility' => ['sometimes', 'required', 'in:public,followers,private'],
            'post_visibility' => ['sometimes', 'required', 'in:public,followers,private'],
            'profile_visibility' => ['sometimes', 'required', 'in:public,followers,private'],
            'follow_mode' => ['sometimes', 'required', 'in:everyone,approval,nobody'],
            'allow_message_requests' => ['sometimes', 'required', 'boolean'],
        ]);

        $settings = auth()->user()->userSettings()->firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $update = $settings->update($data);

        $message = $update
            ? $this->successMessage('Updated.')
            : $this->errorMessage('Failed to update.');

        return back()->with($message);
    }

    public function deleteAccount(Request $request) {
        $request->validate([
            'confirm' => ['required', 'in:' . auth()->user()->username],
        ]);

        $user = auth()->user();

        Auth::logout();

        $user->username = $user->username . '_deleted_' . $user->id . '_' . Str::random(10);
        $user->save();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home.index')->with($this->successMessage('Account deleted.'));
    }
}
