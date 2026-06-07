<x-layout title="{{ $user->username }}">

    @include('layouts.aside')

    <main>

        @include('pages.profile.partials.nav')

        <div class="postsList">

            @if(($user_status ?? null) === 'private')
                <p class="cardDescription">Private profile.</p>
            @else
                @forelse($posts as $post)
                    <div class="postCardContainer js-post-card" data-url="{{ route('posts.show', ['post_id' => $post->id]) }}">
                        <x-cardPost :post="$post">
                            <x-slot name="postTop">
                                <div class="postUser">

                                    @if($post->community)
                                        @if($post->community->profile_pic)
                                            <a href="{{ route('communities.show', ['slug' => $post->community->slug]) }}">
                                                <img
                                                    class="postImage"
                                                    src="{{ asset('storage/uploads/' . $post->community->profile_pic) }}"
                                                    alt="">
                                            </a>
                                        @else
                                            <img class="postImage" src="{{ asset('storage/img/profile_placeholder_community.webp') }}" alt="">
                                        @endif
                                    @else
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
                                    @endif

                                    <div class="postInfo">
                                        @if($post->community)
                                            <a href="{{ route('communities.show', ['slug' => $post->community->slug]) }}" class="communitySlug">
                                                c/{{ $post->community->slug }}
                                            </a>
                                        @endif
                                            <a href="{{ route('profile.show', ['username' => $post->user->username]) }}" class="postUsername">
                                                u/{{ $post->user->username }}
                                            </a>
                                    </div>

                                    @if($post->post_status !== 'published')
                                        <span class="postStatus postStatus_{{ $post->post_status }}">{{ $post->post_status }}</span> 
                                    @endif

                                </div>
                            </x-slot>
                            <x-slot name="commentLink">
                                {{ route('posts.show', ['post_id' => $post->id]) }}
                            </x-slot>
                        </x-cardPost>
                    </div>

                @empty

                    <p class="cardDescription">No posts found.</p>

                @endforelse
            @endif

        </div>

    </main>
</x-layout>