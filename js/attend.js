const popup = document.querySelector('.attend-popup');
const closeBtn = document.querySelector('.attend-close-icon');
const locButton = document.getElementById('loc-button');
const codeButton = document.getElementById('code-button');
const codeForm = document.getElementById('code-block');
const codeImage = document.getElementById('attend-image');
const backdrop = document.querySelector(".attend-backdrop");
const cancelButton = document.querySelector(".attendance-control .btn-light");
const acceptButton = document.querySelector(".attendance-control .btn-success");
function showPopup() {
    popup.classList.add('show');
}

function hidePopup() {
    popup.classList.remove('show');
    toggleAttend();
}
function toggleAttend(){
    backdrop.classList.toggle('d-none');
    backdrop.classList.toggle('d-flex');
    if(backdrop.classList.contains('d-flex')){
        showPopup();
    }
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
async function getUserLoc(event){
    event.target.disabled = true;
    try{
        const positionData = await new Promise((resolve,reject)=>{navigator.geolocation.getCurrentPosition(resolve,reject)});
        console.log(positionData);
    }
    catch(error){
        console.log("Error getting location",error)
    }
    event.target.disabled = false;
}
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(showPopup, 50);
});

closeBtn.addEventListener('click', hidePopup);
codeButton.addEventListener('click', openCode);
locButton.addEventListener('click', openLoc);
cancelButton.addEventListener('click',hidePopup);
acceptButton.addEventListener('click',getUserLoc);