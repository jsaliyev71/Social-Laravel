<x-layout title="Create Category">
    @include('admin.layouts.aside')

    <main class="adminPage">

        <div class="adminHeader">
            <h2 class="adminTitle">Create Category</h2>
        </div>

        <div class="adminTableWrapper" style="padding: var(--space-md);">

            <form method="POST"
                  action="{{ route('cp.categories.store') }}"
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
                    <label class="adminLabel">Image</label>
                    <input type="file"
                           name="image"
                           class="adminInput">
                </div>

                <div class="adminActions">
                    <button type="submit" class="adminBtn adminBtnPrimary">
                        Create
                    </button>
                </div>

            </form>

        </div>

    </main>

    @include('components.alerts')
</x-layout>