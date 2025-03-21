class DebugFunctions{
    static get GET_SESSION_DATA() {return "get_session_data"}
    static get CLEAR_SESSION() {return "clear_session"}
}  



function runDebugScript(script_name){
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
            try{
                console.log(this.responseText);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(this.responseText);
                tab.document.close(); // to finish loading the page
            }
            catch{
                // display error message
                console.log("ERROR OCCURED");
            }
        }
      };

    xmlhttp.open("POST", "../php/debugging-tools/" + script_name + ".php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send();

}