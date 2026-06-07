<x-layout title="{{ $user->username }}">

    @include('layouts.aside')

    <main class="profilePage">

        @include('pages.profile.partials.nav')

        @if(($user_status ?? null) === 'private')
            <p class="cardDescription">Private profile.</p>
        @else
            <div class="profileContent">

                @forelse($comments as $comment)

                    <div class="commentCard">

                        <div class="commentTop">
                            <div class="commentMeta">

                                <a href="{{ route('profile.show', ['username' => $comment->user->username]) }}"
                                class="commentUsername">

                                    u/{{ $comment->user->username }}

                                </a>

                                <span class="cardDate">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>

                            </div>

                        </div>

                        <div class="commentBottom">

                            <div class="commentContent">
                                {{ $comment->content }}
                            </div>

                            <div class="commentActions">

                                <a href="{{ route('posts.show', ['post_id' => $comment->post_id]) }}"
                                class="cardDescription">
                                    View Post
                                </a>

                                @php
                                    $threadId = $comment->parent_comment_id ?? $comment->id;
                                @endphp

                                <a href="{{ route('posts.comments.show', [$comment->post_id, $threadId]) }}"
                                class="cardDescription">
                                    View Thread
                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="emptyState">
                        No comments yet.
                    </div>

                @endforelse

            </div>
        @endif

    </main>
</x-layout>