const users = Array.from(document.getElementsByClassName("card"));
const selected_count = document.getElementById("selected_count");
const cancelBtns = Array.from(document.getElementsByClassName("cancel"));

var selected_users = [];

const timeslot_id = document.body.dataset.timeslotid;

var currentPopup = null;

function showError(title, message){
    const failBox = document.getElementById('nav-fail');
    let failDOM = document.importNode(failBox,true).content;
    failDOM.getElementById("title").innerText = title;
    failDOM.getElementById("message").innerText = message;
    document.body.append(failDOM);
    failDOM = document.body.lastElementChild;
    const removeFail = setTimeout(()=>{
        failDOM.remove()
    },3500);
}

function showPopup(id){
    currentPopup = document.getElementById(id);
    overlay.style.display="flex";
    currentPopup.style.display = "flex";

}

function hidePopup(){
    overlay.style.display="none";
    if (currentPopup){
        currentPopup.style.display = "none";
        currentPopup = null;
    }
}

function toggleSelection(elementClicked, cardDiv){

    if (elementClicked){
        const buttonTags = ["BUTTON", "I"];
        if(buttonTags.includes(elementClicked.target.tagName)){
            elementClicked = elementClicked.target;
            if(elementClicked.tagName == "I"){
                elementClicked = elementClicked.parentElement; 
            }  

            sendNewStatus([Number(cardDiv.dataset.userId)], elementClicked.id, [cardDiv]);
            return;
        }
    }

    if(cardDiv.classList.contains("selectedUser")){
        let index = selected_users.indexOf(cardDiv);
        if (index > -1) { // only splice array when item is found
            selected_users.splice(index, 1); // 2nd parameter means remove one item only
        }
        cardDiv.classList.remove("selectedUser");
        let newVal = selected_count.innerText = Number(selected_count.innerText)-1;

        selected_count.innerText = newVal;
    }
    else{
        cardDiv.classList.add("selectedUser");
        selected_users.push(cardDiv);
        let newVal = Number(selected_count.innerText)+1;

        selected_count.innerText = newVal;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    users.forEach(element => {
        element.addEventListener("click", function(event){toggleSelection(event, element)});    
    });

    cancelBtns.forEach(element =>{
        element.addEventListener("click", () => {hidePopup();});
    }); 
});

// get timeslot  information on document load



// #################### buttons ####################
// left
const attend_btn = document.getElementById("attend-btn");
const remove_btn = document.getElementById("remove-btn");
const deselect_btn = document.getElementById("deselect-btn");
const select_btn = document.getElementById("select-btn");
const change_btn = document.getElementById("attendYesBtn");
const dropdown = document.getElementById("TypeDropdown");

async function sendNewStatus(userIdList, new_status, userElementlist){
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            try{
                if(this.responseText == "Success"){
                     users.forEach(element => {
                        userElementlist.forEach(element => {
                            element.getElementsByClassName("status")[0].innerText = new_status;
                        });
                    }); 
                }
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
            try{
                showError("Something went wrong...", JSON.parse(this.responseText)["error"]);
            }
            catch{

            }
        }
    };

    xmlhttp.open("POST", "./change-status.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("id="+timeslot_id+"&users="+JSON.stringify(userIdList) + "&new_status=" + new_status);
}

deselect_btn.addEventListener("click", () => {
    users.forEach((element) =>{
        if(selected_users.indexOf(element) > -1){
           toggleSelection(null, element); 
        }
    });
});

select_btn.addEventListener("click", () => {
    users.forEach(element => {
        if(selected_users.indexOf(element) == -1){
           toggleSelection(null, element); 
        }
    });
});

attend_btn.addEventListener("click", () => {
    // show new status popup
    if(selected_users.length == 0){
        showError("Attendance Error", "No users are selected");
        return;
    }
    // show popup
    showPopup("attendance-popup");
});

change_btn.addEventListener("click", async () => {
    let new_status = dropdown.value;
    let tempIdList = [];
    selected_users.forEach(element => {
        tempIdList.push(Number(element.dataset.userId));
    });
    await sendNewStatus(tempIdList, dropdown.value, selected_users);
    hidePopup();
})

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
    showPopup("code-popup");
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
    hidePopup();
}

function getNewCode(){
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
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
            endCodePopup();
            showError("Code not available", JSON.parse(this.responseText)["error"]);   
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
const editSendBtn = document.getElementById("editYesBtn");

editButton.addEventListener("click", () => {
    showPopup("edit-popup");
});

editSendBtn.addEventListener("click", () => {
    const location_select = document.getElementById("location_select");
    const date = document.getElementById("date");
    const end_time = document.getElementById("end-time");
    const start_time = document.getElementById("start-time");
    const type = document.getElementById("type");
    // get all of the values
    // do  some input validation
    let data = {
            "start":start_time.value,
           "end":end_time.value,
           "date":date.value,
           "type":type.value,
           "location":location_select.value
    };
    console.log(data);
    sendEditAjax(data);
});

function sendEditAjax(data){
        var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            try{
                hidePopup();
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
            showError("Something went wrong", JSON.parse(this.responseText)["error"]);   
        }
    };

    xmlhttp.open("POST", "./change-timeslot-info.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("id="+timeslot_id+"&changedFields="+JSON.stringify(data));
}

const overlay = document.getElementById("overlay");

