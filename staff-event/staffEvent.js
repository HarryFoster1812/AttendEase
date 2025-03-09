const users = Array.from(document.getElementsByClassName("card"));
const selected_count = document.getElementById("selected_count");

var selected_users = [];

const timeslot_id = 50;

function toggleSelection(elementClicked){
    if(elementClicked.classList.contains("selectedUser")){
        let index = selected_users.indexOf(elementClicked);
        if (index > -1) { // only splice array when item is found
            selected_users.splice(index, 1); // 2nd parameter means remove one item only
        }
        elementClicked.classList.remove("selectedUser");
        let newVal = selected_count.innerText = Number(selected_count.innerText)-1;

        selected_count.innerText = newVal;
    }
    else{
        elementClicked.classList.add("selectedUser");
        selected_users.push(elementClicked);
        let newVal = Number(selected_count.innerText)+1;

        selected_count.innerText = newVal;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    users.forEach(element => {
        element.addEventListener("click", function(){toggleSelection(element)});    
    });
});

// get timeslot  information on document load



// #################### buttons ####################
// left
const attend_btn = document.getElementById("attend-btn");
const remove_btn = document.getElementById("remove-btn");
const deselect_btn = document.getElementById("deselect-btn");
const select_btn = document.getElementById("select-btn");


deselect_btn.addEventListener("click", () => {
    users.forEach((element) =>{
        if(selected_users.indexOf(element) > -1){
           toggleSelection(element); 
        }
    });
});



select_btn.addEventListener("click", () => {
    users.forEach(element => {
        if(selected_users.indexOf(element) == -1){
           toggleSelection(element); 
        }
    });
});



// center
const codeButton = document.getElementById("codeShow");
const code_text = document.getElementById("class-code");

codeButton.addEventListener("click", startCodePopup);

var closeBtn = document.getElementById('close-code-btn');
var countdownNumberEl = document.getElementById('countdown-number');
var circle = document.getElementById('circle');
var countdown = 60;
var countdownTimer;
countdownNumberEl.textContent = countdown;


function startCodePopup(event){
    // get the current code
    // create the timer and start the countdown circle_animation
    // create a timeout to get new code
    overlay.style.display="flex";
    code_popup.style.display = "flex";

    getNewCode();

    var now = new Date();
    countdown = (60 - now.getSeconds());
    updateCountDown();

    countdownTimer = setInterval(updateCountDown, 1000);

}

function updateCountDown(){
    countdown = --countdown <= 0 ? 60 : countdown;
    if(countdown == 60){
        getNewCode();
    }
    circle.style.strokeDashoffset = `${113*(1-countdown/60)}px`;
    countdownNumberEl.textContent = countdown;
}

function endCodePopup(){
    clearInterval(countdownTimer);
    code_popup.style.display = "none";
    overlay.style.display = "none";
}

function getNewCode(){
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // update the calendar
            try{
                code_text.innerText = this.responseText;
            }
            catch(e){
                // display error message
                // document.write ?
                console.error(e, e.stack);
            }
        }
        else if (this.status==400){
            // display a error message to the user since it was generated by the php
            console.log(this.responseText);
        }
    };

    xmlhttp.open("POST", "./get-code.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("id="+timeslot_id);
}

closeBtn.addEventListener("click", ()=>{
    endCodePopup();
});

// right
const editButton = document.getElementById("edit-info");
const deleteButton = document.getElementById("del-event");

const overlay = document.getElementById("overlay");
const code_popup = document.getElementById("code-popup");

