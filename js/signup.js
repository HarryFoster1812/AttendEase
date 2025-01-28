const popup = document.querySelector(".popup-container");
const closers = document.querySelectorAll(".popup-close");
const button = document.querySelector('#button-toggle');
const proceed = document.querySelector(".accept-term");
const formErrors = document.querySelectorAll('.form-error-msg');
const formInputs = document.querySelectorAll('.form-control');
const passToggle = document.getElementById('pass-toggle');
const createUser = () => {
    console.log("User created!");
}
const showError = (idx) => {
    formErrors[idx].classList.remove('hide');
    formInputs[idx].classList.add('form-error');
    formInputs[idx].value="";
}
for(const closer of closers){
    closer.addEventListener('click',()=>{
        popup.style.display = "none";
        document.body.style.overflow="scroll";
    });
}
for(const formInput of formInputs){
    formInput.addEventListener('click',function(){
        this.classList.remove('form-error');
        this.previousElementSibling.classList.add('hide');
    });
    formInput.value="";
}
for(const formError of formErrors){
    formError.classList.add('hide');
}

button.addEventListener('click',()=>{
    const user = formInputs[0].value;
    const email = formInputs[1].value;
    const pass = formInputs[2].value;
    const emailRegex = /^[^\s@]+@(?:student\.)?manchester\.ac\.uk$/;
    const passRegex = /^(?=(.*[a-z]))(?=(.*[A-Z]))(?=(.*\d))(?=(.*[\W_]))[\w\W]{8,64}$/;

    let isError = false;
    if(!user.trim()){
        showError(0);
        isError = true;
    }
    if(!emailRegex.test(email)){
        showError(1);
        isError = true;
    }
    if(!passRegex.test(pass)){
        showError(2);
        isError = true;
    }
    if(!isError){
        popup.style.display="flex";
        document.body.style.overflow="hidden";
        setTimeout(() => {
            popup.style.opacity = 1; // Trigger fade-in effect
            popup.style.transform = 'translateY(0)'; // Move the popup into view
          }, 10); // Small delay to allow the display property to take effect
    }
});
proceed.addEventListener('click',()=>{
    popup.style.display = "none";
    document.body.style.overflow="scroll";
    createUser();
})
passToggle.addEventListener('click',function(){
    console.log(this);
    if(this.checked){
        formInputs[2].type = "text";
    }
    else{
        formInputs[2].type = "password";
    }
})