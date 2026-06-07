



// Community Loading
window.addEventListener('DOMContentLoaded', () => {

    const selected = document.querySelector(
        '.selectOption[data-selected="true"]'
    );

    if (selected) {
        selected.click();
    }
});




// Fake Select
const buttons = document.querySelectorAll('.postTypeButton');

if(buttons) {
    buttons.forEach(btn => {
        btn.addEventListener('click', () => {

            const type = btn.dataset.type;

            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            document.getElementById('textPost').style.display =
                type === 'textPost' ? 'block' : 'none';

            document.getElementById('imagePost').style.display =
                type === 'imagePost' ? 'block' : 'none';

            document.getElementById('postTypeInput').value =
                type === 'imagePost'
                    ? 'image'
                    : 'text';
        });
    });
}




// Select Ajax
const select = document.getElementById('communitySelect');
const trigger = select.querySelector('.customSelectTrigger');
const dropdown = select.querySelector('.customSelectDropdown');
const input = document.getElementById('communityInput');

if(select && trigger && dropdown && input) {
    trigger.addEventListener('click', () => {
        dropdown.style.display =
            dropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.querySelectorAll('.selectOption').forEach(option => {
        option.addEventListener('click', async () => {

            const id = option.dataset.id;
            input.value = id;
            trigger.innerHTML = option.innerHTML;

            dropdown.style.display = 'none';

            if (id) {
                const res = await fetch(`/ajax/${id}/sections`);
                const data = await res.json();

                renderSections(data);
            } else {
                renderSections([]);
            }
        });
    });

    document.addEventListener('click', (e) => {
        if (!select.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });    

    function renderSections(sections) {
        const select = document.getElementById('sectionSelect');

        select.innerHTML = '<option value="">Select section</option>';

        sections.forEach(sec => {
            const option = document.createElement('option');

            option.value = sec.id;
            option.textContent = sec.name;

            select.appendChild(option);
        });
    }
}
