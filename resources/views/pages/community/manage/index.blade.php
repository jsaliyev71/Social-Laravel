<x-layout title="Settings">

    @include('layouts.aside')

    <main class="settingsPage">
        @include('pages.community.partials.settingNav')

        <section class="settingsContent">

            <div class="settingsSection">
                <h3 class="sectionTitle">Community Name</h3>

                <form method="POST" action="{{ route('communities.manage.general.update', ['slug' => $community->slug]) }}">
                    @csrf
                    @method('PATCH')

                    <input name="name" class="inputField" value="{{ $community->name }}" placeholder="Community name">

                    <button class="primaryBtn">Save</button>
                </form>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Description</h3>

                <form method="POST" action="{{ route('communities.manage.general.update', ['slug' => $community->slug]) }}">
                    @csrf
                    @method('PATCH')

                    <textarea name="description" class="textareaField" placeholder="Community description">{{ $community->description }}</textarea>

                    <button class="primaryBtn">Save</button>
                </form>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Profile Picture</h3>

                <div class="settingsForm">
                    <form method="POST" action="{{ route('communities.manage.general.update', ['slug' => $community->slug]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <input type="file" name="profile_pic" class="inputField fileField">
                        <button class="primaryBtn">Upload</button>
                    </form>

                    @if($community->profile_pic)
                        <img src="{{ asset('storage/uploads/' . $community->profile_pic) }}" alt="Community Profile Pic">
                    @endif
                </div>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Banner</h3>

                <div class="settingsForm">
                    <form method="POST" action="{{ route('communities.manage.general.update', ['slug' => $community->slug]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <input type="file" name="banner_img" class="inputField fileField">
                        <button class="primaryBtn">Upload</button>
                    </form>

                    @if($community->banner_img)
                        <img src="{{ asset('storage/uploads/' . $community->banner_img) }}" alt="Community Banner">
                    @endif
                </div>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Category</h3>

                <form method="POST" action="{{ route('communities.manage.general.update', ['slug' => $community->slug]) }}" class="autoSubmitForm">
                    @csrf
                    @method('PATCH')

                    <select name="category_id" class="selectField">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $community->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <button class="primaryBtn" hidden>Save</button>
                </form>
            </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Danger Zone</h3>

                <button onclick="openModal('deleteModal-community')" class="dangerBtn">
                    Delete Community
                </button>
            </div>

        </section>

        <div id="deleteModal-community" class="modalContainer">
            <div class="deleteModal modal">
                <button onclick="closeModal('deleteModal-community')"><i class="fa-solid fa-xmark"></i></button>

                <form method="POST" action="{{ route('communities.manage.delete', ['slug' => $community->slug]) }}">
                    @csrf
                    @method('DELETE')

                    <p>Write the community slug to delete this community.</p>
                    <input type="text" name="confirm" value="">

                    <button class="dangerBtn">Delete</button>
                </form>
            </div>
        </div>
</x-layout>
