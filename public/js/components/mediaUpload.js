
// Media Upload Files

const mediaInput = document.getElementById('mediaInput');
const addBtn = document.getElementById('addMediaBtn');
const mediaList = document.getElementById('mediaList');

if(mediaInput && addBtn && mediaList) {
    
    let deletedMediaIds = [];
    let existingData = [];
    let mediaData = [];

    if (typeof existingMedia !== 'undefined' && existingMedia.length) {
        existingData = [...existingMedia];

        renderPreview();
    }

    addBtn.addEventListener('click', () => {
        mediaInput.click();
    });

    mediaInput.addEventListener('change', () => {
        console.log('jalala');
        addMediaData();
        syncInput();
        renderPreview();
    });

    function addMediaData() {
        mediaData.push(...Array.from(this.mediaInput.files));
        mediaInput.value = "";    
    }

    function renderPreview() {
        mediaList.innerHTML = "";

        if (typeof existingData !== 'undefined' && existingData.length) {

            existingData.forEach((media, index) => {

                const wrapper = document.createElement('div');
                wrapper.className = 'mediaItem';

                let el;

                const url = `/storage/uploads/${media.file_url}`;

                if (media.media_type === 'image') {
                    el = document.createElement('img');
                } else {
                    el = document.createElement('video');
                    el.controls = true;
                }

                el.classList.add('postMediaItem');

                el.src = url;

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.innerText = '✕';
                    removeBtn.classList.add('removeMediaBtn');

                    removeBtn.onclick = () => {
                        removeExistingFile(index);
                    };

                    wrapper.appendChild(el);
                    wrapper.appendChild(removeBtn);

                    mediaList.appendChild(wrapper);
                });
        }

        Array.from(mediaData).forEach((file, index) => {
            const url = URL.createObjectURL(file);

            const wrapper = document.createElement('div');
            wrapper.className = 'mediaItem';

            let el;

            if (file.type.startsWith('image')) {
                el = document.createElement('img');
            } else {
                el = document.createElement('video');
                el.controls = true;
            }

            el.classList.add('postMediaItem');

            el.src = url;

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.innerText = '✕';
            removeBtn.classList.add('removeMediaBtn');

            removeBtn.onclick = () => {
                removeFile(index);
            };

            wrapper.appendChild(el);
            wrapper.appendChild(removeBtn);

            mediaList.appendChild(wrapper);
        });
    }

    function removeFile(index) {
        mediaData = mediaData.filter((_, i) => i !== index);
        syncInput();
        renderPreview();
    }

    function removeExistingFile(index) {
        const item = existingData[index];

        deletedMediaIds.push(item.id);

        existingData.splice(index, 1);

        syncDeletedInput();
        renderPreview();
    }

    function syncInput() {
        const dt = new DataTransfer();
        mediaData.forEach(file => dt.items.add(file));

        mediaInput.files = dt.files;
    }

    function syncDeletedInput() {
        const container = document.getElementById('deletedContainer');

        container.innerHTML = '';

        deletedMediaIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleted_media_ids[]';
            input.value = id;

            container.appendChild(input);
        });
    }
}