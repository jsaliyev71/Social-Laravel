
document.querySelectorAll('.autoSubmitForm').forEach(form => {
    form.addEventListener('change', function() {
        this.closest('form').submit();
    });
});






function openModal(section) {
    document.getElementById(section).classList.add('showModal');
}

function closeModal(section) {
    document.getElementById(section).classList.remove('showModal');
}