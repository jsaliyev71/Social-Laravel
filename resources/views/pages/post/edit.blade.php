<x-layout title="Create Post">

    @include('layouts.aside')

    <main class="settingsPage">

        <form method="POST" action="{{ route('posts.update', ['post_id' => $post->id]) }}" enctype="multipart/form-data"
            class="settingsContentForm">

            @csrf
            @method('PATCH')

            @if($sections)
                <div class="formGroup">
                    <select name="section_id" id="sectionSelect" class="selectField">
                        <option value="" selected disabled>Select section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}" {{ $section->id === $post->section_id ? 'selected' : '' }}>{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="formGroup">
                <label class="formLabel">Title</label>
                <input class="inputField" type="text" name="title" value="{{ $post->title }}">
            </div>

            @if($post->post_type === 'text')
                <div id="textPost" style="">
                    <div class="formGroup">
                        <label class="formLabel">Content</label>
                        <textarea name="content" class="textareaField">
                            {{ $post->content }}
                        </textarea>
                    </div>
                </div>
            @endif

            @if($post->post_type === 'image')
                <div id="imagePost" style="">
                    <div class="formGroup">
                        <label class="formLabel">Media</label>

                        <div id="mediaList" class="mediaList"></div>

                        <button type="button" id="addMediaBtn" class="optionBtn">
                            + Add Media
                        </button>

                        <input type="file" name="media[]" id="mediaInput" accept="image/*,video/*" multiple hidden>
                        
                        <div id="deletedContainer"></div>
                    </div>

                    <div class="formGroup">
                        <label class="formLabel">Text</label>
                        <textarea name="description" class="textareaField" placeholder="What's on your mind?">{{ $post->description }}</textarea>
                    </div>
                </div>
            @endif

            <div class="switchRow">
                <span>Enable comments</span>

                <label class="switch">
                    <input type="checkbox" name="comments_enabled" {{ $post->comments_enabled ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>

            <div class="switchRow">
                <span>Mark as sensitive</span>

                <label class="switch">
                    <input type="checkbox" name="is_sensitive" {{ $post->is_sensitive ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>

            <button type="submit" class="primaryBtn">
                Post
            </button>

        </form>

    </main>
</x-layout>

<script>
    const existingMedia = @json($post->media);
</script>

<script src="{{ asset('js/components/mediaUpload.js') }}"></script>
