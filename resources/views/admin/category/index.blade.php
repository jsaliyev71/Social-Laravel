<x-layout title="Categories">
    @include('admin.layouts.aside')

    <main class="adminPage">

        <div class="adminHeader">
            <h2 class="adminTitle">Categories</h2>

            <a href="{{ route('cp.categories.create') }}" class="adminBtn adminBtnPrimary">
                Create Category
            </a>
        </div>

        <div class="adminTableWrapper">
            <table class="adminTable">
                <thead class="adminTableHead">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($items as $item)
                        <tr class="adminTableRow">
                            <td class="adminTableCell">{{ $item->id }}</td>

                            <td class="adminTableCell">
                                {{ $item->name }}
                            </td>

                            <td class="adminTableCell">
                                <img
                                    src="/storage/uploads/{{ $item->image }}"
                                    class="adminImageThumb"
                                    alt=""
                                >
                            </td>

                            <td class="adminTableCell">
                                {{ $item->created_at }}
                            </td>

                            <td class="adminTableCell adminActions">
                                <a class="adminBtn adminBtnPrimary"
                                   href="{{ route('cp.categories.show', ['category_name' => $item->name]) }}">
                                    View
                                </a>

                                <a class="adminBtn adminBtnWarning"
                                   href="{{ route('cp.categories.edit', ['category_name' => $item->name]) }}">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('cp.categories.delete', ['category_name' => $item->name]) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="adminBtn adminBtnDanger" type="submit">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="adminTableCell adminEmpty">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

    @include('components.alerts')
</x-layout>