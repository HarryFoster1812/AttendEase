//-------------------- PROFILE PICTURE SECTION --------------------

const imageUpload = document.getElementById('fileUpload');
const popup = document.getElementById('popup');
const cancelBtn = document.getElementById('cancelBtn');
const cropBtn = document.getElementById('cropBtn');
const cropContainer = document.getElementById('cropContainer');
const overlay = document.getElementById('overlay');
const profileImage = document.getElementById('profileImage');
const uploadBtn = document.getElementById("uploadBtn");
const errorDiv = document.getElementById("errormsg");

let cropper;
let fileSelected = false;

// Open the crop popup when an image is selected
imageUpload.addEventListener('change', function (e) {
    console.log(imageUpload.files[0]);
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
            const imageUrl = event.target.result;
            openCropPopup(imageUrl);
        };
        reader.readAsDataURL(file);
        errorDiv.innerText = "";
    }
});

// Open popup and initialize cropme.js
function openCropPopup(imageUrl) {
    overlay.style.display = 'flex'; // Show the overlay
    popup.style.display = 'block';
    deletepopup.style.display = 'none';

    cropper = new Cropme(cropContainer, {
        "viewport": {
            "width": 200,
            "height": 200,
            "type": "circle",
            "border": {
                "width": 2,
                "enable": true,
                "color": "#fff"
            }
        },

        "zoom": {
            "enable": true,
            "mouseWheel": true,
            "slider": true
        },
        "rotation": {
            "slider": true,
            "enable": true,
            "position": "left"
        }
    });

    cropper.bind({
        "url": imageUrl 
    });
}


// Cancel button: Close the popup
cancelBtn.addEventListener('click', function () {
    overlay.style.display = 'none';
    if (cropper) {
        cropper.destroy();
       imageUpload.value = ""; 
    }
});

// Crop button: Handle the cropping action
cropBtn.addEventListener('click', function () {
    if (cropper) {
        const result = cropper.crop();
        console.log(result);
        profileImage.src = result["_v"];
        cropper.destroy();
        overlay.style.display = 'none';
        fileSelected = true;
    }
});

uploadBtn.addEventListener("click", () => {

    if (!fileSelected){
        // add error message
        errorDiv.innerText = "You need to select a file first"; 
        return;
    }

    var xhr = new XMLHttpRequest();

    // Set up the request type and URL (POST request to upload.php)
    xhr.open('POST', './uploadProfilePicture.php', true);

    // Set the content-type to JSON (since we're sending a JSON object)
    xhr.setRequestHeader('Content-Type', 'application/json');

    // Define what to do when the request completes
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            // remove the selected file
            fileSelected = false;
            fileUpload.value = "";
            errorDiv.style.color = "green";
            errorDiv.innerText = "File upload successful";
        }
    };

    // Define what to do in case of an error (like a network failure)
    xhr.onerror = function () {
        console.error('Request failed.');
        console.log(JSON.parse(xhr.responseText));
    };

    // Prepare the data to send (the base64 image string inside a JSON object)
    const data = {
        image: profileImage.src
    };

    // Send the data as a JSON string
    xhr.send(JSON.stringify(data));
});


// -------------------- PROFILE DETAILS --------------------

const saveProfile = document.getElementById("saveChangesProfile");

const username = document.getElementById("usernameInput");
const pronouns = document.getElementById("pronounSelect");

saveProfile.addEventListener("click", () => {
    // add validation to make sure something is selected
    // add ajax to send the new information off
    // Need modCount
    // modified fields
    // replacement fields
   if (username.value = ""){
        console.log("you must enter a username");
    }

    sendChangeSettingsAJAX(["username", "pronouns"], [usernameInput.value, pronouns.value])
    
});


function sendChangeSettingsAJAX(changedFields, newValues){
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // display success messages
            console.log(this.responseText);
        }
    };

    xmlhttp.open("POST", "./changeSettings.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("modCount="+ changedFields.length.toString() +"&changedFields="+JSON.stringify(changedFields)+"&newValues="+JSON.stringify(newValues));
}


//-------------------- ACCOUNT SETTINGS--------------------
deleteButton = document.getElementById("deleteAccount");
signOutButton = document.getElementById("signOutBtn");
requestDataButton = document.getElementById("requestDataBtn");

const deleteOverlay = document.getElementById("deleteOverlay");
const deletepopup = document.getElementById("deletepopup");
const yesButton = document.getElementById("yesBtn");
const noButton = document.getElementById("noBtn");

noButton.addEventListener("click", () => {
    overlay.style.display = 'none'; // Show the overlay
});

yesButton.addEventListener("click", () => {
    // do ajax
    window.location.replace("../signout/"); 
});

deleteButton.addEventListener("click", () => {
    // are you sure popup
    
    overlay.style.display = 'flex'; // Show the overlay
    deletepopup.style.display = "block";
});

signOutBtn.addEventListener('click', () => {
    window.location.replace("../signout/"); 
});

requestDataButton.addEventListener("click", ()=> {
    // add ajax for the request data php
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // display success messages
            console.log(this.responseText);
        }
    };

    xmlhttp.open("POST", "./requestData.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send();
});

// ------------ PREFERENCES --------------------
darkMode = document.getElementById("darkModeInput");
timeselect = document.getElementById("timeSelect");

darkMode.addEventListener("change", () => {
   if (darkMode.checked){
        Cookies.set("darkMode", "enabled");
        // add new css
    } 
    else{
        // remove cookie and remove css
        Cookies.remove("darkMode");
    }
});


timeselect.addEventListener("change", () => {
   Cookies.set("time", timeselect.value);
});

// --------------------PRIVACY AND SECURITY--------------------

const locationToggle = document.getElementById("locationToggle");
const leaderboardToggle = document.getElementById("leaderboardToggle");

const privacySubmitBtn = document.getElementById("privacySubmit");
privacySubmitBtn.addEventListener("click", () =>{
    // get the location and leaderboard as 0 or 1
    let locationint = locationToggle.checked ? 1 : 0;
    let leaderboardint = leaderboardToggle.checked ? 1 : 0;
    sendChangeSettingsAJAX(["location", "leaderboard"],[locationint, leaderboardint]);
});


function checkPassword(text){ 
    const re = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    testValid = re.test(text);

    return testValid;
}

const changePass = document.getElementById("changePassBtn");
const newPassError = document.getElementById("newerror")
const renewPassError = document.getElementById("renewerror")


const oldpass = document.getElementById("oldpass");
const newpass = document.getElementById("newpass");

    newpass.addEventListener("input",() =>{
    validatepassword();
});

const renewpass = document.getElementById("renewpass");
renewpass.addEventListener("input", () =>{
    validatepassword();
   });

function validatepassword(){
    if(checkPassword(newpass.value)){
        newPassError.innerText = "";
    }
    else{
        newPassError.innerText = "Password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)"
    }

    if(renewpass.value != newpass.value){
        renewPassError.innerText = "Passwords do not match";
    }
    else{
        renewPassError.innerText = "";
        if(checkPassword(newpass.value)){
            return true;
        }
    }
    return false;

}


changePass.addEventListener("click", () => {
    // validate the new password
    // make sure they match
    // send ajax
    // if successful then log them out
    if (oldpass.value.trim() != "" && validatepassword()){
        //send the form
        var xhr = new XMLHttpRequest();

        // Set up the request type and URL (POST request to upload.php)
        xhr.open('POST', './changePassword.php', true);

        // Set the content-type to JSON (since we're sending a JSON object)

        // Define what to do when the request completes
        xhr.onreadystatechange = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                console.log(this.responseText);
                window.location.replace("../login/")
            }
            else if(xhr.startus == 400){
                console.log(this.responseText);
            }
        };

        // Define what to do in case of an error (like a network failure)
        xhr.onerror = function () {
            console.error('Request failed.');
            console.log(JSON.parse(xhr.responseText));
        };

        // Prepare the data to send (the base64 image string inside a JSON object)
        // Send the data as a JSON string
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("oldPass="+oldpass.value+"&newPass="+newpass.value);
    }
});




// NEED TO DO
//
// ADD REQUEST ALL DATA
// ADD LINE TO PROFILE DATA TO SHOW DEGREE
// MAKE DARKMODE WORK
