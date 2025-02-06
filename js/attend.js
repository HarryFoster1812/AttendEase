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

function toggleMode(){
    codeForm.classList.toggle('d-none');
    codeImage.classList.toggle('d-none');
    locButton.classList.toggle('btn-secondary');
    locButton.classList.toggle('btn-light');
    codeButton.classList.toggle('btn-secondary');
    codeButton.classList.toggle('btn-light');
}

document.addEventListener('DOMContentLoaded', function () {
    setTimeout(showPopup, 50);
});

closeBtn.addEventListener('click', hidePopup);
codeButton.addEventListener('click', toggleMode);
locButton.addEventListener('click', toggleMode);