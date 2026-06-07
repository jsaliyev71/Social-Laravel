<x-layout title="Edit Community">
    @include('layouts.aside')

    <main class="formPage">
        <header class="formHeader">
            <h2>Edit Community</h2>
            <p>Update your community details and settings.</p>
        </header>

        <form class="formContent"
              method="POST"
              action="{{ route('communities.update', ['slug' => request()->route('slug')]) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <section class="formSection">
                <h3 class="sectionTitle">Basic Information</h3>

                <div class="formGroup">
                    <label class="formLabel">Name</label>
                    <input class="inputField" type="text" name="name" value="{{ $item->name }}">
                </div>

                <div class="formGroup">
                    <label class="formLabel">Slug</label>
                    <input class="inputField" type="text" name="slug" value="{{ $item->slug }}">
                </div>

                <div class="formGroup">
                    <label class="formLabel">Category</label>
                    <select class="selectField" name="category_id">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="formGroup">
                    <label class="formLabel">Description</label>
                    <textarea class="textareaField" name="description">{{ $item->description }}</textarea>
                </div>
            </section>

            <section class="formSection">
                <h3 class="sectionTitle">Community Media</h3>

                <div class="formGroup">
                    <label class="formLabel">Profile Picture</label>
                    <input class="fileField" type="file" name="profile_pic">

                    @if($item->profile_pic)
                        <img class="previewImage" src="/storage/uploads/{{ $item->profile_pic }}">
                    @endif
                </div>

                <div class="formGroup">
                    <label class="formLabel">Banner Image</label>
                    <input class="fileField" type="file" name="banner_img">

                    @if($item->banner_img)
                        <img class="previewImage" src="/storage/uploads/{{ $item->banner_img }}">
                    @endif
                </div>
            </section>

            <section class="formSection">
                <h3 class="sectionTitle">Rules & Access</h3>

                <div class="formGroup">
                    <label class="formLabel">Visibility</label>
                    <select class="selectField" name="visibility">
                        <option value="public" {{ $item->visibility === 'public' ? 'selected' : '' }}>Public</option>
                        <option value="private" {{ $item->visibility === 'private' ? 'selected' : '' }}>Private</option>
                    </select>
                </div>

                <div class="formGroup">
                    <label class="formLabel">Posting Mode</label>
                    <select class="selectField" name="posting_mode">
                        <option value="members" {{ $item->posting_mode === 'members' ? 'selected' : '' }}>Members</option>
                        <option value="admins" {{ $item->posting_mode === 'admins' ? 'selected' : '' }}>Admins Only</option>
                    </select>
                </div>

                <div class="formGroup">
                    <label class="formLabel">Commenting Mode</label>
                    <select class="selectField" name="commenting_mode">
                        <option value="everyone" {{ $item->commenting_mode === 'everyone' ? 'selected' : '' }}>Everyone</option>
                        <option value="members" {{ $item->commenting_mode === 'members' ? 'selected' : '' }}>Members Only</option>
                    </select>
                </div>

                <label class="checkRow">
                    <input class="checkField"
                           type="checkbox"
                           name="requires_join_approval"
                           value="1"
                           {{ $item->requires_join_approval ? 'checked' : '' }}>
                    <span>Requires post approval</span>
                </label>
            </section>

            <div class="formActions">
                <button class="primaryBtn" type="submit">Update Community</button>
            </div>
        </form>
    </main>

    @include('components.alerts')
</x-layout>