@props(['user'])

<a href="{{ route('profile.show', ['username' => $user->username]) }}" class="communityCard">
    <div class="profilePic cardProfile">
        @if($user->profile_pic)
            <img src="{{ asset('storage/uploads/' . $user->profile_pic) }}" alt="{{ $user->display_name }}">
        @else
            <img class="postImage" src="{{ asset('storage/img/profile_img_for_emtpy_things.png') }}" alt="">
        @endif
    </div>

    <div class="cardContent">
        <div class="cardName">
           {{ $user->username }}
        </div>

        @if($user->bio ?? false)
            <p class="cardDescription">
                {{ Str::limit($user->bio, 40) }}
            </p>
        @endif
    </div>
</a>
