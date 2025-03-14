const queryEl = document.getElementById("query");
const conditions = queryEl.innerText.split("WHERE ")[1];
const resetButton = document.getElementById("reset");
const changeButton = document.getElementById("change");
const inputElements = Array.from(document.querySelectorAll("input"));
const inputLabels = Array.from(document.querySelectorAll("h2"));

resetButton.addEventListener("click", ()=>{
    inputElements.forEach(input => {
        input.value = input.dataset.default
    });
});
changeButton.addEventListener("click", ()=>{sendChange();});

function sendChange(){
    // contruct a query
    let table = queryEl.innerText.split("FROM ")[1].split("WHERE ")[0];
    let query = "UPDATE "+ table + "SET "; 

    let params = {};
    let setStatements = [];
    for (let i = 0; i < inputLabels.length; i++) {
        const columnName  = inputLabels[i].innerText;
        params[columnName] = inputElements[i].value;
        setStatements.push(columnName+"="+":"+columnName);
    }

    query += setStatements.join(',') + " WHERE "+ conditions;
    console.log(query);

    // send ajax
    let databaseAjax = new XMLHttpRequest();
    databaseAjax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let json_data = JSON.parse(this.responseText);            
            console.log(json_data);

        }
    }

    databaseAjax.open("POST", "./admin_exe_sql.php", true);
    databaseAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    databaseAjax.send("query="+query+"&params="+JSON.stringify(params));
}
