<div class="settingsHeader">
    <h2>Settings</h2>

    <nav class="settingsNav scrollNav">
        <a href="{{ route('settings.index') }}"
           class="settingsNavItem {{ request()->routeIs('settings.index') ? 'active' : '' }}">
            Profile
        </a>

        <a href="{{ route('settings.preferences') }}"
           class="settingsNavItem {{ request()->routeIs('settings.preferences') ? 'active' : '' }}">
            Preferences
        </a>

        <a href="{{ route('settings.privacy') }}"
           class="settingsNavItem {{ request()->routeIs('settings.privacy') ? 'active' : '' }}">
            Privacy
        </a>
    </nav>
</div>