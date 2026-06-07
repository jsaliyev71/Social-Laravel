<x-layout title="View Category">
    @include('layouts.aside')

    <main>
        <section class="categorySection">
            <div class="categoryHeader">
                <img src="/storage/uploads/{{ $category->image }}" alt="">
                <h3>{{ $category->name }}</h3>
            </div>
            
            <div>
                @if ($communities->isNotEmpty())
                    @foreach ($communities as $community)
                        <x-cardCommunity :community="$community"/>
                    @endforeach
                @else
                    <p class="communityAboutDetails">No communities found in this category.</p>
                @endif

            </div>
        </section>
    </main>

    @include('components.alerts')
</x-layout>