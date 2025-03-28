document.getElementById("table_slider").checked=false;

// get the date picker
date_picker = document.getElementById("datepicker"); 

date_picker.addEventListener("change", dateEvent);

date_header = document.getElementById("date");

event_template = document.getElementById("class-ui");
    
let currUser = null;
let currTimeSlot = null;
var popoverInstances = [];
document.getElementById("date_forward").addEventListener("click", nextDate);
document.getElementById("date_back").addEventListener("click", previousDate);

var twelveHourFormat = false;
if (Cookies.get("time") !== undefined){
    let timeformat = Cookies.get("time");
    if (timeformat == "12 Hour AM/PM"){
        twelveHourFormat = true; 
    }
}


function hours12(date){
    let ampm = date.getHours() >= 12 ? 'pm' : 'am';
    return `${date.toString("hh:mm")}${ampm}`;
}

function hours24(date){
    return `${date.toString("HH:mm")}`;
}

function createTimeString(start_time, end_time){
    let timetext = "";
    let startTime = Date.parse(start_time);
    let endTime = Date.parse(end_time);
    if (twelveHourFormat){
        timetext = hours12(startTime) + " - " + hours12(endTime);
    }
    else{
        timetext = hours24(startTime) + " - " + hours24(endTime);
    }

    return timetext;
}

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
    popoverInstances = [];
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
// Close any open popover when clicking outside

    // create a function which maps the time to an index in the table
    // starts at 8  (index[0] = 8:00)
    // last element is 18:00

    // filter the json_data for the given date
    filtered_json  = []
    Object.keys(json_data).forEach(element => {
       filtered_json.push(json_data[element].filter((item) => {
           return item["date"] === dateFilter;
        }));
       
    });

    // loop over each event in the  filtered_json
    for (let i=0;i<filtered_json.length;i++){
        for(let j=0;j<filtered_json[i].length;j++){
            let event_item = event_template.content.cloneNode(true);


            
            // change node content
            // need to add something so that student and lecturer events can be distinct (maybe a class?)
            let timetext = createTimeString(filtered_json[i][j]["start_time"], filtered_json[i][j]["end_time"]);
            
            event_item.querySelector(".class-time-text").innerText = timetext;
            event_item.querySelector(".class-title").innerText  = filtered_json[i][j]["course_title"];
            event_item.querySelector(".class-loc").innerText = filtered_json[i][j]["location_name"];

            time = Number(filtered_json[i][j]["start_time"].substring(0,2));
            index = time -8;
            
            if(filtered_json[i][j]["status"] === undefined){
                // wrap everything into an anchor
                let  aElement = document.createElement("a");
                aElement.setAttribute("href", "../staff-event/?id="+filtered_json[i][j]["timeslot_id"]);
                aElement.style.textDecoration = "none";
                aElement.classList.add("my-2");
                aElement.appendChild(event_item);
                tableElements[index].appendChild(aElement);
                return;
            }

            tableElements[index].appendChild(event_item);
            event_item = tableElements[index].lastElementChild;
            const popoverHTML = `
            <ul class="list-group"
                data-user-id="${filtered_json[i][j]["user_id"]}"
                data-timeslot-id="${filtered_json[i][j]["timeslot_id"]}">
                <li class="list-group-item list-group-item-action calendar-action absence-request">
                    Create Absence Request
                </li>
                <li class="list-group-item list-group-item-action calendar-action attendance-appeal">
                    Appeal Your Attendance
                </li>
            </ul>
        `;
            const popover = new bootstrap.Popover(event_item,{
                content: popoverHTML,
                html: true,
                placement: "bottom",
                trigger:"click",
                customClass: "custom-popover"
            })
            popoverInstances.push({ event_item, popover });
            event_item.classList.add(filtered_json[i][j]["status"].toLowerCase());
            event_item.dataset.userId = filtered_json[i][j]["user_id"];
            event_item.dataset.timeslotId = filtered_json[i][j]["timeslot_id"];
            event_item.dataset.status = filtered_json[i][j]["status"];
            event_item.dataset.appeal = filtered_json[i][j]["appeal"]
            
        }
    }   
    document.addEventListener("click", (event) => {
        popoverInstances.forEach(({event_item, popover }) => {
          const isClickInside =
            event_item.contains(event.target) ||
            (document.querySelector(".popover") &&
              document.querySelector(".popover").contains(event.target));
      
          if (!isClickInside) {
            popover.hide();
          }
        });
      });
 
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

    Object.keys(json_data).forEach(element => {
        json_data[element].forEach(event => {
            
            let event_item = event_template.content.cloneNode(true);

            // change node content
            // need to add something so that student and lecturer events can be distinct (maybe a class?)
            
            let timetext = createTimeString(event["start_time"], event["end_time"]);
            event_item.querySelector(".class-time-text").innerText = timetext;
            event_item.querySelector(".class-title").innerText  = event["course_title"];
            event_item.querySelector(".class-loc").innerText = event["location_name"];

            event_date = Date.parse(event["date"]);
            // It is not that simple. I forgot to account for weekends.
            index = days_between(event_date, start_date);

            if(event["status"] === undefined){
                // wrap everything into an anchor
                let  aElement = document.createElement("a");
                aElement.setAttribute("href", "../staff-event/?id="+event["timeslot_id"]);
                aElement.style.textDecoration = "none";
                aElement.classList.add("my-2");
                aElement.appendChild(event_item);
                tableElements[index].appendChild(aElement);
                return;
            }

            tableElements[index].appendChild(event_item);
            event_item = tableElements[index].lastElementChild;
            const popoverHTML = `
            <ul class="list-group">
                <li class="list-group-item list-group-item-action calendar-action absence-request">
                    Create Absence Request
                </li>
                <li class="list-group-item list-group-item-action calendar-action attendance-appeal">
                    Appeal Your Attendance
                </li>
            </ul>
        `;
            const popover = new bootstrap.Popover(event_item,{
                content: popoverHTML,
                html: true,
                placement: "bottom",
                trigger:"click",
                customClass: "custom-popover"
            })
            popoverInstances.push({ event_item, popover });
            event_item.classList.add(event["status"].toLowerCase());
            event_item.dataset.userId = event["user_id"];
            event_item.dataset.timeslotId = event["timeslot_id"];
            event_item.dataset.status = event["status"];
            event_item.dataset.appeal = event["appeal"]
        });
    });    
    document.addEventListener("click", (event) => {
        popoverInstances.forEach(({ event_item, popover }) => {
          const isClickInside =
            event_item.contains(event.target) ||
            (document.querySelector(".popover") &&
              document.querySelector(".popover").contains(event.target));
      
          if (!isClickInside) {
            popover.hide();
          }
        });
      });    
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
            try{
                populateDay(json_data, days[i], start_date.toString("yyyy-MM-dd"));
            }
            catch(e){
                console.log(e)
            }
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
                // console.log(json_data)
                clearCalendar(time);
                json_data = cleanData(json_data);
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
            error_message.classList.add("alert", "alert-danger");
            error_message.setAttribute("role", "alert");
            error_message.innerText = JSON.parse(this.responseText)["error"];
    
            document.querySelector("body").insertBefore(error_message, document.querySelector("body").firstChild);

        }
    };

    xmlhttp.open("POST", "./get-calendar-data.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("start_date="+start_date+"&end_date="+end_date);
}

function cleanData(json_data){
    let today = Date.today();
    today.setTimeToNow();
    Object.keys(json_data).forEach(user => {
        json_data[user].forEach(timeslot => {
            let timeslot_date_end = Date.parse(timeslot["date"]); 
            timeslot_date_end = timeslot_date_end.at(timeslot["end_time"]);
            let result = today.compareTo(timeslot_date_end);
            if(today.compareTo(timeslot_date_end) == -1 && timeslot["status"] == "Missed"){
                timeslot["status"] = "Upcoming";
            }
        });
    });
   return json_data; 
    
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
        let calendarDate = structuredClone(start_date);
        for(let i=0;i<cells.length;i++){
            cells[i].innerHTML = `${weekdays[i]}<br>${calendarDate.getDate()}`;
            calendarDate.addDays(1);
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
document.addEventListener('click',popoverActions)
function popoverActions(event){
    if(event.target.closest(".absence-request")){
        popoverInstances.forEach(instance =>{
            if(instance.popover._element.hasAttribute('aria-describedby')){
                const associatedEventItem = instance.popover._element;
                if(associatedEventItem.dataset.status==="Upcoming"){
                    instance.popover.hide();
                    showPopup("absence-popup");
                    currUser = parseInt(associatedEventItem.dataset.userId);
                    currTimeSlot = parseInt(associatedEventItem.dataset.timeslotId);
                }
                else{
                    const failBox = document.getElementById('request-fail');
                    let failDOM = document.importNode(failBox,true).content;
                    document.body.append(failDOM);
                    failDOM = document.body.lastElementChild;
                    const removeFail = setTimeout(()=>{
                        failDOM.remove();
                    },3500);
                }
            }
            
    })

    }
    else if(event.target.closest(".attendance-appeal")){
        popoverInstances.forEach(instance=>{
            if(instance.popover._element.hasAttribute('aria-describedby')){{
                const associatedEventItem = instance.popover._element;
                // console.log(parseInt(associatedEventItem.dataset.appeal))
                if(parseInt(associatedEventItem.dataset.appeal)===0 && associatedEventItem.dataset.status==="Missed"){
                    instance.popover.hide();
                    showPopup("appeal-popup");
                    currUser = parseInt(associatedEventItem.dataset.userId);
                    currTimeSlot = parseInt(associatedEventItem.dataset.timeslotId);
                }
                else{
                    const failBox = document.getElementById('appeal-fail');
                    let failDOM = document.importNode(failBox,true).content;
                    document.body.append(failDOM);
                    failDOM = document.body.lastElementChild;
                    const removeFail = setTimeout(()=>{
                        failDOM.remove();
                    },3500);
                }
            }
        }
    })}
}
function publishAbsence(){
    const data = { userid: currUser, timeslotid: currTimeSlot, status: "Missed" };
    fetch("../dashboard/set-attendance-data.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
        .then(response => response.text())  // Get response from PHP
        .then(result => console.log(result))
        .catch(error => console.error("Error:", error))
        .then(hidePopup())
        .then(displayAbsenceSuccess())

}
function displayAbsenceSuccess(){
    const succBox = document.getElementById('request-success');
    let succDOM = document.importNode(succBox,true).content;
    document.body.append(succDOM);
    succDOM = document.body.lastElementChild;
    const removeSucc = setTimeout(()=>{
        succDOM.remove()
    },3500);
}
function sendAppeal(){
    const appealContent = document.getElementById("appeal-form").value;
    if(!appealContent.trim()){
        const failBox = document.getElementById('appeal-empty');
        let failDOM = document.importNode(failBox,true).content;
        document.body.append(failDOM);
        failDOM = document.body.lastElementChild;
        const removeFail = setTimeout(()=>{
            failDOM.remove();
        },3500);
    }
    else{
        const message = appealContent.trim();
        const data = {userid: currUser, timeslotid: currTimeSlot, message: message};
        fetch("./set-appeal-data.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
            .then(response => response.text())  // Get response from PHP
            .then(result => console.log(result))
            .catch(error => console.error("Error:", error))
            .then(hidePopup())
            .then(displayAppealSuccess())
    }
}
function displayAppealSuccess(){
    const succBox = document.getElementById('appeal-success');
    let succDOM = document.importNode(succBox,true).content;
    document.body.append(succDOM);
    succDOM = document.body.lastElementChild;
    const removeSucc = setTimeout(()=>{
        succDOM.remove()
    },3500);
}
setDateToday();
