<x-layout title="Community Sections">
    @include('layouts.aside')

    <main class="settingsPage">
        @include('pages.community.partials.settingNav')

        <section class="settingsContent">

        <div>
            <button type="button" onclick="openCreateSectionModal()" class="primaryBtn">Create Section</button>
        </div>

        <div id="sectionModal" class="settingsSection modalContainer">
            <div class="modal">
                <button type="button" onclick="closeModal('sectionModal')"><i class="fa-solid fa-xmark"></i></button>

                <h3 id="sectionModalTitle" class="sectionTitle">Create Section</h3>

                <form id="sectionForm" method="POST" action="" enctype="multipart/form-data" class="settingsContentForm">
                    @csrf
                    <input type="hidden" name="_method" id="sectionFormMethod" value="POST">

                    <div class="formGroup">
                        <label class="formLabel">Section Name</label>
                        <input id="sectionName" name="name" class="inputField" placeholder="Section name">
                    </div>

                    <div class="formGroup">
                        <label class="formLabel">Section Color</label>
                        <input id="sectionColor" name="color" type="color" class="colorField" value="#263558">
                    </div>

                    <div class="formGroup">
                        <label class="formLabel">Section Image</label>
                        <input id="sectionPic" name="section_pic" type="file" class="inputField fileField">
                    </div>

                    <div class="formGroup">
                        <label class="formLabel">Description</label>
                        <textarea id="sectionDescription" name="description" class="textareaField" placeholder="Section description"></textarea>
                    </div>

                    <button id="sectionSubmitBtn" class="primaryBtn">Create Section</button>
                </form>
            </div>
        </div>

            <div class="settingsSection">
                <h3 class="sectionTitle">Sections</h3>

                <div class="sectionList">
                    @forelse ($sections as $section)
                        <div class="sectionItem">
                            <div class="sectionMain">
                                @if($section->color)
                                    <span class="sectionColorDot" style="background: {{ $section->color }}"></span>
                                @endif

                                @if($section->section_pic)
                                    <img class="sectionThumb" src="{{ asset('storage/uploads/' . $section->section_pic) }}" alt="Section Image">
                                @endif

                                <div class="settingsInfo">
                                    <h3>{{ $section->name }}</h3>
                                    <p>{{ $section->description ?? 'No description' }}</p>
                                </div>
                            </div>

                            <div class="sectionActions">
                                <button type="button" class="optionBtn" onclick='openEditSectionModal(@json($section))'>
                                    Edit
                                </button>

                                <form method="POST" action="{{ route('communities.manage.sections.delete', ['slug' => $community->slug, 'section_id' => $section->id]) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="dangerBtn">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="emptyState">No sections created yet.</p>
                    @endforelse
                </div>
            </div>

        </section>
    </main>
</x-layout>


<script>
    function openCreateSectionModal() {
        const form = document.getElementById('sectionForm');

        form.action = "{{ route('communities.manage.sections.store', ['slug' => $community->slug]) }}";

        document.getElementById('sectionFormMethod').value = 'POST';
        document.getElementById('sectionModalTitle').innerText = 'Create Section';
        document.getElementById('sectionSubmitBtn').innerText = 'Create Section';

        document.getElementById('sectionName').value = '';
        document.getElementById('sectionColor').value = '#263558';
        document.getElementById('sectionPic').value = '';
        document.getElementById('sectionDescription').value = '';

        openModal('sectionModal');
    }

    function openEditSectionModal(section) {
        const form = document.getElementById('sectionForm');

        form.action = `/c/{{ $community->slug }}/manage/sections/${section.id}/update`;

        document.getElementById('sectionFormMethod').value = 'PATCH';
        document.getElementById('sectionModalTitle').innerText = 'Edit Section';
        document.getElementById('sectionSubmitBtn').innerText = 'Update Section';

        document.getElementById('sectionName').value = section.name ?? '';
        document.getElementById('sectionColor').value = section.color ?? '#263558';
        document.getElementById('sectionPic').value = '';
        document.getElementById('sectionDescription').value = section.description ?? '';

        openModal('sectionModal');
    }
</script>