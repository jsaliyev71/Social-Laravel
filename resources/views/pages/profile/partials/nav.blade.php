<section class="profileHeader">
    <div class="profileBanner">
        @if($user->banner_img)
            <img src="{{ asset('storage/uploads/' . $user->banner_img) }}" alt="Banner">
        @endif
    </div>

    <div class="profileInfo">
        <div class="profileAvatar">
            @if($user->profile_pic)
                <img src="{{ asset('storage/uploads/' . $user->profile_pic) }}" alt="Profile">
            @else
                <span>{{ strtoupper(substr($user->username, 0, 1)) }}</span>
            @endif
        </div>

        <div class="profileText">
            <h1>{{ $user->display_name ?? $user->username }}</h1>
            <a href="{{ route('profile.show', ['username' => $user->username]) }}">u/{{ $user->username }}</a>
        </div>

        @auth
            @if(auth()->id() === $user->id)
                <div>
                    <a href="{{ route('settings.index') }}" class="profileEditBtn">Edit Profile</a>
                </div>
            @endif
        @endauth
    </div>
</section>

@php
    $username = $user->username;
@endphp

<nav class="sectionNav scrollNav">
    <a href="{{ route('profile.show', $username) }}"
       class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">
        Posts
    </a>

    <a href="{{ route('profile.comments', $username) }}"
       class="{{ request()->routeIs('profile.comments') ? 'active' : '' }}">
        Comments
    </a>

    <a href="{{ route('profile.communities', $username) }}"
       class="{{ request()->routeIs('profile.communities') ? 'active' : '' }}">
        Communities
    </a>

    <a href="{{ route('profile.about', $username) }}"
       class="{{ request()->routeIs('profile.about') ? 'active' : '' }}">
        About
    </a>

    @php
        $username = $user->username;
    @endphp

    @if(auth()->check() && auth()->id() === $user->id)

        <a href="{{ route('profile.saved', $username) }}"
        class="{{ request()->routeIs('profile.saved') ? 'active' : '' }}">
            Saved
        </a>

        <a href="{{ route('profile.hidden', $username) }}"
        class="{{ request()->routeIs('profile.hidden') ? 'active' : '' }}">
            Hidden
        </a>

        <a href="{{ route('profile.history', $username) }}"
        class="{{ request()->routeIs('profile.history') ? 'active' : '' }}">
            History
        </a>

        <a href="{{ route('profile.reacted', $username) }}"
        class="{{ request()->routeIs('profile.reacted') ? 'active' : '' }}">
            Reacted
        </a>

    @endif
</nav>