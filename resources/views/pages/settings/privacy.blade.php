<x-layout title="Settings">

    @include('layouts.aside')

    @php
        $settings = auth()->user()->userSettings;
    @endphp

    <main class="settingsPage">
        @include('pages.settings.partials.nav')

        <section class="settingsContent">

            <div class="settingsSection">
                <h3 class="sectionTitle">Allow messages from people?</h3>

                <form method="POST" action="{{ route('settings.privacy.update') }}" class="autoSubmitForm">
                    @csrf
                    @method('PATCH')
                    
                    <label>
                        <input type="radio" name="allow_message_requests" value="1" {{ (string)$settings->allow_message_requests === '1' ? 'checked' : '' }}> Allow
                    </label>

                    <label>
                        <input type="radio" name="allow_message_requests" value="0" {{ (string)$settings->allow_message_requests === '0' ? 'checked' : '' }}> Not allow
                    </label>

                    <button class="primaryBtn" hidden>Save</button>
                </form>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Follow Mode</h3>

                <form method="POST" action="{{ route('settings.privacy.update') }}" class="autoSubmitForm">
                    @csrf
                    @method('PATCH')

                    <select name="follow_mode" class="selectField">
                        <option value="everyone" {{ $settings->follow_mode === 'everyone' ? 'selected' : '' }}>Everyone</option>
                        <option value="approval" {{ $settings->follow_mode === 'approval' ? 'selected' : '' }}>Approval Required</option>
                        <option value="nobody" {{ $settings->follow_mode === 'nobody' ? 'selected' : '' }}>Nobody</option>
                    </select>

                    <button class="primaryBtn" hidden>Save</button>
                </form>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Profile Visibility</h3>

                <form method="POST" action="{{ route('settings.privacy.update') }}" class="autoSubmitForm">
                    @csrf
                    @method('PATCH')

                    <select name="profile_visibility" class="selectField">
                        <option value="public" {{ $settings->profile_visibility === 'public' ? 'selected' : '' }}>Public</option>
                        <option value="followers" {{ $settings->profile_visibility === 'followers' ? 'selected' : '' }}>Followers</option>
                        <option value="private" {{ $settings->profile_visibility === 'private' ? 'selected' : '' }}>Private</option>
                    </select>

                    <button class="primaryBtn" hidden>Save</button>
                </form>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Post Visibility</h3>

                <form method="POST" action="{{ route('settings.privacy.update') }}" class="autoSubmitForm">
                    @csrf
                    @method('PATCH')

                    <select name="post_visibility" class="selectField">
                        <option value="public" {{ $settings->post_visibility === 'public' ? 'selected' : '' }}>Public</option>
                        <option value="followers" {{ $settings->post_visibility === 'followers' ? 'selected' : '' }}>Followers</option>
                        <option value="private" {{ $settings->post_visibility === 'private' ? 'selected' : '' }}>Private</option>
                    </select>

                    <button class="primaryBtn" hidden>Save</button>
                </form>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Comment Visibility</h3>

                <form method="POST" action="{{ route('settings.privacy.update') }}" class="autoSubmitForm">
                    @csrf
                    @method('PATCH')

                    <select name="comment_visibility" class="selectField">
                        <option value="public" {{ $settings->comment_visibility === 'public' ? 'selected' : '' }}>Public</option>
                        <option value="followers" {{ $settings->comment_visibility === 'followers' ? 'selected' : '' }}>Followers</option>
                        <option value="private" {{ $settings->comment_visibility === 'private' ? 'selected' : '' }}>Private</option>
                    </select>

                    <button class="primaryBtn" hidden>Save</button>
                </form>
            </div>

        </section>
    </main>

</x-layout>

