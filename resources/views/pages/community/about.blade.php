<x-layout title="{{ $community->name }}">
    @include('layouts.aside')

    <main class="communityShow">

        @include('pages.community.partials.nav')

        <section id="about" class="communityAbout">
            <h2>About Community</h2>

            @if($community->description ?? false)
                <p>{{ $community->description }}</p>
            @else
                <p class="communityAboutEmpty">No description yet.</p>
            @endif

            <div class="communityAboutDetails">
                <span>Members: {{ $community->members_count }}</span>
            </div>

            <div class="communityAboutDetails">
                <span>Created At: {{ $community->created_at->format('M d, Y') }}</span>
            </div>
            
        </section>

    </main>
</x-layout>