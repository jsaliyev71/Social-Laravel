<x-layout title="Dashboard">
    @include('admin.layouts.aside')

    <main class="adminPage">

        <div class="adminHeader">
            <h2 class="adminTitle">Dashboard</h2>
        </div>

        <div class="adminStatsGrid">

            <div class="adminStatCard">
                <div class="adminStatTitle">Users</div>
                <div class="adminStatValue">{{ $usersCount ?? 0 }}</div>
            </div>

            <div class="adminStatCard">
                <div class="adminStatTitle">Communities</div>
                <div class="adminStatValue">{{ $communitiesCount ?? 0 }}</div>
            </div>

            <div class="adminStatCard">
                <div class="adminStatTitle">Categories</div>
                <div class="adminStatValue">{{ $categoriesCount ?? 0 }}</div>
            </div>

            <div class="adminStatCard">
                <div class="adminStatTitle">Posts</div>
                <div class="adminStatValue">{{ $postsCount ?? 0 }}</div>
            </div>

            <div class="adminStatCard">
                <div class="adminStatTitle">Comments</div>
                <div class="adminStatValue">{{ $commentsCount ?? 0 }}</div>
            </div>

        </div>

    </main>
</x-layout>