<x-layout title="{{ $user->username }}">

    @include('layouts.aside')

    <main class="profilePage">

        @include('pages.profile.partials.nav')

        <section class="profileContent">
            <div class="emptyState">
                Nothing saved here.
            </div>
        </section>

    </main>
</x-layout>