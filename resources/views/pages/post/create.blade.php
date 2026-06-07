<x-layout title="Create Post">

    @include('layouts.aside')

    @php
        $type = request('type', 'text');

        $type = in_array($type, ['text', 'image'])
            ? $type
            : 'text';
    @endphp

    <main class="settingsPage">

        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data"
            class="settingsContentForm">

            @csrf

            <input type="hidden" name="post_type" id="postTypeInput" value="{{ $type }}">

            <div class="formGroup">
                <label class="formLabel">Community</label>

                <div class="customSelect" id="communitySelect">
                    <div class="customSelectTrigger">
                        Select community
                    </div>

                    <div class="customSelectDropdown" style="display:none;">
                        <div class="sectionList">

                            <div class="sectionItem selectOption" data-id="">
                                None
                            </div>

                            @foreach ($communities as $community)
                                <div class="sectionItem selectOption"
                                    data-id="{{ $community->id }}"
                                    data-name="{{ $community->slug }}"
                                    data-selected="{{ request()->route('slug') === $community->slug ? 'true' : 'false' }}">
                                    
                                    <div class="sectionMain">
                                            @if($community->profile_pic)
                                                <img class="sectionThumb" src="{{ asset('storage/uploads/' . $community->profile_pic) }}" alt="{{ $community->name }}">
                                            @else
                                                <span class="sectionThumb">{{ strtoupper(substr($community->name, 0, 1)) }}</span>
                                            @endif

                                        <div class="sectionTitle">
                                            {{ $community->slug }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <select name="section_id" id="sectionSelect" class="selectField">
                    <option value="">Select section</option>
                </select>

                <input type="hidden" name="community_id" id="communityInput">
            </div>

            <div class="settingsNav postTypeNav">
                <a type="button"
                    class="buttonReset settingsNavItem postTypeButton {{ $type === 'text' ? 'active' : '' }}"
                    data-type="textPost">
                    Text
                </a>
                <a type="button"
                    class="buttonReset settingsNavItem postTypeButton {{ $type === 'image' ? 'active' : '' }}"
                    data-type="imagePost">
                    Image
                </a>
            </div>

            <div class="formGroup">
                <label class="formLabel">Title</label>
                <input class="inputField" type="text" name="title" value="{{ old('title') }}">
            </div>

            <div id="textPost" style="{{ $type === 'text' ? '' : 'display:none;' }}">
                <div class="formGroup">
                    <label class="formLabel">Content</label>
                    <textarea name="content" class="textareaField" placeholder="What's on your mind?">{{ old('content') }}</textarea>
                </div>
            </div>

            <div id="imagePost" style="{{ $type === 'image' ? '' : 'display:none;' }}">
               <div class="formGroup">
                    <label class="formLabel">Media</label>

                    <div id="mediaList" class="mediaList"></div>

                    <button type="button" id="addMediaBtn" class="optionBtn">
                        + Add Media
                    </button>

                    <input type="file" name="media[]" id="mediaInput" accept="image/*,video/*" multiple hidden>
                </div>

            </div>

            <div class="switchRow">
                <span>Enable comments</span>

                <label class="switch">
                    <input type="checkbox" name="comments_enabled" checked>
                    <span class="slider"></span>
                </label>
            </div>

            <div class="switchRow">
                <span>Mark as sensitive</span>

                <label class="switch">
                    <input type="checkbox" name="is_sensitive">
                    <span class="slider"></span>
                </label>
            </div>

            <button type="submit" class="primaryBtn">
                Post
            </button>

        </form>

    </main>
</x-layout>

<script src="{{ asset('js/components/postHandle.js') }}"></script>
<script src="{{ asset('js/components/mediaUpload.js') }}"></script>
