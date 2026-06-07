<x-layout title="Manage Posts">

    @include('layouts.aside')

    <main class="settingsPage">
        @include('pages.community.partials.settingNav')

        <div class="subNav">

            <a href="?tab=pending"
            class="subNavItem {{ request('tab', 'pending') === 'pending' ? 'active' : '' }}">
                Pending
            </a>

            <a href="?tab=pinned"
            class="subNavItem {{ request('tab') === 'pinned' ? 'active' : '' }}">
                Pinned
            </a>

            <!-- <a href="?tab=reports"
            class="subNavItem {{ request('tab') === 'reports' ? 'active' : '' }}">
                Reports
            </a> -->

            <a href="?tab=removed"
            class="subNavItem {{ request('tab') === 'removed' ? 'active' : '' }}">
                Removed
            </a>

        </div>

        <div class="settingsContent">

            @forelse($posts as $post)

                <x-cardPost :post="$post" :community="$community">

                    <x-slot name="postTop">
                        <div class="postUser">

                            <a href="{{ route('profile.show', ['username' => $post->user->username]) }}">
                                <img class="postImage"
                                     src="{{ asset('storage/uploads/' . $post->user->profile_pic) }}">
                            </a>

                            <div>
                                <a class="postUsername"
                                   href="{{ route('profile.show', ['username' => $post->user->username]) }}">
                                    u/{{ $post->user->username }}
                                </a>

                                <div class="mutedText smallText">
                                    {{ $post->created_at->diffForHumans() }}
                                </div>
                            </div>

                        </div>
                    </x-slot>

                    <x-slot name="adminActions">

                        @if($post->post_status === 'pending')

                            <button
                                type="button"
                                class="dropdownItem buttonReset js-fetch-action"
                                data-url="{{ route('communities.manage.posts.accept', [$community->slug, $post->id]) }}"
                                data-method="POST"
                                data-behaviour="remove">

                                <i class="fa-solid fa-check"></i>
                                <span>Approve</span>
                            </button>

                            <button
                                type="button"
                                class="dropdownItem buttonReset js-fetch-action"
                                data-url="{{ route('communities.manage.posts.reject', [$community->slug, $post->id]) }}"
                                data-method="POST"
                                data-behaviour="remove">

                                <i class="fa-solid fa-xmark"></i>
                                <span>Reject</span>
                            </button>

                        @endif


                        @if ($post->post_status === 'active')
                            <button
                                type="button"
                                class="dropdownItem buttonReset js-fetch-action textDanger"
                                data-url="{{ route('communities.manage.posts.remove', [$community->slug, $post->id]) }}"
                                data-method="DELETE"
                                data-behaviour="remove">

                                <i class="fa-regular fa-trash-can"></i>
                                <span>Remove</span>
                            </button>
                            
                            @if($post->is_pinned)

                                <button
                                    type="button"
                                    class="dropdownItem buttonReset js-fetch-action"
                                    data-url="{{ route('communities.manage.posts.unpin', [$community->slug, $post->id]) }}"
                                    data-method="POST"
                                    data-state="unpin"
                                    data-behaviour="pinToggle">

                                    <i class="fa-solid fa-thumbtack-slash"></i>
                                    <span>Unpin</span>
                                </button>

                            @else

                                <button
                                    type="button"
                                    class="dropdownItem buttonReset js-fetch-action"
                                    data-url="{{ route('communities.manage.posts.pin', [$community->slug, $post->id]) }}"
                                    data-method="POST"
                                    data-state="pin"
                                    data-behaviour="pinToggle">

                                    <i class="fa-solid fa-thumbtack"></i>
                                    <span>Pin</span>
                                </button>

                            @endif
                        @endif

                        @if ($post->is_pinned)
                            <button
                                type="button"
                                class="dropdownItem buttonReset js-fetch-action textDanger"
                                data-url="{{ route('communities.manage.posts.remove', [$community->slug, $post->id]) }}"
                                data-method="DELETE"
                                data-behaviour="remove">

                                <i class="fa-regular fa-trash-can"></i>
                                <span>Remove</span>
                            </button>
                            
                            @if($post->is_pinned)

                                <button
                                    type="button"
                                    class="dropdownItem buttonReset js-fetch-action"
                                    data-url="{{ route('communities.manage.posts.unpin', [$community->slug, $post->id]) }}"
                                    data-method="POST"
                                    data-state="unpin"
                                    data-behaviour="remove">

                                    <i class="fa-solid fa-thumbtack-slash"></i>
                                    <span>Unpin</span>
                                </button>

                            @endif
                        @endif

                    </x-slot>
                    <x-slot name="commentLink">
                        {{ route('posts.show', ['post_id' => $post->id]) }}
                    </x-slot>

                </x-cardPost>

            @empty
                <div class="emptyState">
                    No posts in this section.
                </div>
            @endforelse

        </div>

    </main>

</x-layout>