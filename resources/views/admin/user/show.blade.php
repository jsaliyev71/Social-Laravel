<x-layout title="User Profile">
    @include('admin.layouts.aside')

    <main class="adminPage">

        <div class="adminHeader">
            <h2 class="adminTitle">User Profile</h2>

            <div class="adminActions">

                <a href="{{ route('cp.users.index') }}"
                   class="adminBtn adminBtnWarning">
                    Back
                </a>

                @if($user->is_banned)
                    <form method="POST" action="{{ route('cp.users.unban', $user->id) }}">
                        @csrf
                        @method('PATCH')
                        <button class="adminBtn adminBtnPrimary">Unban</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('cp.users.ban', $user->id) }}">
                        @csrf
                        @method('PATCH')
                        <button class="adminBtn adminBtnDanger">Ban</button>
                    </form>
                @endif

            </div>
        </div>

        <div class="adminDetailCard">

            <div class="adminProfileHeader">

                <img src="/storage/uploads/{{ $user->profile_pic }}"
                     class="adminProfileAvatar">

                <div>
                    <h3>{{ $user->username }}</h3>
                    <p class="adminMuted">{{ $user->display_name }}</p>
                </div>

            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Email</span>
                <span class="adminDetailValue">{{ $user->email }}</span>
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Gender</span>
                <span class="adminDetailValue">{{ $user->gender ?? 'Unknown' }}</span>
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Bio</span>
                <span class="adminDetailValue">{{ $user->bio ?? 'No bio' }}</span>
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Created At</span>
                <span class="adminDetailValue">{{ $user->created_at }}</span>
            </div>

            <div class="adminDetailRow">
                <span class="adminDetailLabel">Last Login</span>
                <span class="adminDetailValue">{{ $user->last_login_at ?? 'Never' }}</span>
            </div>

        </div>

        <div class="adminDangerZone">

            <form method="POST" action="{{ route('cp.users.delete', $user->id) }}">
                @csrf
                @method('DELETE')

                <button class="adminBtn adminBtnDanger">
                    Delete User
                </button>

            </form>

        </div>

    </main>
</x-layout>