@props([
    'comment',
    'post',
    'community' => null,
    'depth' => 0
])

<article class="commentCard" data-id="{{ $comment->id }}" 
data-depth="{{ $depth }}"
data-post-id="{{ $comment->post_id }}">
    <div class="commentTop js-comment-action"
        data-behaviour="closeCommentBody">
        <a href="{{ route('profile.show', ['username' => $comment->user->username]) }}" class="commentImageContainer">
            @if ($comment->user->profile_pic)
                <img
                    class="postImage"
                    src="{{ asset('storage/uploads/' . $comment->user->profile_pic) }}"
                    alt="">
            @else
                <img class="postImage" src="{{ asset('storage/img/profile_img_for_emtpy_things.png') }}" alt="">
            @endif
        </a>

        <div class="commentMeta">

            <a href="{{ route('profile.show', ['username' => $comment->user->username]) }}"
                class="commentUsername">

                u/{{ $comment->user->username }}

                @if ($comment->user_id === $post->user_id)
                    <span class="commentOp">OP</span>
                @endif

            </a>

            <span class="cardDate">
                {{ $comment->created_at->diffForHumans() }}
            </span>
        </div>
    </div>

    <div class="commentBottom">
        <div class="commentContent">

            @if($comment->comment_status === 'deleted_user')
                <p class="commentDeleted">
                    [ deleted by user ]
                </p>
            @elseif($comment->comment_status === 'deleted_admin')
                <p class="commentDeleted">
                    [ deleted by admin ]
                </p>
            @else
                {{ $comment->content }}
            @endif

        </div>

        <div class="commentActions cardReactions">

            <button
                type="button"
                class="commentActionBtn js-fetch-action"
                data-url="{{ route('comments.react', $comment->id) }}"
                data-method="POST"
                data-behaviour="reactionToggle"
                data-reaction-type="like">

                @if($comment->my_reaction === 'like')
                    <i class="fa-solid fa-thumbs-up"></i>
                @else
                    <i class="fa-regular fa-thumbs-up"></i>
                @endif

                <span class="js-like-count">
                    {{ $comment->likes_count ?? 0 }}
                </span>
            </button>

            <button
                type="button"
                class="commentActionBtn js-fetch-action"
                data-url="{{ route('comments.react', $comment->id) }}"
                data-method="POST"
                data-behaviour="reactionToggle"
                data-reaction-type="dislike">

                @if($comment->my_reaction === 'dislike')
                    <i class="fa-solid fa-thumbs-down"></i>
                @else
                    <i class="fa-regular fa-thumbs-down"></i>
                @endif

                <span class="js-dislike-count">
                    {{ $comment->dislikes_count ?? 0 }}
                </span>
            </button>

            <button class="commentActionBtn js-comment-action" data-behaviour="toggleReply">
                <i class="fa-solid fa-reply"></i>
                <span>Reply</span>
            </button>

            @if(auth()->id() === $comment->user_id || request()->route('slug') && $community->owner_user_id === auth()->id())

                <div class="dropdownContainer">

                    <button class="dropdown-btn buttonReset dropdown-btnDesign">
                        ⋯
                    </button>

                    <div class="dropdownMenu">

                        @if(auth()->id() === $comment->user_id)
                            <button
                                type="button"
                                class="dropdownItem buttonReset js-comment-action" data-behaviour="openEdit"
                                data-url="{{ route('comments.update', $comment->id) }}"
                                data-method="PATCH">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <span>Edit</span>

                            </button>

                            <button
                                type="button"
                                class="dropdownItem buttonReset js-fetch-action"
                                data-url="{{ route('comments.delete', $comment->id) }}"
                                data-method="DELETE"
                                data-delete-type="user"
                                data-behaviour="deleteComment">

                                <i class="fa-regular fa-trash-can"></i>
                                <span>Delete</span>

                            </button>
                        @endif

                        @if( request()->route('slug') && $community?->owner_user_id === auth()->id())
                            <button
                                type="button"
                                class="dropdownItem buttonReset js-fetch-action"
                                data-url="{{ route('comments.delete', $comment->id) }}"
                                data-method="DELETE"
                                data-delete-type="admin"
                                data-behaviour="deleteComment">

                                <i class="fa-regular fa-trash-can"></i>
                                <span>Remove</span>
                            </button> 
                        @endif
                    </div>                        
                </div>
            @endif
         </div>

        <div class="commentReplyFormContainer"></div>
        
        <div class="commentReplies">

                @if(!empty($comment->replies))
                    @if ($depth > 3)
                        <a class="cardDescription" href="{{ route('posts.comments.show', [$comment->post_id, $comment->id]) }}">More Replies</a>
                    @else
                        @foreach($comment->replies as $reply)

                            <x-cardComment :comment="$reply" :post="$post" :community="$community ?? null" :depth="$depth + 1"/>

                        @endforeach
                    @endif
                @endif
        </div>
    </div>
</article>
