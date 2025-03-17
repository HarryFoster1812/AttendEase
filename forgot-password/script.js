const userSearchInput = document.getElementById("inputEmail");
const message = document.getElementById("inputInfo");
const slideOneBtn = document.getElementById("slide1");
const slideTwoBtn = document.getElementById("slide2");
const error = document.getElementById("errorMessage");
const carouselElement = document.getElementById('carouselExampleIndicators');
const carousel = new bootstrap.Carousel(carouselElement, {
    interval: false, // Disable automatic sliding
});

var userid = null;

userSearchInput.addEventListener("input", ()=>{
    if (userSearchInput.value.trim() == ""){
        slideOneBtn.setAttribute("disabled", "")
    }
    else{
        slideOneBtn.removeAttribute("disabled", "")
    }
});

slideOneBtn.addEventListener("click", function(event){
    event.preventDefault();
    getUserId();
});

function getUserId(){
    let query = userSearchInput.value.trim();

    let searchAjax = new XMLHttpRequest();
    searchAjax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            userid = this.responseText;
            carousel.next();
        }
        else if(this.status == 400){
            errorMessage.classList.remove("d-none");
        }
    }

    searchAjax.open("POST", "./getUserId.php", true);
    searchAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    searchAjax.send("message="+query);
}








message.addEventListener("input", ()=>{
    if (userSearchInput.value.trim() == ""){
        slideTwoBtn.setAttribute("disabled", "")
    }
    else{
        slideTwoBtn.removeAttribute("disabled", "")
    }
});

slideTwoBtn.addEventListener("click", function(event){
    event.preventDefault();
    sendRequest();
});

function sendRequest(){
    let query = message.value.trim();

    let searchAjax = new XMLHttpRequest();
    searchAjax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            carousel.next();
        }
    }

    searchAjax.open("POST", "./forgot-password-request.php", true);
    searchAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    searchAjax.send("message="+encodeURI(query)+"&id="+userid);
}
