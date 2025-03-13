const runBtn = document.getElementById("showPopup");
const exeBtn = document.getElementById("submit");
const cancelBtn = document.getElementById("cancel");
const inputElem = document.getElementById("commandInput");
const responseElm = document.getElementById("response");

function showPopup(id){
    currentPopup = document.getElementById(id);
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

runBtn.addEventListener("click", ()=>{
    showPopup("sql-popup");
});


cancelBtn.addEventListener("click", ()=>{
    hidePopup("sql-popup");
});

exeBtn.addEventListener("click", ()=>{
    sendQuery();
});

function sendQuery(){
    let sqlQuery = inputElem.value;
    let params = [];
    // send ajax
    let databaseAjax = new XMLHttpRequest();
    databaseAjax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let json_data = JSON.parse(this.responseText);            
            let highlighted_data = syntaxHighlight(json_data);
            console.log(highlighted_data);
            responseElm.innerHTML = highlighted_data;

        }
    }

    databaseAjax.open("POST", "./admin_exe_sql.php", true);
    databaseAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    databaseAjax.send("query="+sqlQuery+"&params="+JSON.stringify(params));
}


function syntaxHighlight(json) {
    if (typeof json != 'string') {
         json = JSON.stringify(json, undefined, 2);
    }
    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
        var cls = 'number';
        if (/^"/.test(match)) {
            if (/:$/.test(match)) {
                cls = 'key';
            } else {
                cls = 'string';
            }
        } else if (/true|false/.test(match)) {
            cls = 'boolean';
        } else if (/null/.test(match)) {
            cls = 'null';
        }
        return '<span class="' + cls + '">' + match + '</span>';
    });
}
