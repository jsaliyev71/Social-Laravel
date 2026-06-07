<x-layout title="{{ $user->username }}">

    @include('layouts.aside')

    <main class="profilePage">

        @include('pages.profile.partials.nav')

        @if(($user_status ?? null) === 'private')
            <p class="cardDescription">Private profile.</p>
        @else
            <div class="profileContent">
                <h2>About</h2>

                @if($user->bio ?? false)
                    <p>{{ $user->bio }}</p>
                @else
                    <p class="communityAboutEmpty">User didn't write anything about themselves.</p>
                @endif
            </div>
        @endif

    </main>
</x-layout>