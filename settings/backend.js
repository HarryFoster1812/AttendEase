
// PROFILE PICTURE SECTION 

const imageUpload = document.getElementById('fileUpload');
const popup = document.getElementById('popup');
const cancelBtn = document.getElementById('cancelBtn');
const cropBtn = document.getElementById('cropBtn');
const cropContainer = document.getElementById('cropContainer');
const overlay = document.getElementById('overlay');
const profileImage = document.getElementById('profileImage');
const uploadBtn = document.getElementById("uploadBtn");

let cropper;

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
    }
});

// Open popup and initialize cropme.js
function openCropPopup(imageUrl) {
    overlay.style.display = 'flex'; // Show the overlay
    popup.style.display = 'block';

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

        cropCallback: function (result) {
            console.log(result);
            // Handle the cropped result (image or data)
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
    }
});

uploadBtn.addEventListener("click", () => {
    // check if an image has been selected and cropped
    //
    // NEED TO ADD INPUT VALIDATION
    //
    //
    console.log(profileImage.src);

    var xhr = new XMLHttpRequest();

    // Set up the request type and URL (POST request to upload.php)
    xhr.open('POST', './uploadProfilePicture.php', true);

    // Set the content-type to JSON (since we're sending a JSON object)
    xhr.setRequestHeader('Content-Type', 'application/json');

    // Define what to do when the request completes
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
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


// PROFILE DETAILS



// ACCOUNT SETTINGS


// PREFERENCES


// PRIVACY AND SECURITY
