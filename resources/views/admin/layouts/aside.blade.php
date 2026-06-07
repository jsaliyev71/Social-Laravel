<div class="asideContainer">

    <button onclick="asideToggle()" class="asideToggle asideLeft">
        <i class="fa-solid fa-bars"></i>
    </button>

    <aside class="adminAside">

        <div class="asideHeader adminHeader">
            <h3>Admin Panel</h3>
        </div>

        <nav class="asideNav">
            <div class="navItem">
                <a href="{{ route('cp.dashboard') }}">
                    <i class="fa-regular fa-chart-bar"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="navItem">
                <a href="{{ route('cp.categories.index') }}">
                    <i class="fa-regular fa-folder"></i>
                    <span>Categories</span>
                </a>
            </div>

            <div class="navItem">
                <a href="{{ route('cp.communities.index') }}">
                    <i class="fa-regular fa-compass"></i>
                    <span>Communities</span>
                </a>
            </div>

            <div class="navItem">
                <a href="{{ route('cp.users.index') }}">
                    <i class="fa-regular fa-user"></i>
                    <span>Users</span>
                </a>
            </div>

            <div class="navItem">
                <a href="#">
                    <i class="fa-regular fa-newspaper"></i>
                    <span>Posts</span>
                </a>
            </div>

            <!-- <div class="navItem">
                <a href="#">
                    <i class="fa-regular fa-id-badge"></i>
                    <span>Roles</span>
                </a>
            </div> -->

            <!-- <div class="navItem">
                <a href="#">
                    <i class="fa-regular fa-id-badge"></i>
                    <span>Reports</span>
                </a>
            </div> -->
        </nav>

        <div class="adminBottom">
            <nav class="asideNav">
                <div class="navItem">
                    <a href="{{ route('home.index') }}">
                        <i class="fa-regular fa-house"></i>
                        <span>Back To Home</span>
                    </a>
                </div>
            </nav>
        </div>

    </aside>
</div>

<div class="asidePlaceholder"></div>

<script src="{{ asset('js/components/aside.js') }}" defer></script>