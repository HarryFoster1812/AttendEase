const popup = document.querySelector('.attend-popup');
const closeBtn = document.querySelector('.attend-close-icon');
const locButton = document.getElementById('loc-button');
const codeButton = document.getElementById('code-button');
const codeForm = document.getElementById('code-block');
const codeImage = document.getElementById('attend-image');
const backdrop = document.querySelector(".attend-backdrop");
const cancelButton = document.querySelector(".attendance-control .btn-light");
const acceptButton = document.querySelector(".attendance-control .btn-success");

const uncertaintyLat = 0.000180;
const uncertaintyLong = 0.000255;
let calculateNav = false;
function showPopup() {
    popup.classList.add('show');
}

function hidePopup() {
    if(calculateNav){
        return
    }
    popup.classList.remove('show');
    toggleAttend(null);
}
let json_loc;
document.addEventListener('DOMContentLoaded', async function(){
    try {
        const response = await fetch('../dashboard/get-location-data.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = await response.text();
        json_loc = JSON.parse(data);
        
    } catch (error) {
        console.error('Error fetching locations:', error);
    }
})
function toggleAttend(block){
    console.log("ifj")
    if(block){
        console.log(block);
        const instructor = block.dataset.aeName;
        const location = block.querySelector('.class-venue h4').textContent;
        const classCode = block.querySelector('.class-code h4').textContent;
        const classTime = block.querySelector('.class-time h4').textContent;
        document.querySelector('.attend-class-code .attend-details-content').textContent = classCode;
        document.querySelector('.attend-class-time .attend-details-content').textContent = classTime;
        document.querySelector('.attend-class-loc .attend-details-content').textContent = location;
        document.querySelector('.attend-class-instructor .attend-details-content').textContent = instructor;
        acceptButton.dataset.aeTimeslot = block.dataset.aeTimeslot;
        acceptButton.dataset.aeUser = block.dataset.aeUser;
    }
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
    cancelButton.disabled = true;
    calculateNav = true
    const loc = event.target.closest(".container").querySelector('.attend-class-loc .attend-details-content').textContent;
    try{
        const positionData = await new Promise((resolve,reject)=>{navigator.geolocation.getCurrentPosition(resolve,reject)});
        compareLocData(positionData.coords.latitude,positionData.coords.longitude, loc);
    }
    catch(error){
        console.log("Error getting location",error)
    }
    calculateNav = false;
    event.target.disabled = false;
    cancelButton.disabled = false;
}
function compareLocData(lat,long, loc){
    console.log(lat,long)
    
    const loc_map = new Map([["Stopford_TH 1",1],["Nancy Rothwell_3A.078 M&T",2],["Crawford House_TH 1",3],["Kilburn_IT407",4],["Kilburn_G23",5],["Oddfellows Hall_G.010",6],["Kilburn_Tootill (0 + 1)",7],["Simon_TH E",8]])
    const building_data = json_loc[loc_map.get(loc)-1]
    console.log(building_data)
    console.log(building_data.latitude);
    if(parseFloat(building_data.latitude)-uncertaintyLat<=lat && lat<=parseFloat(building_data.latitude)+uncertaintyLat && parseFloat(building_data.longitude)-uncertaintyLong<=long && long <=parseFloat(building_data.longitude)+uncertaintyLong){
        const succBox = document.getElementById('nav-success');
        let succDOM = document.importNode(succBox,true).content;
        document.body.append(succDOM);
        succDOM = document.body.lastElementChild;
        const removeSucc = setTimeout(()=>{
            succDOM.remove()
        },4000);
        calculateNav = false;
        hidePopup();
        const userID = parseInt(acceptButton.dataset.aeUser);
        const timeslotID = parseInt(acceptButton.dataset.aeTimeslot);
        publishAttendance(userID, timeslotID);
    }
    else{
        const failBox = document.getElementById('nav-fail');
        let failDOM = document.importNode(failBox,true).content;
        document.body.append(failDOM);
        failDOM = document.body.lastElementChild;
        const removeFail = setTimeout(()=>{
            failDOM.remove()
        },3500)
    }
}
const publishAttendance = (userID, timeslotID) => {         //Use the TimeSlotID and UserID to update the attendance to the database
    const data = { userid: userID, timeslotid: timeslotID };
    console.log(JSON.stringify(data))
    fetch("../dashboard/set-attendance-data.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
    .then(response => response.text())  // Get response from PHP
    .then(result => console.log(result))
    .catch(error => console.error("Error:", error));

}
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(showPopup, 50);
});

closeBtn.addEventListener('click', hidePopup);
codeButton.addEventListener('click', openCode);
locButton.addEventListener('click', openLoc);
cancelButton.addEventListener('click',hidePopup);
acceptButton.addEventListener('click',getUserLoc);