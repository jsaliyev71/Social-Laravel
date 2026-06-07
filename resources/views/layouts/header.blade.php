<header>
    <div id="header">

        <button onclick="asideToggle()" class="asideToggle asideHeader">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div id="logo">
            Social
        </div>

        <form class="headerSearch" method="GET" action="{{ route('search.index') }}">
            <input name="search" placeholder="Search..." value="{{ request('search') }}" type="text">
            <input type="hidden" name="type" value="{{ request('type', 'all') }}">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>

        <div class="headerRight">
            @guest
                <div class="headerLogin">
                    <a href="{{ route('auth.login.index') }}">Log In</a>
                </div>
            @endguest

            @auth
                <div class="dropdownContainer profileDropdown">
                    <button type="button" class="profilePic profileUser buttonReset dropdown-btn">
                        @if(auth()->user()->profile_pic)
                            <img src="{{ asset('storage/uploads/' . auth()->user()->profile_pic) }}" alt="Profile Pic">
                        @else
                            <span>{{ strtoupper(substr(auth()->user()->username, 0, 1)) }}</span>
                        @endif
                    </button>

                    <div class="dropdownMenu">
                        <div class="dropdownItem">
                            <a href="{{ route('profile.show', ['username' => auth()->user()->username]) }}">
                                <i class="fa-regular fa-user"></i>
                                <span>View Profile</span>
                            </a>
                        </div>
                        <div class="dropdownItem">
                            <a href="{{ route('settings.index', ['username' => auth()->user()->username]) }}">
                                <i class="fa-solid fa-gears"></i>
                                <span>Settings</span>
                            </a>
                        </div>
                        <form class="dropdownItem" method="POST" action="{{ route('auth.logout') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="buttonReset">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span>Log Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>