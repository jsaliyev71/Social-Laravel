<x-layout title="Search">

    @include('layouts.aside')

    <main class="searchPage">

        <div class="searchTabs">

            <a href="{{ route('search.index', ['search' => request('search'), 'type' => 'all']) }}"
            class="searchTab {{ request('type', 'all') === 'all' ? 'active' : '' }}">
                All
            </a>

            <a href="{{ route('search.index', ['search' => request('search'), 'type' => 'posts']) }}"
            class="searchTab {{ request('type') === 'posts' ? 'active' : '' }}">
                Posts
            </a>

            <a href="{{ route('search.index', ['search' => request('search'), 'type' => 'communities']) }}"
            class="searchTab {{ request('type') === 'communities' ? 'active' : '' }}">
                Communities
            </a>

        </div>

        <div class="searchHeader">
            <div>
                <h2>Search</h2>
                <p>Results for "{{ $query ?? '' }}"</p>
            </div>
        </div>

        <div class="searchContainer">

            @if($posts->count())
                <section class="searchBlock">

                    <div class="searchBlockHeader">
                        <h3>Posts</h3>
                        <span>{{ $posts->count() }}</span>
                    </div>

                    <div class="searchList">

                        @foreach($posts as $post)
                            <div class="searchItem js-post-card searchPostItem"
                                data-url="{{ route('posts.show', ['post_id' => $post->id]) }}">
                                <div class="searchPostLeft">

                                    <img
                                        class="searchAvatar"
                                        src="{{ asset('storage/uploads/' . $post->user->profile_pic) }}"
                                        alt=""
                                    >

                                    <div class="searchPostContent">

                                        <div class="searchItemTitle">
                                            {{ $post->title }}
                                        </div>

                                        <div class="searchItemMeta">
                                            u/{{ $post->user->username }}
                                            •
                                            {{ $post->created_at->diffForHumans() }}
                                        </div>

                                        @if($post->content)
                                            <div class="searchPostPreview">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 90) }}
                                            </div>
                                        @endif

                                    </div>

                                </div>

                                @if($post->media && $post->media->count())
                                    <img
                                        class="searchPostImage"
                                        src="{{ asset('storage/uploads/' . $post->media[0]->file_url) }}"
                                        alt=""
                                    >
                                @endif
                            </div>
                        @endforeach

                    </div>

                </section>
            @endif

            @if($communities->count())
                <section class="searchBlock">

                    <div class="searchBlockHeader">
                        <h3>Communities</h3>
                        <span>{{ $communities->count() }}</span>
                    </div>

                    <div class="communitiesList compact">

                        @foreach($communities as $community)
                            <x-cardCommunity :community="$community" />
                        @endforeach

                    </div>

                </section>
            @endif

            @if(!$posts->count() && !$communities->count())
                <div class="noDataText">
                    Nothing found.
                </div>
            @endif

        </div>

    </main>

</x-layout>