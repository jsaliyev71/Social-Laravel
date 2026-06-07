<x-layout title="Communities">
    @include('admin.layouts.aside')

    <main class="adminPage">

        <div class="adminHeader">
            <h2 class="adminTitle">Communities</h2>

            <a href="{{ route('cp.communities.create') }}" class="adminBtn adminBtnPrimary">
                Create Community
            </a>
        </div>

        <div class="adminTableWrapper">

            <table class="adminTable">

                <thead class="adminTableHead">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Category</th>
                        <th>Visibility</th>
                        <th>Type</th>
                        <th>Profile</th>
                        <th>Banner</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($items as $item)
                        <tr class="adminTableRow">

                            <td class="adminTableCell">{{ $item->id }}</td>

                            <td class="adminTableCell">{{ $item->name }}</td>

                            <td class="adminTableCell">{{ $item->slug }}</td>

                            <td class="adminTableCell">
                                @if($item->category)
                                    <a href="{{ route('cp.categories.show', ['category_name' => $item->category->name]) }}"
                                       class="adminLink">
                                        {{ $item->category->name }}
                                    </a>
                                @else
                                    <span class="adminMuted">None</span>
                                @endif
                            </td>

                            <td class="adminTableCell">{{ $item->visibility }}</td>

                            <td class="adminTableCell">{{ $item->type }}</td>

                            <td class="adminTableCell">
                                <img src="/storage/uploads/{{ $item->profile_pic }}"
                                     class="adminImageThumb">
                            </td>

                            <td class="adminTableCell">
                                <img src="/storage/uploads/{{ $item->banner_img }}"
                                     class="adminImageThumb">
                            </td>

                            <td class="adminTableCell">
                                {{ $item->created_at }}
                            </td>

                            <td class="adminTableCell adminActions">

                                <a href="{{ route('cp.communities.show', ['slug' => $item->slug]) }}"
                                   class="adminBtn adminBtnPrimary">
                                    View
                                </a>

                                @if(auth()->check() && $item->owner_user_id === auth()->id())
                                    <a href="{{ route('cp.communities.edit', ['slug' => $item->slug]) }}"
                                       class="adminBtn adminBtnWarning">
                                        Edit
                                    </a>
                                @endif

                                <form method="POST"
                                      action="{{ route('cp.communities.delete', ['slug' => $item->slug]) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="adminBtn adminBtnDanger">
                                        Delete
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="adminEmpty">
                                No communities found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </main>

    @include('components.alerts')
</x-layout>