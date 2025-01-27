function get_session_data(){
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
            try{
                console.log(this.responseText);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(this.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
            catch{
                // display error message
                console.log("ERROR OCCURED");
            }
        }
      };

    xmlhttp.open("POST", "/php/debugging-tools/get_session_data.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send();

}