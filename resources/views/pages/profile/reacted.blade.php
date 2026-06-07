<x-layout title="{{ $user->username }}">

    @include('layouts.aside')

    <main class="profilePage">

        @include('pages.profile.partials.nav')

        <section class="profileContent">
            <div class="emptyState">
                No reactions made.
            </div>
        </section>

    </main>
</x-layout>