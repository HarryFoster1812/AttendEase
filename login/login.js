username = document.getElementById("username");
password = document.getElementById("user_pass");
togglePass = document.getElementById("toggle_pass");
submit = document.getElementsByClassName("submit")[0];

background = document.getElementsByClassName("overlay")[0];
background.style.height = "850px"; // i need to hard code this to start because css and js does not mix well


username.addEventListener("input", checkUsername);
password.addEventListener("input", checkPassword);
togglePass.addEventListener("click", togglePassword);
submit.addEventListener("submit", checkSubmit);

userinput = null;

function linker(page){
    if(page=="signup"){
        window.location.href=page
    }
}

function showError(element, message, longMessage = false){
    small_element = element.parentElement.children[2];
    if(small_element.innerText == ""){
        console.log("BEFORE: "+ background.style.height);
        height = parseInt(background.style.height.split("px")[0]);
        console.log("HEIGHT: " + height)
        background.style.height = (height+ (longMessage ? 300 : 100)).toString() + "px";
        console.log(background.style.height);
    }

    element.classList.remove('success');
    element.classList.add('error');

    small_element.innerText = message; 
}

function removeError(element){
    element.classList.remove('error');
    element.classList.add('success');

    small_element = element.parentElement.children[2];

    if (small_element.innerText != ""){
        height = parseInt(background.style.height.split("px")[0]);
        background.style.height = (height - 100).toString() + "px";
        small_element.innerText = "";
    }
}

function checkUsername(input){
    valid = false;
    
    // two types of inputs are given to this function, the element its self or the event

    if (input.srcElement != null || input.srcElement != undefined){ // check if it is an event
        // extract the sender element
        element = input.srcElement;
    }

    else{
        element = input;
    }
    
    text = element.value;

    if (text == null || text.trim() == ""){
        showError(element, "Username field can not be empty.");
    }

    else{
        removeError(element);
        valid = true;
    }

    return valid;
}

function checkPassword(input){
    let valid = false;

    if (input.srcElement != null || input.srcElement != undefined){
        //extract the sender element
        element = input.srcElement;
    }

    else{
        element = input;
    }


    text = element.value;

    if (text == null || text.trim() == ""){
        showError(element, "Password field can not be empty.");
        valid = false;
    }
    else{
        valid = true;
        removeError(element);
    }

    return valid;
}

function togglePassword(){
    password.type = password.type=="password" ? "text" : "password";
}


function checkSubmit(e){

    usernameValid = checkUsername(username);
    passwordValid = checkPassword(password);

    formValid = usernameValid  && passwordValid;

    if (!formValid){
        e.preventDefault(); // stop the form from submitting
    }
}