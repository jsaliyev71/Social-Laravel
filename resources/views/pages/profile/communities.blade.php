<x-layout title="{{ $user->username }}">

    @include('layouts.aside')

    <main class="profilePage">

        @include('pages.profile.partials.nav')

        @if(($user_status ?? null) === 'private')
            <p class="cardDescription">Private profile.</p>
        @else
            <div class="profileContent">
                @if($communities->isNotEmpty())
                    <div class="communitiesList">
                        @foreach($communities as $community) 
                            <x-cardCommunity :community="$community"> 
                                <x-slot name="visibility">
                                    @if(auth()->check() && $community->owner_user_id === auth()->id())
                                        <span class="communityStatus">
                                            {{ ucfirst($community->visibility) }}
                                        </span>
                                    @endif
                                </x-slot>
                                <x-slot name="status">
                                    @if($community->status !== 'active')
                                        <span class="postStatus postStatus_{{ $community->status }}">{{ $community->status }}</span> 
                                    @endif
                                </x-slot>
                            </x-cardCommunity>
                        @endforeach 
                    </div>
                @else
                    <div class="emptyState">
                        No communities yet.
                    </div>
                @endif

            </div>
        @endif

    </main>
</x-layout>