const aside = document.querySelector('.asideContainer');
const asideP = document.querySelector('.asidePlaceholder');

function asideToggle() {
    aside.classList.toggle('toggleAside');
    asideP.classList.toggle('asideWidth');
}