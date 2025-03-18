const searchBar = document.getElementById("searchbar");
const itemTemplate =  document.getElementById("itemTemplate");

searchBar.addEventListener("input", ()=>{getSearchResults();});

// Accordian sections

const AccordianTables = Array.from(document.getElementsByClassName("searchResult"));

function getSearchResults(){
    let searchQuery = searchBar.value;
    // send ajax
    let searchAjax = new XMLHttpRequest();
    searchAjax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let jsonResponse = JSON.parse(this.responseText);
            // console.log(jsonResponse);
            processSearchResults(jsonResponse);
        }
    }

    searchAjax.open("POST", "./searchQuery.php", true);
    searchAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    searchAjax.send("query="+searchQuery);
}

function removeAllChildren(element){
    let children =  Array.from(element.children);
    children.forEach(child => {
        element.removeChild(child);
    });
    
}

function findTableFromName(tableName){
    let target = null;
    for (let i = 0; i < AccordianTables.length; i++) {
        const element = AccordianTables[i];
        if(element.id == (tableName+"Collapse")){
            target = element;
            break;
        }
    }

    return target;
}

function processSearchResults(json_response){
    // clear all elements
    // structure of json should be {"TableName1": [data...], {"TableName2": [data]}}
    AccordianTables.forEach(collapse =>{
        removeAllChildren(collapse);
    });

    let tables = Object.keys(json_response);
    tables.forEach(tableName => {
        // find the correct table
        let table = findTableFromName(tableName);
        json_response[tableName].forEach(record => {
            // create a new card node
            // modify the information
            // add it to the container
            let item = itemTemplate.content.cloneNode(true);
            item.querySelector("a").setAttribute("href", record["url"]);
            item.querySelector("h3").innerText = record["display"];
            table.appendChild(item);
        });

    });
}
