<x-layout title="Edit Community">
    @include('admin.layouts.aside')

    <main class="adminPage">

        <div class="adminHeader">
            <h2 class="adminTitle">Edit Community</h2>
        </div>

        <div class="adminTableWrapper" style="padding: var(--space-md);">

            <form method="POST"
                  action="{{ route('cp.communities.update', ['slug' => request()->route('slug')]) }}"
                  enctype="multipart/form-data"
                  class="adminForm">

                @csrf
                @method('PATCH')

                <div class="adminFormGroup">
                    <label class="adminLabel">Name</label>
                    <input type="text"
                           name="name"
                           value="{{ $item->name }}"
                           class="adminInput">
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Slug</label>
                    <input type="text"
                           name="slug"
                           value="{{ $item->slug }}"
                           class="adminInput">
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Category</label>
                    <select name="category_id" class="adminInput">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $item->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Description</label>
                    <textarea name="description"
                              class="adminInput">{{ $item->description }}</textarea>
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Profile Picture</label>
                    <input type="file" name="profile_pic" class="adminInput">

                    @if($item->profile_pic)
                        <img src="/storage/uploads/{{ $item->profile_pic }}"
                             class="adminImagePreview">
                    @endif
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Banner Image</label>
                    <input type="file" name="banner_img" class="adminInput">

                    @if($item->banner_img)
                        <img src="/storage/uploads/{{ $item->banner_img }}"
                             class="adminImagePreview">
                    @endif
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Visibility</label>
                    <select name="visibility" class="adminInput">
                        <option value="public" {{ $item->visibility == 'public' ? 'selected' : '' }}>Public</option>
                        <option value="private" {{ $item->visibility == 'private' ? 'selected' : '' }}>Private</option>
                    </select>
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Posting Mode</label>
                    <select name="posting_mode" class="adminInput">
                        <option value="members" {{ $item->posting_mode == 'members' ? 'selected' : '' }}>Members</option>
                        <option value="admins" {{ $item->posting_mode == 'admins' ? 'selected' : '' }}>Admins Only</option>
                    </select>
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Commenting Mode</label>
                    <select name="commenting_mode" class="adminInput">
                        <option value="everyone" {{ $item->commenting_mode == 'everyone' ? 'selected' : '' }}>Everyone</option>
                        <option value="members" {{ $item->commenting_mode == 'members' ? 'selected' : '' }}>Members Only</option>
                    </select>
                </div>

                <div class="adminFormGroup adminCheckbox">
                    <label class="adminCheckboxLabel">
                        <input type="checkbox"
                               name="requires_join_approval"
                               value="1"
                               {{ $item->requires_join_approval ? 'checked' : '' }}>
                        Requires Join Approval
                    </label>
                </div>

                <div class="adminActions">
                    <button type="submit" class="adminBtn adminBtnPrimary">
                        Update Community
                    </button>
                </div>

            </form>

        </div>

    </main>

    @include('components.alerts')
</x-layout>