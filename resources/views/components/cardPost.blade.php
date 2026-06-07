<article class="postCard removeCard {{ $post->is_sensitive ? 'is-sensitive' : '' }}">

    <div class="postTop">

        {{ $postTop }}

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

                {{ $adminActions ?? '' }}
            </div>
        </div>

    </div>
    
    <h3 class="postTitle">
        {{ $post->title }} 
    </h3>

    @if($post->is_sensitive)
        <div class="sensitiveOverlay js-sensitive-overlay">
            <div class="sensitiveBox">
                <p>⚠️ Sensitive content</p>
                <button class="revealBtn js-reveal-btn">View</button>
            </div>
        </div>
    @endif

    <div class="js-post-content">
        @if($post->post_type === 'text')

            <div class="postContent textPostContent">
                {{ $post->content }}
            </div>

        @endif


        @if($post->post_type === 'image')

            @php
                $mediaCount = $post->media->count();
            @endphp

            @if($mediaCount === 1)

                @php $media = $post->media->first(); @endphp

                @if($media->media_type === 'image')
                    <img src="{{ asset('storage/uploads/' . $media->file_url) }}" class="postMediaItem">
                @else
                    <video class="postMediaItem postVideo" controls>
                        <source src="{{ asset('storage/uploads/' . $media->file_url) }}">
                    </video>
                @endif

            @else
            
                <div class="postSlider" data-slider>

                    <button class="sliderBtn prev" type="button">‹</button>

                    <div class="sliderTrack">

                        @foreach($post->media as $media)

                            <div class="slide">

                                @if($media->media_type === 'image')
                                    <img src="{{ asset('storage/uploads/' . $media->file_url) }}">
                                @else
                                    <video controls>
                                        <source src="{{ asset('storage/uploads/' . $media->file_url) }}">
                                    </video>
                                @endif

                            </div>

                        @endforeach

                    </div>

                    <button class="sliderBtn next" type="button">›</button>

                </div>

            @endif

        @endif
    </div>

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

        <a href="{{ $commentLink }}" class="postActionBtn">
            <i class="fa-regular fa-comment"></i>
            <span>
                {{ $post->comments_count ?? 0 }}
            </span>
        </a>

    </div>

</article>
