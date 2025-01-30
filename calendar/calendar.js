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

function clearCalendar(){

}

function populateCalendar(json_data){
    
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
    if (Date.isLeapYear(20081900+date.getYear())){
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
        // i dont know what start date you want from me. 
        // Do i just go for 1st of the month and last of the month?
        // Do i do the first monday closest to the first and friday closest to the end?
        const firstMonday = structuredClone(date).first().monday();
        start_date = firstMonday;
        console.log(firstMonday);
        const firstMonthDay = structuredClone(date).moveToFirstDayOfMonth();
        if(firstMonday.getDate()>3){
            start_date = firstMonday.addDays(-7);
        }
        const lastFriday = structuredClone(date).last().friday();
        end_date = lastFriday;
        const lastMonthDay = structuredClone(date).moveToLastDayOfMonth();
        if(lastFriday.getDate()!=lastMonthDay.getDate()){
            console.log("ehigfejiejfiejeifjeifjdjiefji",lastFriday.getDate(),lastMonthDay.getDate())
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

    // NEED TO FINISH THIS 
    // NEED TO FINISH
    if (start_date == end_date){
        date_header.innerText = convertSoloDate(start_date);
    }

    else{
        date_header.innerText = convertDate(start_date, end_date);
    }



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
    if (Date.isLeapYear(20081900+start_date.getYear())){
        monthBounds[1]+=1;
    }
    const monthChosen = start_date.getMonth();

    let dateDay =start_date.getDate();

    if(period=="Day"){
        const timeTableDay = document.getElementById('timetable-day');
        const cell = Array.from(timeTableDay.querySelectorAll('th'))[1];
        cell.innerHTML = `${dateDayOfWeek}<br>${String(dateDay)}`;
    }
    else if(period=="Week"){
        const timeTableWeek = document.getElementById('timetable-week');
        const cells = Array.from(timeTableWeek.querySelectorAll('th')).slice(1,6);
        console.log(cells)
        for(let i=0;i<cells.length;i++){
            cells[i].innerHTML = `${weekdays[i]}<br>${dateDay}`;
            dateDay+=1;
        }
    }
    else{
        const timeTableMonth = document.getElementById('timetable-month');
        const cells = Array.from((timeTableMonth.querySelectorAll('.calendar-date')));
        for(let i=0;i<cells.length;i++){

            cells[i].innerHTML = `${dateDay}`;
            dateDay+=1;
            if(dateDay>monthBounds[monthChosen]){
                dateDay=1;
            }
            if(i%5==4){
                dateDay+=2;
            }
            if(dateDay>monthBounds[monthChosen]){
                dateDay=1;
            }
        }
    }
}

setDateToday();