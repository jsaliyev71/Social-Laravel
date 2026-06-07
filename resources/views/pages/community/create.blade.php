<x-layout title="Create Community">
    @include('layouts.aside')

    <main class="formPage">
        <header class="formHeader">
            <h2>Create Community</h2>
            <p>Set up your community identity, visibility, and posting rules.</p>
        </header>

        <form class="formContent" method="POST" action="{{ route('communities.store') }}" enctype="multipart/form-data">
            @csrf

            <section class="formSection">
                <h3 class="sectionTitle">Basic Information</h3>

                <div class="formGroup">
                    <label class="formLabel">Name</label>
                    <input class="inputField" type="text" name="name" value="{{ old('name') }}">
                </div>

                <div class="formGroup">
                    <label class="formLabel">Slug</label>
                    <input class="inputField" type="text" name="slug" value="{{ old('slug') }}">
                </div>

                <div class="formGroup">
                    <label class="formLabel">Category</label>
                    <select class="selectField" name="category_id">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="formGroup">
                    <label class="formLabel">Description</label>
                    <textarea class="textareaField" name="description">{{ old('description') }}</textarea>
                </div>
            </section>

            <section class="formSection">
                <h3 class="sectionTitle">Community Media</h3>

                <div class="formGroup">
                    <label class="formLabel">Profile Picture</label>
                    <input class="fileField" type="file" name="profile_pic">
                </div>

                <div class="formGroup">
                    <label class="formLabel">Banner Image</label>
                    <input class="fileField" type="file" name="banner_img">
                </div>
            </section>

            <section class="formSection">
                <h3 class="sectionTitle">Rules & Access</h3>

                <div class="formGroup">
                    <label class="formLabel">Visibility</label>
                    <select class="selectField" name="visibility">
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                    </select>
                </div>

                <div class="formGroup">
                    <label class="formLabel">Posting Mode</label>
                    <select class="selectField" name="posting_mode">
                        <option value="members">Members</option>
                        <option value="admins">Admins Only</option>
                    </select>
                </div>

                <div class="formGroup">
                    <label class="formLabel">Commenting Mode</label>
                    <select class="selectField" name="commenting_mode">
                        <option value="everyone">Everyone</option>
                        <option value="members">Members Only</option>
                    </select>
                </div>

                <label class="checkRow">
                    <input class="checkField" type="checkbox" name="requires_join_approval" value="1">
                    <span>Requires join approval</span>
                </label>
            </section>

            <div class="formActions">
                <button class="primaryBtn" type="submit">Create Community</button>
            </div>
        </form>
    </main>

    @include('components.alerts')
</x-layout>