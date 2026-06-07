<x-layout title="View Category">
    @include('admin.layouts.aside')

    <main class="adminPage">

        <div class="adminHeader">
            <h2 class="adminTitle">Category Details</h2>

            <a href="{{ url()->previous() }}" class="adminBtn adminBtnWarning">
                Back
            </a>
        </div>

        <div class="adminDetailCard">

            <div class="adminDetailRow">
                <span class="adminDetailLabel">ID</span>
                <span class="adminDetailValue">{{ $category->id }}</span>
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Name</span>
                <span class="adminDetailValue">{{ $category->name }}</span>
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Image</span>
                <img src="/storage/uploads/{{ $category->image }}" class="adminDetailImage">
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Created</span>
                <span class="adminDetailValue">{{ $category->created_at }}</span>
            </div>

        </div>

        <h3 class="adminSubTitle">Communities</h3>

        <div class="adminGrid">

            @forelse ($communities as $community)
                <div class="adminCard">

                    <img src="/storage/uploads/{{ $community->profile_pic }}" class="adminCardImage">

                    <div class="adminCardBody">
                        <div class="adminCardTitle">
                            {{ $community->name }}
                        </div>

                        <a href="{{ route('cp.communities.show', ['slug' => $community->slug]) }}"
                           class="adminBtn adminBtnPrimary">
                            View
                        </a>
                    </div>

                </div>
            @empty
                <p class="adminEmpty">No communities found in this category.</p>
            @endforelse

        </div>

    </main>

    @include('components.alerts')
</x-layout>