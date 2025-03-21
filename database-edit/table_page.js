deleteBtns = Array.from(document.getElementsByClassName("btn-danger"));

// allow rtrim because js...
String.prototype.rtrim = function(s) { 
    return this.replace(new RegExp(s + "*$"),''); 
};

deleteBtns.forEach(button => {
    // get the edit button href
    button.addEventListener("click", ()=>{
        let row = button.parentElement.parentElement;
        let href  = row.querySelector("a").attributes["href"].textContent;
        sendDelete(href, row);
    })
});

function sendDelete(edit_href, rowElement){
    sqlQuery =  "DELETE FROM ";
    let params = edit_href.split("../database-edit/?")[1];
    params = params.split("&");
    let table = params[0].split("=")[1];

    sqlQuery += table + " WHERE ";

    if(params.includes("multi=1")){
        // we know that there are multiple keys
        let column_names = JSON.parse(decodeURIComponent(params[1].split("=")[1]));
        let id_values = JSON.parse(decodeURIComponent(params[2].split("=")[1]));
        params = {};
        for(let i=0;i<column_names.length;i++){
            column = column_names[i];
            sqlQuery += column + `=:${column} AND `;

            params[`:${column}`] = id_values[i];
        }
        sqlQuery = sqlQuery.rtrim("AND ");

    }
    else{
        let column = decodeURIComponent(params[1].split("=")[1]);
        let id_value = decodeURIComponent(params[2].split("=")[1]);
        params = {};
        sqlQuery += column + `=:${column}`;

        params[`:${column}`] = id_value;
    }
    // we know that we are deleting a record so we can contruct the query
    // console.log(sqlQuery);
    // console.log(params);

    // send ajax
    let databaseAjax = new XMLHttpRequest();
    databaseAjax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            rowElement.parentElement.removeChild(rowElement);
        }
    }

    databaseAjax.open("POST", "./admin_exe_sql.php", true);
    databaseAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    databaseAjax.send("query="+sqlQuery+"&params="+JSON.stringify(params));
}


const insertBtn = document.getElementById("insert");
insertBtn.addEventListener("click", ()=>{showInsertPopup();});

const submitBtn = document.getElementById("submit");
submitBtn.addEventListener("click", ()=>{sendInsert();});


const cancelBtn = document.getElementById("cancel");
cancelBtn.addEventListener("click", ()=>{hidePopup();});

var currentPopup = null;
const overlay = document.getElementById("overlay");

const inputElements = Array.from(document.querySelectorAll("input"));
const labelElements = Array.from(document.querySelectorAll("h3"));

function showInsertPopup(){
    currentPopup = document.getElementById("insert-popup");
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

function sendInsert(){
    let sqlQuery =  "INSERT INTO ";
    let table = document.getElementById("tableHead").innerText.rtrim(" Table");
    sqlQuery += table + " VALUES ";

    let values = [];
    params = {};
    for (let i = 0; i < inputElements.length; i++) {
        const element = inputElements[i].value;
        const column = labelElements[i].innerText;

        values.push(":"+column);
        params[":"+column] = element;
    }

    sqlQuery += "(" + values.join(',') + ")";

    let databaseAjax = new XMLHttpRequest();
    databaseAjax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let json_data = JSON.parse(this.responseText);            
            if(json_data["response"] === 1){
                location.reload();
            }
            else{
                console.log(json_data);
            }
        }
    }

    databaseAjax.open("POST", "./admin_exe_sql.php", true);
    databaseAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    databaseAjax.send("query="+sqlQuery+"&params="+JSON.stringify(params));
}
