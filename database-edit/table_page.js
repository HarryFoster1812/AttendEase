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
    }
    // we know that we are deleting a record so we can contruct the query
    console.log(sqlQuery);
    console.log(params);
    
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
