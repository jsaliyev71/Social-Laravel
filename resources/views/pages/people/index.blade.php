<x-layout title="Communities">
    @include('layouts.aside')

    <main class="communitiesPage">
        <div class="communitiesHeader">
            <div>
                <h2>People</h2>
                <p>Discover people.</p>
            </div>
        </div>

        <div class="categoryList">
            <section class="categorySection">
                <div class="communitiesList">
                    @foreach($people as $user) 
                        <x-cardUser :user="$user"/> 
                    @endforeach 
                </div>
            </section>
        </div>
    </main>

    @include('components.alerts')
</x-layout>