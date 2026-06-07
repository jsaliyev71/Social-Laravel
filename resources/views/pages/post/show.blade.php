<x-layout :title="$post->title">

    @include('layouts.aside')

    <main>
        <article class="postCard removeCard">

            <div class="postTop">

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

                <div class="dropdownContainer">
                    <button class="dropdown-btn buttonReset dropdown-btnDesign">⋯</button>

                    <div class="dropdownMenu">
                        @if($post->user_id === auth()->id())
                            <!-- <button class="dropdownItem buttonReset" data-action="pin">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <span>Pin To Profile</span>
                            </button> -->

                            <form action="{{ route('posts.edit', ['post_id' => $post->id]) }}" method="GET" class="dropdownItem">
                                <button class=" buttonReset">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </button>
                            </form>

                            <button type="button" class="dropdownItem buttonReset js-fetch-action" 
                                data-url="{{ route('posts.delete', $post->id) }}"
                                data-method="DELETE"
                                data-behaviour="remove">
                                <i class="fa-regular fa-trash-can"></i>
                                <span>Delete</span>
                            </button>
                        @endif

                        <!-- <button class="dropdownItem buttonReset" data-action="follow">
                            <i class="fa-regular fa-trash-can"></i>
                            <span>Follow Post</span>
                        </button> -->

                        <button type="button" class="dropdownItem buttonReset" 
                            data-action="save"
                            data-id="{{ $post->id }}">
                            <i class="fa-regular fa-bookmark"></i>
                            <span>Save</span>
                        </button>

                        <button type="button" class="dropdownItem buttonReset" 
                            data-action="hide"
                            data-id="{{ $post->id }}">
                            <i class="fa-regular fa-eye-slash"></i>
                            <span>Hide</span>
                        </button>

                        <!-- <button class="dropdownItem buttonReset" data-action="report">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <span>Report</span>
                        </button> -->

                    </div>
                </div>
            </div>
            <h3 class="postTitle">
                {{ $post->title }} 
            </h3>

            @if($post->post_type === 'text')

                <div class="postContent">{{ $post->content }}</div>

            @endif


            @if($post->post_type === 'image')

                @php
                    $mediaCount = $post->media->count();
                @endphp

                @if($mediaCount === 1)

                    @php $media = $post->media->first(); @endphp

                    <div class="mediaWrapper">
                        @if($media->media_type === 'image')
                            <div class="mediaBlurBg"
                                style="background-image:url('{{ asset('storage/uploads/' . $media->file_url) }}')">
                            </div>

                            <img src="{{ asset('storage/uploads/' . $media->file_url) }}"
                                class="postMediaItem">
                        @else
                            <div class="mediaBlurBg mediaVideoBg"></div>

                            <video class="postMediaItem postVideo" controls>
                                <source src="{{ asset('storage/uploads/' . $media->file_url) }}">
                            </video>
                        @endif
                    </div>

                @else
                
                    <div class="postSlider" data-slider>

                        <button class="sliderBtn prev" type="button">‹</button>

                        <div class="sliderTrack">

                            @foreach($post->media as $media)

                                <div class="slide">

                                @if($media->media_type === 'image')
                                    <div class="mediaBlurBg"
                                        style="background-image:url('{{ asset('storage/uploads/' . $media->file_url) }}')">
                                    </div>

                                    <img src="{{ asset('storage/uploads/' . $media->file_url) }}"
                                        class="postMediaItem">
                                @else
                                    <div class="mediaBlurBg mediaVideoBg"></div>

                                    <video class="postMediaItem postVideo" controls>
                                        <source src="{{ asset('storage/uploads/' . $media->file_url) }}">
                                    </video>
                                @endif

                                </div>

                            @endforeach

                        </div>

                        <button class="sliderBtn next" type="button">›</button>

                    </div>

                @endif

                @if ($post->description)
                    <div class="postContent">{{ $post->description }}</div>
                @endif

            @endif


            <div class="postActions cardReactions">

                <button
                    type="button"
                    class="postActionBtn js-fetch-action"
                    data-url="{{ route('posts.react', $post->id) }}"
                    data-method="POST"
                    data-behaviour="reactionToggle"
                    data-reaction-type="like">

                    @if($post->my_reaction === 'like')
                        <i class="fa-solid fa-thumbs-up"></i>
                    @else
                        <i class="fa-regular fa-thumbs-up"></i>
                    @endif

                    <span class="js-like-count">
                        {{ $post->likes_count ?? 0 }}
                    </span>
                </button>

                <button
                    type="button"
                    class="postActionBtn js-fetch-action"
                    data-url="{{ route('posts.react', $post->id) }}"
                    data-method="POST"
                    data-behaviour="reactionToggle"
                    data-reaction-type="dislike">

                    @if($post->my_reaction === 'dislike')
                        <i class="fa-solid fa-thumbs-down"></i>
                    @else
                        <i class="fa-regular fa-thumbs-down"></i>
                    @endif

                    <span class="js-dislike-count">
                        {{ $post->dislikes_count ?? 0 }}
                    </span>
                </button>

                <a href="#commentForm" class="postActionBtn">
                    <i class="fa-regular fa-comment"></i>
                    <span>
                        {{ $post->comments_count ?? 0 }}
                    </span>
                </a>
            </div>

            <div id="commentForm" class="commentsSection" data-url="{{ route('posts.comments.store', ['post_id' => $post->id]) }}">

                @auth
                    <div class="commentSection">

                        <h3 class="postUsername">Add a comment</h3>

                        <form class="commentForm js-form-action"
                            data-method="POST"
                            data-behaviour="createComment">

                            <textarea name="content" class="textareaField js-comment-input"
                                    placeholder="Write a comment..."></textarea>

                            <div class="formActions">
                                <button type="submit" class="primaryBtn">
                                    Comment
                                </button>
                            </div>
                        </form>

                    </div>
                @endauth

                <div class="commentsList js-comment-list">

                    @forelse($comments as $comment)

                        <x-cardComment :comment="$comment" :post="$post" :community="$community ?? null"
                        :depth="0"/>

                    @empty

                        <div class="emptyComments">

                            <p class="postUsername">
                                No comments yet.
                            </p>

                        </div>

                    @endforelse

                </div>

                @if($goToPost ?? false) 
                    <a class="fancyButton" href="{{ route('posts.show', $post->id) }}">Go To Main Thread</a>
                @endif
            </div>

        </article>
    </main>

</x-layout>
