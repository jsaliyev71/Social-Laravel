<x-layout title="Community Privacy">

    @include('layouts.aside')

    <main class="settingsPage">
        @include('pages.community.partials.settingNav')

        <section class="settingsContent">

            <div class="settingsSection">
                <h3 class="sectionTitle">Community Visibility</h3>

                <form method="POST" action="{{ route('communities.manage.privacy.update', ['slug' => $community->slug]) }}" class="autoSubmitForm">
                    @csrf
                    @method('PATCH')

                    <select name="visibility" class="selectField">
                        <option value="public" {{ $community->visibility === 'public' ? 'selected' : '' }}>Public</option>
                        <option value="private" {{ $community->visibility === 'private' ? 'selected' : '' }}>Private</option>
                    </select>

                    <button class="primaryBtn" hidden>Save</button>
                </form>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Posting Mode</h3>

                <form method="POST" action="{{ route('communities.manage.privacy.update', ['slug' => $community->slug]) }}" class="autoSubmitForm">
                    @csrf
                    @method('PATCH')

                    <select name="posting_mode" class="selectField">
                        <option value="members" {{ $community->posting_mode === 'members' ? 'selected' : '' }}>Members</option>
                        <option value="request" {{ $community->posting_mode === 'request' ? 'selected' : '' }}>Request</option>
                        <option value="admins" {{ $community->posting_mode === 'admins' ? 'selected' : '' }}>Admins Only</option>
                    </select>

                    <button class="primaryBtn" hidden>Save</button>
                </form>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Commenting Mode</h3>

                <form method="POST" action="{{ route('communities.manage.privacy.update', ['slug' => $community->slug]) }}" class="autoSubmitForm">
                    @csrf
                    @method('PATCH')

                    <select name="commenting_mode" class="selectField">
                        <option value="everyone" {{ $community->commenting_mode === 'everyone' ? 'selected' : '' }}>Everyone</option>
                        <option value="members" {{ $community->commenting_mode === 'members' ? 'selected' : '' }}>Members Only</option>
                    </select>

                    <button class="primaryBtn" hidden>Save</button>
                </form>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Requires Join Approval?</h3>

                <form method="POST" action="{{ route('communities.manage.privacy.update', ['slug' => $community->slug]) }}" class="autoSubmitForm">
                    @csrf
                    @method('PATCH')

                    <label>
                        <input type="radio" name="requires_join_approval" value="1" {{ (string)$community->requires_join_approval === '1' ? 'checked' : '' }}>
                        Required
                    </label>

                    <label>
                        <input type="radio" name="requires_join_approval" value="0" {{ (string)$community->requires_join_approval === '0' ? 'checked' : '' }}>
                        Not required
                    </label>

                    <button class="primaryBtn" hidden>Save</button>
                </form>
            </div>

        </section>
    </main>

</x-layout>