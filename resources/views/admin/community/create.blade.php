<x-layout title="Create Community">
    @include('admin.layouts.aside')

    <main class="adminPage">

        <div class="adminHeader">
            <h2 class="adminTitle">Create Community</h2>
        </div>

        <div class="adminTableWrapper" style="padding: var(--space-md);">

            <form method="POST"
                  action="{{ route('cp.communities.store') }}"
                  enctype="multipart/form-data"
                  class="adminForm">

                @csrf

                <div class="adminFormGroup">
                    <label class="adminLabel">Name</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="adminInput">
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Slug</label>
                    <input type="text"
                           name="slug"
                           value="{{ old('slug') }}"
                           class="adminInput">
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Category</label>
                    <select name="category_id" class="adminInput">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Description</label>
                    <textarea name="description"
                              class="adminInput">{{ old('description') }}</textarea>
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Profile Picture</label>
                    <input type="file" name="profile_pic" class="adminInput">
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Banner Image</label>
                    <input type="file" name="banner_img" class="adminInput">
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Visibility</label>
                    <select name="visibility" class="adminInput">
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                    </select>
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Posting Mode</label>
                    <select name="posting_mode" class="adminInput">
                        <option value="members">Members</option>
                        <option value="admins">Admins Only</option>
                    </select>
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Commenting Mode</label>
                    <select name="commenting_mode" class="adminInput">
                        <option value="everyone">Everyone</option>
                        <option value="members">Members Only</option>
                    </select>
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Type</label>
                    <select name="type" class="adminInput">
                        <option value="system">System</option>
                        <option value="normal">Normal</option>
                    </select>
                </div>

                <div class="adminFormGroup adminCheckbox">
                    <label class="adminCheckboxLabel">
                        <input type="checkbox"
                               name="requires_join_approval"
                               value="1">
                        Requires Join Approval
                    </label>
                </div>

                <div class="adminActions">
                    <button type="submit" class="adminBtn adminBtnPrimary">
                        Create Community
                    </button>
                </div>

            </form>

        </div>

    </main>

    @include('components.alerts')
</x-layout>