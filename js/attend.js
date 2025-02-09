const popup = document.querySelector('.attend-popup');
const closeBtn = document.querySelector('.attend-close-icon');
const locButton = document.getElementById('loc-button');
const codeButton = document.getElementById('code-button');
const codeForm = document.getElementById('code-block');
const codeImage = document.getElementById('attend-image')

function showPopup() {
    popup.classList.add('show');
}

function hidePopup() {
    popup.classList.remove('show');
}

function openCode(){
    codeForm.classList.remove('d-none');
    codeImage.classList.add('d-none');
    locButton.classList.remove('btn-secondary');
    locButton.classList.add('btn-light');
    codeButton.classList.add('btn-secondary');
    codeButton.classList.remove('btn-light');
}
function openLoc(){
    codeForm.classList.add('d-none');
    codeImage.classList.remove('d-none');
    locButton.classList.add('btn-secondary');
    locButton.classList.remove('btn-light');
    codeButton.classList.remove('btn-secondary');
    codeButton.classList.add('btn-light');
}

document.addEventListener('DOMContentLoaded', function () {
    setTimeout(showPopup, 50);
});

closeBtn.addEventListener('click', hidePopup);
codeButton.addEventListener('click', openCode);
locButton.addEventListener('click', openLoc);