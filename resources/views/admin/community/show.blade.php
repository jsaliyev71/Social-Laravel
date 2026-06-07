<x-layout title="View Community">
    @include('admin.layouts.aside')

    <main class="adminPage">

        <div class="adminHeader">
            <h2 class="adminTitle">Community Details</h2>

            <div class="adminActions">
                <a href="{{ url()->previous() }}" class="adminBtn adminBtnWarning">Back</a>

                @if(auth()->check() && $item->owner_user_id === auth()->id())
                    <a href="{{ route('cp.communities.edit', ['slug' => $item->slug]) }}"
                       class="adminBtn adminBtnPrimary">
                        Edit
                    </a>
                @endif
            </div>
        </div>

        <div class="adminDetailCard">

            <div class="adminDetailRow">
                <span class="adminDetailLabel">ID</span>
                <span class="adminDetailValue">{{ $item->id }}</span>
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Name</span>
                <span class="adminDetailValue">{{ $item->name }}</span>
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Slug</span>
                <span class="adminDetailValue">{{ $item->slug }}</span>
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Category</span>

                @if($item->category)
                    <a class="adminLink"
                       href="{{ route('cp.categories.show', ['category_name' => $item->category->name]) }}">
                        {{ $item->category->name }}
                    </a>
                @else
                    <span class="adminMuted">None</span>
                @endif
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Visibility</span>
                <span class="adminBadge">{{ $item->visibility }}</span>
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Type</span>
                <span class="adminBadge">{{ $item->type }}</span>
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Profile Picture</span>
                <img src="/storage/uploads/{{ $item->profile_pic }}"
                     class="adminDetailImage">
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Banner Image</span>
                <img src="/storage/uploads/{{ $item->banner_img }}"
                     class="adminDetailBanner">
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Created At</span>
                <span class="adminDetailValue">{{ $item->created_at }}</span>
            </div>

        </div>

        <div class="adminDangerZone">

            <form method="POST"
                  action="{{ route('cp.communities.delete', ['slug' => $item->slug]) }}">
                @csrf
                @method('DELETE')

                <button type="submit" class="adminBtn adminBtnDanger">
                    Delete Community
                </button>
            </form>

        </div>

    </main>

    @include('components.alerts')
</x-layout>