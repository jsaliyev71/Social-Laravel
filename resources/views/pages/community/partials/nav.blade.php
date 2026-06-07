<div class="communityHead">
    <div class="communityBanner">
        @if($community->banner_img)
            <img src="{{ asset('storage/uploads/' . $community->banner_img) }}" alt="{{ $community->name }} banner">
        @endif
    </div>

    <div class="communityHeadContent">
        <div class="communityProfile">
            @if($community->profile_pic)
                <img src="{{ asset('storage/uploads/' . $community->profile_pic) }}" alt="{{ $community->name }}">
            @else
                <span>{{ strtoupper(substr($community->name, 0, 1)) }}</span>
            @endif
        </div>

        <div class="cardHeadInfo">
            <h1>{{ $community->name }}</h1>

            <a href="{{ route('communities.show', ['slug' => $community->slug]) }}" class="communitySlug">
                c/{{ $community->slug }}
            </a>
            <br>
            <a href="{{ route('profile.show', ['username' => $community->owner->username]) }}" class="communitySlug">
                &#64;/{{ $community->owner->username }}
            </a>
            <p class="cardDate">
                members: {{ $community->members_count }}
            </p>
            <div class="communityCategory">
                @if($community->category)
                    <a href="{{ route('categories.show', ['category_name' => $community->category->name]) }}">
                        {{ $community->category->name }}
                    </a>
                @endif
            </div>
        </div>

        @if(auth()->check() && $community->owner_user_id !== auth()->id())

            @php
                $status = $membership->status ?? 'none';

                $action = match($status) {
                    'active' => 'unfollow',
                    'request' => 'unfollow',
                    default => 'follow',
                };
            @endphp

            <div class="followBtn">
                <button
                    type="button"
                    class="manageCommunityBtn js-fetch-action"
                    data-url="{{ route('communities.follow', ['slug' => $community->slug]) }}"
                    data-method="POST"
                    data-behaviour="followButton"
                    data-action="{{ $action }}">

                    @if(!$community->myMembership || in_array($status, ['left', 'cancelled', 'rejected', 'removed', 'none']))
                        Follow

                    @elseif($status === 'request')
                        Requested

                    @elseif($status === 'active')
                        Unfollow
                    @elseif($status === 'banned')
                        Banned
                    @endif
                </button>
            </div>

        @endif

        @if(auth()->check() && $community->owner_user_id === auth()->id())
            <div class="communityOwnerPanel">
                <span class="communityStatus">
                    {{ ucfirst($community->visibility) }}
                </span>

                <a href="{{ route('communities.manage.index', ['slug' => $community->slug]) }}" class="manageCommunityBtn">
                    <i class="fa-solid fa-gear"></i>
                    Manage Community
                </a>
            </div>
        @endif
    </div>
</div>

<nav class="sectionNav scrollNav">
    <a href="{{ route('communities.show', $community->slug) }}" class="communityTabItem {{ request()->routeIs('communities.show') || request()->routeIs('communities.index') ? 'active' : '' }}">Posts</a>
    <a href="{{ route('communities.about', $community->slug) }}" class="communityTabItem {{ request()->routeIs('communities.about') ? 'active' : '' }}">About</a>
</nav>