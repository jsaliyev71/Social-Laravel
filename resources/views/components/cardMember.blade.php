@props(['member'])

<div class="removeCard">
    <a href="{{ route('profile.show', ['username' => $member->user->username]) }}" class="communityCard">
        <div class="profilePic cardProfile">
            @if($member->user->profile_pic)
                <img src="{{ asset('storage/uploads/' . $member->user->profile_pic) }}" alt="{{ $member->user->display_name }}">
            @else
                <img class="" src="{{ asset('storage/img/profile_img_for_emtpy_things.png') }}" alt="">
            @endif
        </div>

        <div class="cardContent">
            <div class="cardName">
            {{ $member->user->username }}
            </div>
            <span class="cardDate">
                {{  ($member->published_at ?? $member->created_at)->diffForHumans() }}
            </span>
        </div>

        @if(isset($actions))
            <div class="memberActions">
                {{ $actions }}
            </div>
        @endif
        
    </a>
</div>