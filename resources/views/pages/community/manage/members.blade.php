<x-layout title="Community Members">

    @include('layouts.aside')

    <main class="settingsPage">

        @include('pages.community.partials.settingNav')

        <div class="subNav">

            <a href="?tab=requests"
               class="subNavItem {{ request('tab', 'requests') === 'requests' ? 'active' : '' }}">
                Requests
            </a>

            <a href="?tab=members"
               class="subNavItem {{ request('tab') === 'members' ? 'active' : '' }}">
                Members
            </a>

            <a href="?tab=banned"
               class="subNavItem {{ request('tab') === 'banned' ? 'active' : '' }}">
                Banned
            </a>

        </div>

        <div class="communitiesList">

            @forelse($members as $member)

                <x-cardMember :member="$member">

                    <x-slot name="actions">

                        <div class="memberActions">

                            @if(request('tab', 'requests') === 'requests')

                                <button
                                    type="button"
                                    class="iconBtn acceptBtn js-fetch-action"
                                    data-url="{{ route('communities.manage.members.accept', ['slug' => request()->route('slug'), 'user_id' => $member->user_id]) }}"
                                    data-method="POST"
                                    data-behaviour="remove">

                                    <i class="fa-solid fa-check"></i>
                                </button>

                                <button
                                    type="button"
                                    class="iconBtn rejectBtn js-fetch-action"
                                    data-url="{{ route('communities.manage.members.reject', ['slug' => request()->route('slug'), 'user_id' => $member->user_id]) }}"
                                    data-method="POST"
                                    data-behaviour="remove">

                                    <i class="fa-solid fa-xmark"></i>
                                </button>

                                <button
                                    type="button"
                                    class="iconBtn banBtn js-fetch-action"
                                    data-url="{{ route('communities.manage.members.ban', ['slug' => request()->route('slug'), 'user_id' => $member->user_id]) }}"
                                    data-method="POST"
                                    data-behaviour="remove">

                                    <i class="fa-solid fa-ban"></i>
                                </button>

                            @endif

                            @if(request('tab') === 'members')

                                <button
                                    type="button"
                                    class="iconBtn removeBtn js-fetch-action"
                                    data-url="{{ route('communities.manage.members.remove', ['slug' => request()->route('slug'), 'user_id' => $member->user_id]) }}"
                                    data-method="POST"
                                    data-behaviour="remove">

                                    <i class="fa-solid fa-user-minus"></i>
                                </button>

                                <button
                                    type="button"
                                    class="iconBtn banBtn js-fetch-action"
                                    data-url="{{ route('communities.manage.members.ban', ['slug' => request()->route('slug'), 'user_id' => $member->user_id]) }}"
                                    data-method="POST"
                                    data-behaviour="remove">

                                    <i class="fa-solid fa-ban"></i>
                                </button>

                            @endif

                            @if(request('tab') === 'banned')

                                <button
                                    type="button"
                                    class="iconBtn removeBtn js-fetch-action"
                                    data-url="{{ route('communities.manage.members.unban', ['slug' => request()->route('slug'), 'user_id' => $member->user_id]) }}"
                                    data-method="POST"
                                    data-behaviour="remove">

                                    <i class="fa-solid fa-user-check"></i>
                                </button>

                            @endif

                        </div>

                    </x-slot>

                </x-cardMember>

            @empty

                <div class="emptyState">
                    No users found.
                </div>

            @endforelse

        </div>

    </main>

</x-layout>