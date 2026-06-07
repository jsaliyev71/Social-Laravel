<x-layout title="Settings">

    @include('layouts.aside')

    <main class="settingsPage">
        @include('pages.settings.partials.nav')

        <section class="settingsContent">

            <div class="settingsSection">
                <h3 class="sectionTitle">Display Name</h3>

                <form method="POST" action="{{ route('settings.profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <input name="display_name" class="inputField" value="{{ auth()->user()->display_name }}" placeholder="Display name">

                    <button class="primaryBtn">Save</button>
                </form>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Bio</h3>

                <form method="POST" action="{{ route('settings.profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <textarea 
                        name="bio" 
                        class="textareaField" 
                        placeholder="Tell something about yourself..."
                    >{{ auth()->user()->bio }}</textarea>

                    <button class="primaryBtn">Save</button>
                </form>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Gender</h3>

                <form method="POST" action="{{ route('settings.profile.update') }}" class="autoSubmitForm">
                    @csrf
                    @method('PATCH')

                    <label>
                        <input type="radio" name="gender" value="male"
                            {{ auth()->user()->gender === 'male' ? 'checked' : '' }}>
                         Male
                    </label>
                    <label>
                        <input type="radio" name="gender" value="female"
                            {{ auth()->user()->gender === 'female' ? 'checked' : '' }}>
                         Female
                    </label>
                    <label>
                        <input type="radio" name="gender" value=""
                            {{ auth()->user()->gender === null ? 'checked' : '' }}>
                         Prefer not to say
                    </label>

                    <button  class="optionBtn" hidden>Save</button>
                </form>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Profile Picture</h3>

                <div class="settingsForm">
                    <form method="POST" action="{{ route('settings.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        <input type="file" name="profile_pic" class="inputField fileField">
                        <button class="primaryBtn">Upload</button>
                    </form>
                    @if(auth()->user()->profile_pic)
                        <img src="{{ asset('storage/uploads/' . auth()->user()->profile_pic) }}" alt="Profile Pic">
                    @endif
                </div>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Banner</h3>

                <div class="settingsForm">
                    <form method="POST" action="{{ route('settings.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <input type="file" name="banner_img" class="inputField fileField">
                        <button class="primaryBtn">Upload</button>
                    </form>
                    @if(auth()->user()->banner_img)
                        <img src="{{ asset('storage/uploads/' . auth()->user()->banner_img) }}" alt="Banner Img">
                    @endif
                </div>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Danger Zone</h3>

                <button onclick="openModal('deleteModal-profile')" class="dangerBtn">
                    Delete Account
                </button>
            </div>

        </section>
    </main>

    <div id="deleteModal-profile" class="modalContainer">
        <div class="deleteModal modal">
            <button onclick="closeModal('deleteModal-profile')"><i class="fa-solid fa-xmark"></i></button>
            <form method="POST" action="{{ route('settings.account.delete') }}">
                @csrf
                @method('DELETE')
                <p>Write your username to delete your account.</p>
                <input type="text" name="confirm" value="">
                <button class="dangerBtn">Delete</button>
            </form>
        </div>
    </div>
</x-layout>
