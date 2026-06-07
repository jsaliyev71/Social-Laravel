<x-layout title="Communities">
    @include('layouts.aside')

    <main class="communitiesPage">
        <div class="communitiesHeader">
            <div>
                <h2>Communities</h2>
                <p>Discover communities.</p>
            </div>

            <a href="{{ route('communities.create') }}" class="fancyButton">
                Create A Community
            </a>
        </div>

        <div class="categoryList">
            @foreach ($categories as $category)
                <section class="categorySection">
                    <div class="categoryHeader">
                        <img src="/storage/uploads/{{ $category->image }}" alt="">
                        <h3>{{ $category->name }}</h3>
                        <a class="linkA" href="{{ route('categories.show', ['category_name' => $category->name]) }}">More</a>
                    </div>

                    <div class="communitiesList">
                        @php $hasCommunities = false; @endphp
                        @foreach($communities as $community) 
                            @if($category->id === $community->category_id) 
                                @php $hasCommunities = true; @endphp 
                                <x-cardCommunity :community="$community" /> 
                            @endif 
                        @endforeach 
                        
                        @if(!$hasCommunities) 
                            <p>This category doesn't have communities yet.</p> 
                        @endif 

                    </div>
                </section>
            @endforeach
        </div>
    </main>

    @include('components.alerts')
</x-layout>