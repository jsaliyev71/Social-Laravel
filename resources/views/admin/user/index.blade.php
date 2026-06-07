<x-layout title="Users">
    @include('admin.layouts.aside')

    <main class="adminPage">

        <div class="adminHeader">
            <h2 class="adminTitle">Users</h2>
        </div>

        <div class="adminTableWrapper">

            <table class="adminTable">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr>

                            <td class="adminTableCell">{{ $user->id }}</td>

                            <td class="adminTableCell">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <img src="/storage/uploads/{{ $user->profile_pic }}"
                                         style="width:35px;height:35px;border-radius:50%;object-fit:cover;">

                                    <div>
                                        <div>{{ $user->username }}</div>
                                        <div style="font-size:12px;color:var(--muted);">
                                            {{ $user->display_name }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="adminTableCell">{{ $user->email }}</td>

                            <td class="adminTableCell">
                                @if($user->is_banned)
                                    <span class="adminBadge" style="background:var(--delete);color:white;">
                                        Banned
                                    </span>
                                @else
                                    <span class="adminBadge">
                                        Active
                                    </span>
                                @endif
                            </td>

                            <td class="adminTableCell">
                                {{ $user->last_login_at ?? 'Never' }}
                            </td>

                            <td class="adminTableCell adminActions">

                                <a href="{{ route('cp.users.show', $user->id) }}"
                                   class="adminBtn adminBtnPrimary">
                                    View
                                </a>

                                @if($user->is_banned)
                                    <form method="POST" action="{{ route('cp.users.unban', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="adminBtn adminBtnWarning">Unban</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('cp.users.ban', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="adminBtn adminBtnDanger">Ban</button>
                                    </form>
                                @endif

                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="adminEmpty">No users found.</td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </main>
</x-layout>