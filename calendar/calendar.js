document.getElementById("table_slider").checked=false;

// get the date picker
date_picker = document.getElementById("datepicker"); 

date_picker.addEventListener("change", dateEvent);

date_header = document.getElementById("date");

event_template = document.getElementById("class-ui");


document.getElementById("date_forward").addEventListener("click", nextDate);
document.getElementById("date_back").addEventListener("click", previousDate);



const months = ["January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

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
        return_string = return_string + " - " + months[Number(temp_date_one[1]) - 1];
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

function clearCalendar(period){
    let timetable = null;
    if(period=="Day"){
        timetable = document.getElementById('timetable-day');
    }
    else if(period=="Week"){
        timetable = document.getElementById('timetable-week');
    }
    else{
        timetable = Array.from(document.getElementsByClassName('calendar-content'));
        timetable.forEach(dayOfMonth => {
            dayOfMonth.innerHTML = "";
        });

        return;
    }

    let timetableElements = Array.from(timetable.getElementsByTagName("td"));
    timetableElements.forEach(element => {
        element.innerHTML = "";
    });
}

function populateDay(json_data, tableElements, dateFilter){
    // create a function which maps the time to an index in the table
    // starts at 8  (index[0] = 8:00)
    // last element is 18:00

    // filter the json_data for the given date
    filtered_json  = []
    for (let i =0; i<json_data.length;i++){ 

      filtered_json.push(json_data[i].filter((item) => {
           return item["date"] === dateFilter;
        }));
    }

    // loop over each event in the  filtered_json
    for (let i=0;i<filtered_json.length;i++){
        for(let j=0;j<filtered_json[i].length;j++){
            let event_item = event_template.content.cloneNode(true);
            // change node content
            // need to add something so that student and lecturer events can be distinct (maybe a class?)
            event_item.querySelector(".class-time-text").innerText = filtered_json[i][j]["start_time"] + " - " + filtered_json[i][j]["end_time"];
            event_item.querySelector(".class-title").innerText  = filtered_json[i][j]["course_title"];
            event_item.querySelector(".class-loc").innerText = filtered_json[i][j]["location_name"];

            time = Number(filtered_json[i][j]["start_time"].substring(0,2));
            index = time -8;
            tableElements[index].appendChild(event_item);
        }
    }   
    
 
    // in each template change the time
    // change the Title  of the 
}


function days_between(date1, date2) {
    // The number of milliseconds in one day
    const ONE_DAY = 1000 * 60 * 60 * 24;

    // Calculate the difference in milliseconds
    const differenceMs = Math.abs(date1 - date2);

    // Convert back to days

    let days = Math.round(differenceMs / ONE_DAY);
    let noWeeks = Math.floor(days/7);
    return days - 2*noWeeks; 

}

function populateMonth(json_data, tableElements, start_date){
    for (let i=0;i<json_data.length;i++){
        for(let j=0;j<json_data[i].length;j++){
            let event_item = event_template.content.cloneNode(true);
            // change node content
            // need to add something so that student and lecturer events can be distinct (maybe a class?)
            event_item.querySelector(".class-time-text").innerText = json_data[i][j]["start_time"] + " - " + json_data[i][j]["end_time"];
            event_item.querySelector(".class-title").innerText  = json_data[i][j]["course_title"];
            event_item.querySelector(".class-loc").innerText = json_data[i][j]["location_name"];

            event_date = Date.parse(json_data[i][j]["date"]);
            // It is not that simple. I forgot to account for weekends.
            index = days_between(event_date, start_date);
            tableElements[index].appendChild(event_item);
        }
    }        
}

function populateCalendar(json_data, period, start_date){

    if (json_data.length == 0){
        return;
    }

    start_date = Date.parse(start_date);

    if(period=="Day"){
        let timeTableDay = Array.from(document.getElementById('timetable-day').getElementsByTagName("td"));

        populateDay(json_data, timeTableDay, start_date.toString("yyyy-MM-dd"));
    }
    else if(period=="Week"){
        let timeTableWeek = Array.from(document.getElementById('timetable-week').getElementsByTagName("td"));
        // split each week into indiviual days
        var days = [[],[],[],[],[]];
        for (let i=0;i<timeTableWeek.length;i++){
            days[i%5].push(timeTableWeek[i]);
        }

        for(let i=0;i<5;i++){
            populateDay(json_data, days[i], start_date.toString("yyyy-MM-dd"));
            start_date.addDays(1);
        }

    }
    else{
        let timeTableMonth= Array.from(document.getElementsByClassName('calendar-content'));

        populateMonth(json_data, timeTableMonth, start_date)
    } 
}

function nextDate(event){
    selected_date = Date.parse(date_picker.value);
    timePeriod = getCurrentTimeButton();

    if (timePeriod == "Day"){

        selected_date.add(1).day();
        if(selected_date.getDay()==6){
            selected_date.add(2).day();
        }
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
        if(selected_date.getDay()==0){
            selected_date.add(-2).day();
        }
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
    let monthBounds=[31,28,31,30,31,30,31,31,30,31,30,31];
    if (Date.isLeapYear(date.getYear())){
        monthBounds[1]+=1;
    }
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
        if(date.getDay()==6){
            date.add(2).day();
            date_picker.value=date.toString('yyyy-MM-dd');
        }
        if(date.getDay()==0){
            date.add(1).day();
            date_picker.value=date.toString('yyyy-MM-dd');
        }
    }

    else if (timePeriod == "Week"){
        start_date = monday_date;
        end_date = structuredClone(monday_date).next().friday();
    }

    else if (timePeriod == "Month"){
        const firstMonday = structuredClone(date).first().monday();
        start_date = firstMonday;

        if(firstMonday.getDate()>3){
            start_date = firstMonday.addDays(-7);
        }

        const lastFriday = structuredClone(date).final().friday();
        end_date = lastFriday;
        const lastMonthDay = structuredClone(date).moveToLastDayOfMonth();
        if(lastFriday.getDate()+3 <= lastMonthDay.getDate()){
            end_date = lastFriday.addDays(7);
        }
    }
    displayTableDates(start_date);

    return [start_date.toString("yyyy-MM-dd"), end_date.toString("yyyy-MM-dd")];
}

function dateEvent(event){
    // get the date that is picked
    date = event.srcElement.value;

    // do some calculation to find the start and end date given the given scope (day, week, month)
    time = getCurrentTimeButton();

    let start_date, end_date;

    [start_date, end_date] = calculateStartEndDate(date, time); 

    if (start_date == end_date){
        date_header.innerText = convertSoloDate(start_date);
    }

    else if (time == "Week"){
        date_header.innerText = convertDate(start_date, end_date);
    }
    else{
        date_header.innerText =  months[Date.parse(date).getMonth()];
    }

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // update the calendar
            try{
                json_data = JSON.parse(this.responseText);
                clearCalendar(time);
                populateCalendar(json_data, time, start_date);
            }
            catch(e){
                // display error message
                // document.write ?
                console.error(e, e.stack);
            }
        }
        else if (this.status==400){
            // display a error message to the user since it was generated by the php
            const error_message = document.createElement("div");
            error_message.classList.add("alert alert-danger");
            error_message.setAttribute("role", "alert");
            error_message.innerText = JSON.parse(this.responseText)["error"];
    
            document.querySelector("body").insertBefore(error_message, document.querySelector("body").firstChild);

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

function displayTableDates(start_date){
    const period = getCurrentTimeButton();
    const weekdays = ["Monday","Tuesday","Wednesday","Thursday","Friday"];
    let dateDayOfWeek = weekdays[start_date.getDay()-1];
    let monthBounds=[31,28,31,30,31,30,31,31,30,31,30,31];
    if (Date.isLeapYear(start_date.getYear())){
        monthBounds[1]+=1;
    }
    let monthChosen = start_date.getMonth();

    let dateDay =start_date.getDate();

    if(period=="Day"){
        const timeTableDay = document.getElementById('timetable-day');
        const cell = Array.from(timeTableDay.querySelectorAll('th'))[1];
        cell.innerHTML = `${dateDayOfWeek}<br>${String(dateDay)}`;
    }
    else if(period=="Week"){
        const timeTableWeek = document.getElementById('timetable-week');
        const cells = Array.from(timeTableWeek.querySelectorAll('th')).slice(1,6);
        for(let i=0;i<cells.length;i++){
            cells[i].innerHTML = `${weekdays[i]}<br>${dateDay}`;
            dateDay+=1;
        }
    }
    else{
        monthChosen = Date.parse(date_picker.value).getMonth(); 
    
        const timeTableMonth = document.getElementById('timetable-month');
        const cells = Array.from((timeTableMonth.querySelectorAll('.calendar-date')));
        let calendarDate = structuredClone(start_date);
        for(let i=0;i<cells.length;i++){
            
            cells[i].innerHTML = `${calendarDate.getDate()}`;
            calendarDate.addDays(1);
            if(isWeekend(calendarDate)){
                calendarDate.next().monday();
            }
        }
    }
}

setDateToday();
