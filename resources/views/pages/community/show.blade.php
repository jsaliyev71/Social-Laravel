<x-layout title="{{ $community->name }}">
    @include('layouts.aside')

    <main class="communityShow">

        @include('pages.community.partials.nav')

        <section id="posts" class="communityFeed">
            <div class="communityFeedHeader">
                <h2></h2>
                <a href="{{ route('communities.post.create', ['slug' => request('slug')]) }}">Create Post</a>
            </div>

            <div class="pinnedPostsContainer">
                <div class="pinnedBtn">Pinned Posts</div>
                <div class="pinnedPosts">
                    @php
                        $pinnedPosts = $posts->where('is_pinned', true);
                    @endphp

                    @forelse($pinnedPosts as $post)
                        <div class="pinnedPostContainer js-post-card" data-url="{{ route('communities.posts.show', ['slug' => $community->slug, 'post_id' => $post->id]) }}">
                            <x-cardPost :post="$post">
                                <x-slot name="postTop">
                                    <div class="postUser">
                                        <a href="{{ route('profile.show', ['username' => $post->user->username]) }}">
                                            @if($post->user->profile_pic)
                                                <img
                                                    class="postImage"
                                                    src="{{ asset('storage/uploads/' . $post->user->profile_pic) }}"
                                                    alt="">
                                            @else
                                                <img class="postImage" src="{{ asset('storage/img/profile_img_for_emtpy_things.png') }}" alt="">
                                            @endif
                                        </a>
                                        <div>
                                            <div>
                                                <a href="{{ route('profile.show', ['username' => $post->user->username]) }}" class="postUsername">
                                                    u/{{ $post->user->username }}
                                                </a>
                                            </div>
                                        </div>
                                        <span class="cardDate">
                                            {{  ($post->published_at ?? $post->created_at)->diffForHumans() }}
                                        </span>
                                    </div>
                                </x-slot>
                                <x-slot name="commentLink">
                                    {{ route('communities.posts.show', ['slug' => $community->slug, 'post_id' => $post->id]) }}
                                </x-slot>
                            </x-cardPost>
                        </div>
                    @empty
                        <p class="noDataText">No pins.</p>
                    @endforelse
                </div>
            </div>

            <div class="postsList">

                @forelse($posts as $post)
                    <div class="postCardContainer js-post-card" data-url="{{ route('communities.posts.show', ['slug' => $community->slug, 'post_id' => $post->id]) }}">
                        <x-cardPost :post="$post">
                            <x-slot name="postTop">
                                <div class="postUser">
                                    <a href="{{ route('profile.show', ['username' => $post->user->username]) }}">
                                        <img
                                            class="postImage"
                                            src="{{ asset('storage/uploads/' . $post->user->profile_pic) }}"
                                            alt="">
                                    </a>
                                    <div>
                                        <div>
                                            <a href="{{ route('profile.show', ['username' => $post->user->username]) }}" class="postUsername">
                                                u/{{ $post->user->username }}
                                            </a>
                                        </div>
                                    </div>
                                    <span class="cardDate">
                                        {{  ($post->published_at ?? $post->created_at)->diffForHumans() }}
                                    </span>
                                </div>
                            </x-slot>
                            <x-slot name="commentLink">
                                {{ route('communities.posts.show', ['slug' => $community->slug, 'post_id' => $post->id]) }}
                            </x-slot>
                            <x-slot name="adminActions">
                                @if($community->owner_user_id === auth()->id())
                                    <button
                                        type="button"
                                        class="dropdownItem buttonReset js-fetch-action"
                                        data-url="{{ $post->is_pinned
                                            ? route('communities.manage.posts.unpin', [$community->slug, $post->id])
                                            : route('communities.manage.posts.pin', [$community->slug, $post->id]) }}"
                                        data-pin-url="{{ route('communities.manage.posts.pin', [$community->slug, $post->id]) }}"
                                        data-unpin-url="{{ route('communities.manage.posts.unpin', [$community->slug, $post->id]) }}"
                                        data-method="POST"
                                        data-behaviour="pinToggle">

                                        <i class="fa-solid {{ $post->is_pinned ? 'fa-thumbtack-slash' : 'fa-thumbtack' }}"></i>

                                        <span>
                                            {{ $post->is_pinned ? 'Unpin' : 'Pin' }}
                                        </span>
                                    </button>

                                    <button
                                        type="button"
                                        class="dropdownItem buttonReset js-fetch-action textDanger"
                                        data-url="{{ route('communities.manage.posts.remove', ['slug' => $community->slug, 'post_id' => $post->id]) }}"
                                        data-method="DELETE"
                                        data-behaviour="remove">

                                        <i class="fa-regular fa-trash-can"></i>
                                        <span>Remove</span>
                                    </button>

                                    <button
                                        type="button"
                                        class="dropdownItem buttonReset js-fetch-action"
                                        data-url="{{ $post->user->is_banned
                                            ? route('communities.manage.members.unban', ['slug' => request()->route('slug'), 'user_id' => $post->user->id])
                                            : route('communities.manage.members.ban', ['slug' => request()->route('slug'), 'user_id' => $post->user->id]) }}"
                                        data-method="POST"
                                        data-behaviour="banToggle"
                                        data-is-banned="{{ $post->user->is_banned ? 1 : 0 }}"
                                    >

                                        @if($post->user->is_banned)

                                            <i class="fa-solid fa-user-check"></i>
                                            <span>Unban User</span>

                                        @else

                                            <i class="fa-solid fa-user-slash"></i>
                                            <span>Ban User</span>

                                        @endif

                                    </button>
                                @endif
                            </x-slot>
                        </x-cardPost>
                    </div>
                @empty

                    <p class="noDataText">No posts found.</p>

                @endforelse

            </div>
        </section>

    </main>
</x-layout>