<div class="settingsHeader scrollNav">
    <h2>Community Settings</h2>

    <nav class="settingsNav scrollNav">
        <a href="{{ route('communities.manage.index', ['slug' => request()->route('slug')]) }}"
        class="settingsNavItem {{ request()->routeIs('communities.manage.index') ? 'active' : '' }}">
            General
        </a>

        <a href="{{ route('communities.manage.privacy', ['slug' => request()->route('slug')]) }}"
        class="settingsNavItem {{ request()->routeIs('communities.manage.privacy') ? 'active' : '' }}">
            Privacy
        </a>

        <a href="{{ route('communities.manage.sections.index', ['slug' => request()->route('slug')]) }}"
        class="settingsNavItem {{ request()->routeIs('communities.manage.sections.*') ? 'active' : '' }}">
            Sections
        </a>

        <a href="{{ route('communities.manage.members.index', ['slug' => request()->route('slug')]) }}"
        class="settingsNavItem {{ request()->routeIs('communities.manage.members.index') ? 'active' : '' }}">
            Members
        </a>

        <a href="{{ route('communities.manage.posts.index', ['slug' => request()->route('slug')]) }}"
        class="settingsNavItem {{ request()->routeIs('communities.manage.posts.index') ? 'active' : '' }}">
            Posts
        </a>

        <!-- <a href="" class="settingsNavItem">
            Roles
        </a> -->

        <!-- <a href="" class="settingsNavItem">
            Reports
        </a> -->
    </nav>
</div>