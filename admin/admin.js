const searchBar = document.getElementById("searchbar");
const itemTemplate =  document.getElementById("itemTemplate");

// Accordian sections
const userSection = document.getElementById("UserCollapse") 
const timeslotSection = document.getElementById("TimeslotCollapse") 
const locationSection = document.getElementById("LocationCollapse") 
const courseSection = document.getElementById("CourseCollapse") 

function getSearchResults(){
    let searchQuery = searchBar.value;
    // send ajax
    let searchAjax = new XMLHttpRequest();
    searchAjax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let jsonResponse = JSON.parse(this.responseText);
            processSearchResults(jsonResponse);
        }
    }

    searchAjax.open("POST", "./searchQuery.php", true);
    searchAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    searchAjax.send("query="+searchQuery);
}

function test(){
    for(let i = 0; i<3;i++){
        let temp = itemTemplate.content.cloneNode(true);
        userSection.appendChild(temp);
        timeslotSection.appendChild(temp); 
        locationSection.appendChild(temp); 
        courseSection.appendChild(temp);   
    }
}

function processSearchResults(json_response){
    // clear all elements
    //userSection 
    //timeslotSection
    //locationSection
    //courseSection 
}



test(); 
