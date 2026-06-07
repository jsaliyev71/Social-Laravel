@props(['community'])

<a href="{{ route('communities.show', ['slug' => $community->slug]) }}" class="communityCard">
    <div class="profilePic cardProfile">
        @if($community->profile_pic)
            <img src="{{ asset('storage/uploads/' . $community->profile_pic) }}" alt="{{ $community->name }}">
        @else
            <img class="" src="{{ asset('storage/img/profile_placeholder_community.webp') }}" alt="">
        @endif
    </div>

    <div class="cardContent">
        <div class="cardNameHeader">
            <div class="cardName">
            {{ $community->name }}
            </div>

            @if (isset($status))
                {{ $status }}
            @endif
        
        </div>
        @if(isset($visibility))
            {{ $visibility }}
        @endif

        @if($community->description ?? false)
            <p class="cardDescription">
                {{ Str::limit($community->description, 40) }}
            </p>
        @endif
        <br>
        
        <p class="cardDate">
            members: {{ $community->members_count }}
        </p>
    </div>   

    <div>
        @if(auth()->check() && $community->owner_user_id !== auth()->id())

            @php
                $status = $community->myMembership->status ?? 'none';

                $action = match($status) {
                    'active' => 'unfollow',
                    'request' => 'unfollow',
                    default => 'follow',
                };
            @endphp

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

        @endif
    </div>
</a>