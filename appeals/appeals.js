console.log(appeals);
const checkButtons = document.querySelectorAll(".reason-check");
checkButtons.forEach(btn=>{
    btn.addEventListener('click',displayPopup);
})
function displayPopup(event){
    const cardBlock = event.target.closest('.card');
    const attendanceId = parseInt(cardBlock.id.substring(13));
    document.getElementById("message-content").textContent = appeals[attendanceId]["appeal_message"];
    showPopup("message-popup");

}
setTimeout(()=>{
    base_link="../staff-event/";
},50)

// function hidePopup(){
//     overlay.style.display="none";
//     if (currentPopup){
//         currentPopup.style.display = "none";
//         currentPopup = null;
//     }
// }