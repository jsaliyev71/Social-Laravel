<div class="asideContainer">
    <button onclick="asideToggle()" class="asideToggle asideLeft">
        <i class="fa-solid fa-bars"></i>
    </button>
    <aside>
        <nav class="asideNav">
            <div class="navItem">
                <a href="{{ route('home.index') }}">
                    <i class="fa-regular fa-house"></i>
                    <span>Home</span>
                </a>
            </div>

            <div class="navItem">
                <a href="{{ route('communities.index') }}">
                    <i class="fa-regular fa-compass"></i>
                    <span>Communities</span>
                </a>
            </div>

            <div class="navItem">
                <a href="{{ route('people.index') }}">
                    <i class="fa-regular fa-user"></i>
                    <span>People</span>
                </a>
            </div>

            <!-- <div class="navItem">
                <a href="{{ route('posts.index') }}">
                    <i class="fa-regular fa-newspaper"></i>
                    <span>Posts</span>
                </a>
            </div> -->

            <div class="navItem">
                <a href="{{ request()->route('slug') ? route('communities.post.create', ['slug' => request()->route('slug')]) : route('posts.create') }}">
                    <i class="fa-regular fa-square-plus"></i>
                    <span>Create</span>
                </a>
            </div>

            @superadmin
            <div class="navItem adminItem">
                <a href="{{ route('cp.dashboard') }}">
                    <i class="fa-solid fa-user-tie"></i>
                    <span>Admin Dashboard</span>
                </a>
            </div>
            @endsuperadmin

        </nav>

    </aside>
</div>

<div class="asidePlaceholder"></div>

<script src="{{ asset('js/components/aside.js') }}" defer></script>


