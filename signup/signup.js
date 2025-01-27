username = document.getElementById("username");
email = document.getElementById("email");
password = document.getElementById("user_pass");
togglePass = document.getElementById("toggle_pass");
terms = document.getElementById("terms_and_conditions");
submit = document.querySelector("#signup");

background = document.getElementsByClassName("overlay")[0];
background.style.height = "1050px"; // i need to hard code this to start because css and js does not mix well


username.addEventListener("input", checkUsername);
email.addEventListener("input", checkEmail);
password.addEventListener("input", checkPassword);
togglePass.addEventListener("click", togglePassword);
terms.addEventListener("click", checkTerms);
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

    const re = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    isSecure = re.test(text);

    if (text == null || text.trim() == ""){
        showError(element, "Password field can not be empty.");
        valid = false;
    }
    

    else if (!isSecure) {
        showError(element, 'Password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)', longMessage = true);
    } else {
        removeError(element);
        valid = true;
    }

    return valid;

}

function checkEmail(input){
    let valid = false;

    if (input.srcElement != undefined){
        // extract the sender element
        element = input.srcElement;
    }

    else{
        element = input;
    }

    text = element.value;

    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    testValid = re.test(text);


    

    if (text == null || text.trim() == ""){

        showError(element, "Email field can not be empty.");
        valid = false;
    }
    

    else if (!testValid) {
        showError(element, 'Please enter a valid email');
    } else {
        removeError(element);
        valid = true;
    }

    return valid;
}

function togglePassword(){
    password.type = password.type=="password" ? "text" : "password";
}

function checkTerms(input){
    let valid = false;

    if (input.srcElement != undefined){
        // extract the sender element
        element = input.srcElement;
    }

    else{
        element = input;
    }

    if (!element.checked){
        showError(element, "You must agree to the terms and conditions");
    }

    else{
        valid = true;
        removeError(element);
    }

    return valid;
}

function checkSubmit(e){

    usernameValid = checkUsername(username);
    emailValid = checkEmail(email);
    passwordValid = checkPassword(password);
    termsValid = checkTerms(terms);

    formValid = usernameValid && emailValid && passwordValid && termsValid;

    if (!formValid){
        e.preventDefault(); // stop the form from submitting
    }
}