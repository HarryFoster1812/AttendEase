document.getElementById("table_slider").checked=false;

// get the date picker
date_picker = document.getElementById("datepicker"); 

date_picker.addEventListener("change", dateEvent);

date_header = document.getElementById("date");

document.getElementById("date_forward").addEventListener("click", nextDate);
document.getElementById("date_back").addEventListener("click", previousDate);

var months = ["January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

function convertSoloDate(date_str) {
  temp_date = date_str.split("-");
  return temp_date[2] + " " + months[Number(temp_date[1]) - 1] + " " + temp_date[0];
}

function convertDate(start_date_string, end_date_string) {
    return_string = "";
    temp_date_one = start_date_string.split("-");
    temp_date_two = end_date_string.split("-");

    // check if the day is the same
    if (temp_date_one[2] == temp_date_two[2]){
        return_string = temp_date_one[2];
    }

    else{
        return_string = temp_date_one[2] + "-" + temp_date_two[2];
    }

    // check is the month is the same and the year
    if (temp_date_one[1] == temp_date_two[1]){
        return_string += months[Number(temp_date_one[1]) - 1];
    }

    else{
        return_string =  temp_date_one[2] + " " + months[Number(temp_date_one[1]) - 1] + "-" + temp_date_two[2] + " " + months[Number(temp_date_two[1]) - 1];
    }

    return return_string;
  }

function isWeekend(date) {
    return !date.is().weekday();
}
end_date = "";

function clearCalendar(){

}

function populateCalendar(json_data){
    
}

function nextDate(event){
    selected_date = Date.parse(date_picker.value);
    timePeriod = getCurrentTimeButton();

    if (timePeriod == "Day"){
        selected_date.add(1).day();
    }

    else if (timePeriod == "Week"){
        selected_date.add(1).week();
    }

    else if (timePeriod == "Month"){
        selected_date.add(1).month();
    }

    changeDate(selected_date.toString("yyyy-MM-dd"));

}

function previousDate(event){
    selected_date = Date.parse(date_picker.value);
    timePeriod = getCurrentTimeButton();

    if (timePeriod == "Day"){
        selected_date.add(-1).day();
    }

    else if (timePeriod == "Week"){
        selected_date.add(-1).week();
    }

    else if (timePeriod == "Month"){
        selected_date.add(-1).month();
    }

    changeDate(selected_date.toString("yyyy-MM-dd"));
}

function changeDate(newDate){
    date_picker.value = newDate;

    evt = new Event("change");
    date_picker.dispatchEvent(evt);
}

function calculateStartEndDate(date, timePeriod){

    // convert to datejs object

    date =  Date.parse(date);
    cloneDate =  structuredClone(date); // we clone is since the datejs is mutable

    if(isWeekend(date)){
        // since it is a week-end we should get the next monday
        monday_date =  cloneDate.next().monday();
    }
    else if (date.is().monday()){
        monday_date = cloneDate;
    }
    else{
        monday_date = cloneDate.last().monday();
    }

    end_date = "";
    
    if(timePeriod == "Day"){
        start_date = date;
        end_date = date;
    }

    else if (timePeriod == "Week"){
        start_date = monday_date;
        end_date = structuredClone(monday_date).next().friday();
    }

    else if (timePeriod == "Month"){
        // i dont know what start date you want from me. 
        // Do i just go for 1st of the month and last of the month?
        // Do i do the first monday closest to the first and friday closest to the end?
        start_date = date;
        end_date = date;
    }

    return [start_date.toString("yyyy-MM-dd"), end_date.toString("yyyy-MM-dd")];
}

function dateEvent(event){
    // get the date that is picked
    date = event.srcElement.value;
    // do some calculation to find the start and end date given the given scope (day, week, month)
    time = getCurrentTimeButton();

    let start_date, end_date;

    [start_date, end_date] = calculateStartEndDate(date, time); 

    // NEED TO FINISH THIS 
    // NEED TO FINISH
    if (start_date == end_date){
        date_header.innerText = convertSoloDate(start_date);
    }

    else{
        date_header.innerText = convertDate(start_date, end_date);
    }

    // send a request to the server using ajax
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // update the calendar
            try{
                console.log(this.responseText);
                json_data = JSON.parse(this.responseText);
                console.log(json_data);
            }
            catch{
                // display error message
            }
        }
      };

    xmlhttp.open("POST", "/calendar/get-calendar-data.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("start_date="+start_date+"&end_date="+end_date);

}

function setDateToday(){
    today = Date.today().toString("yyyy-MM-dd");
    
    changeDate(today);
}

function switchBackground(){
    var slider = document.getElementById("table_slider");
    var tables = document.querySelectorAll('.table-default');
    tables.forEach(function(x){
        if(slider.checked){
            x.classList.add("table-custom");
        }
        else{
            x.classList.remove("table-custom");
        }
    });
};
function switchTable(time){
    var buttons = document.querySelectorAll('.time-button');
    var tables = document.querySelectorAll('.table-responsive-lg');
    var buttonbase = "button-";
    var tablebase ="timetable-";

    buttons.forEach(function(x){
        x.classList.remove('btn-secondary');
        x.classList.add('btn-light');
    });

    tables.forEach(function(x){
        x.classList.add('d-none');
        x.classList.remove('d-block')
    });

    document.getElementById(buttonbase.concat(time)).classList.add('btn-secondary');
    document.getElementById(buttonbase.concat(time)).classList.remove('btn-light');
    document.getElementById(tablebase.concat(time)).classList.remove('d-none');
    document.getElementById(tablebase.concat(time)).classList.add('d-block');

    // get calendar information
    evt = new Event("change");
    date_picker.dispatchEvent(evt);
}

function getCurrentTimeButton(){
    
    var buttons = document.querySelectorAll('.time-button');
    time = ""; 
    buttons.forEach(function(x){
        // loop over each and find which button is selected
        if(x.classList.contains("btn-secondary")){
            time = x.innerText;
        }
    })

    return time;
}



setDateToday();