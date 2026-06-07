<x-layout title="Edit Category">
    @include('admin.layouts.aside')

    <main class="adminPage">

        <div class="adminHeader">
            <h2 class="adminTitle">Edit Category</h2>
        </div>

        <div class="adminTableWrapper" style="padding: var(--space-md);">

            <form
                method="POST"
                action="{{ route('cp.categories.update', ['category_name' => request()->route('category_name')]) }}"
                enctype="multipart/form-data"
                class="adminForm"
            >
                @csrf
                @method('PATCH')

                <div class="adminFormGroup">
                    <label class="adminLabel">Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ $item->name }}"
                        class="adminInput"
                    >
                </div>

                <div class="adminFormGroup">
                    <label class="adminLabel">Image</label>
                    <input
                        type="file"
                        name="image"
                        class="adminInput"
                    >
                </div>

                @if($item->image)
                    <div class="adminFormGroup">
                        <img
                            src="/storage/uploads/{{ $item->image }}"
                            class="adminImagePreview"
                        >
                    </div>
                @endif

                <div class="adminActions">
                    <button type="submit" class="adminBtn adminBtnPrimary">
                        Update
                    </button>
                </div>

            </form>

        </div>

    </main>

    @include('components.alerts')
</x-layout>