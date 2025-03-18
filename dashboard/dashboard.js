import StatisticsCalculator from "../js/StatisticsCalculator.js";


const classLists = document.querySelectorAll('.class-block-list');
const roleId  = Number(document.body.dataset.roleId);
let userId;
const rows = document.querySelectorAll('.outer');
var dashStyles;
let chartNames = ["Attendance", "On Time","Ranking"];
if(Cookies.get("darkMode") != undefined){
    dashStyles = ["#ffcc33",'#eaab00','#333333'];
}
else{
    dashStyles = ["#660099",'#7a00b3','#ededed'];
}

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

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if(entry.isIntersecting) {
            entry.target.style.transform = 'translateX(0)';
            entry.target.style.transition = 'transform 0.8s ease';
        }

    });
},{
        root:null, rootMargin: '0px', threshold:0.35
    }
);
rows.forEach((row,idx) =>{
    // console.log(row,idx)
    if(idx%2){
        row.style.transform = 'translateX(10vh)';
    }
    else{
        row.style.transform = 'translateX(-10vh)';
    }

    setTimeout(()=>{
        observer.observe(row);
    },50)
})
const toggleClassClick = function(event){
    const button = this.querySelector('.class-attend-block .btn');
    if(event.target.closest("button")){
        toggleAttend(event.target.closest(".class-block"));
    }
    else{
        const buttonBlock = this.querySelector('.class-attend-block');
        buttonBlock.classList.toggle('d-none');
        this.classList.toggle('bg-primary');
        this.classList.toggle('bg-secondary');
        this.classList.toggle('text-primary');
        this.classList.toggle('text-secondary');
        this.classList.toggle('expand');
    }


}



function addEvent(event_info){
    // console.log(event_info);
    const classBlock = `<div class="col-md-6 col-xl-4 class-block-container gap-3">
                            <div class="class-block bg-primary mb-4 text-secondary shrink" data-ae-name="${event_info["name"]}" data-ae-user="${event_info["user_id"]}" data-ae-timeslot="${event_info["timeslot_id"]}">
                                <div class="p-4">
                                    <div class="row class-block-upper mb-2">
                                        <div class="col-6 class-code">
                                            <h4>${event_info["course_title"]}</h4>
                                        </div>
                                        <div class="col-6 class-time">
                                            <h4>${createTimeString(event_info["start_time"], event_info["end_time"])}</h4>
                                        </div>
                                    </div>
                                    <div class="row class-block-mid mb-2">
                                        <div class="col-6 class-day">
                                            <h4>${event_info["date"]}</h4>
                                        </div>
                                    </div>
                                    <div class="row class-block-lower">
                                        <div class="class-venue">
                                            <h4>${event_info['location_name']}</h4>
                                        </div>
                                    </div>
                                    <div class='row class-attend-block mt-2 d-none'>
                                        <button class="btn btn-primary rounded-pill">
                                            <h4 class='text-secondary'>ATTEND</h4>
                                        </button>
                                    </div>
                                </div>
                            </div> 
                        </div>`

    classLists[0].insertAdjacentHTML('beforeend',classBlock);
    
    const classElement = classLists[0].lastElementChild.querySelector('.class-block');
    // console.log(classElement,classElement.dataset);
    if(event_info["status"]==="Upcoming"){
        const upcomingCode = `
        <div class="col-6 class-status">
            <span><i class="fa-solid fa-clock me-2"></i><h4 style="display:inline">UPCOMING</h4></span>
        </div>
        `
        classElement.querySelector('.class-block-mid').insertAdjacentHTML('beforeend',upcomingCode);
        const startTime = new Date(event_info["date"]+"T"+event_info["start_time"]);
        const endTime = new Date(event_info["date"]+"T"+event_info["end_time"]);
        const currTime = Date.now()
        // console.log(startTime,currTime,endTime);
        if(startTime<=currTime && currTime<=endTime){
            classElement.addEventListener('click', toggleClassClick);
            // console.log("SUCCESS")
        }
        
    }
    else{
        const attendCode = `
        <div class="col-6 class-status">
            <span><i class="fa-solid fa-circle-check me-2 text-success"></i><h4 style="display:inline">ATTENDED</h4></span>
        </div>
        `
        classElement.querySelector('.class-block-mid').insertAdjacentHTML('beforeend',attendCode);
    }
    
}


function addStaffEvent(event_info){
    // console.log(event_info);
    const classBlock = `<a href="../staff-event/?id=${event_info["timeslot_id"]}" style="text-decoration:none;" class="col-md-6 col-xl-4 class-block-container gap-3">
                                <div class="class-block bg-primary mb-4 text-secondary shrink" data-ae-name="${event_info["name"]}" data-ae-user="${event_info["user_id"]}" data-ae-timeslot="${event_info["timeslot_id"]}">
                                    <div class="p-4">
                                        <div class="row class-block-upper mb-2">
                                            <div class="col-6 class-code">
                                                <h4>${event_info["course_title"]}</h4>
                                            </div>
                                            <div class="col-6 class-time">
                                                <h4>${createTimeString(event_info["start_time"], event_info["end_time"])}</h4>
                                            </div>
                                        </div>
                                        <div class="row class-block-mid mb-2">
                                            <div class="col-6 class-day">
                                                <h4>${event_info["date"]}</h4>
                                            </div>
                                        </div>
                                        <div class="row class-block-lower">
                                            <div class="class-venue">
                                                <h4>${event_info['location_name']}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                        </a>`

    classLists[0].insertAdjacentHTML('beforeend',classBlock);
    
    const classElement = classLists[0].lastElementChild.querySelector('.class-block');
    // console.log(classElement,classElement.dataset);
    classElement.addEventListener('click', toggleClassClick);
}

// Reusable chart creation function
function createDoughnutChart(ctx, data, label1, label2) {
    return new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: [],
            datasets: [{
                data: data,
                backgroundColor: [dashStyles[0],dashStyles[2]],
                hoverBackgroundColor: [dashStyles[1],dashStyles[2]]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: "80%",
            plugins: {
                legend: { display: false },
                tooltip: { enabled: false }
            },
            layout: {
                padding: { top: 0, bottom: 0 }
            }
        },
        plugins: [{
            beforeDraw: function (chart) {
                const width = chart.width,
                height = chart.height,
                ctx = chart.ctx;

                ctx.restore();
                let fontSize = (height / 6).toFixed(2);
                ctx.font = fontSize + "px convergence";
                ctx.textBaseline = "middle";
                ctx.fillStyle = dashStyles[0];

                // Draw percentage
                const text1 = label1, // Custom text inside the chart
                textX1 = Math.round((width - ctx.measureText(text1).width) / 2),
                textY1 = height * 0.4;
                ctx.fillText(text1, textX1, textY1);
                ctx.save();

                // Draw label
                fontSize = (height / 12).toFixed(2);
                ctx.font = fontSize + "px convergence";
                const text2 = label2, // Custom label inside the chart
                textX2 = Math.round((width - ctx.measureText(text2).width) / 2),
                textY2 = height * 0.6;
                ctx.fillText(text2, textX2, textY2);
                ctx.save();
            }
        }]
    });
}

// send a request for the user statistics
let xmlhttp = new XMLHttpRequest(); 

xmlhttp.onreadystatechange = function() {
    
    if (this.readyState == 4 && this.status == 200) {

        try{
            // console.log(this.responseText);
            let jsonData = JSON.parse(this.responseText);
            userId = parseInt(jsonData[0]["user_id"])


            // send this data to a function to calculate statistics
            var statistics = new StatisticsCalculator(jsonData);
            if(roleId == 2 || roleId == 3){ 
                statistics.processStaffData();
                let totalAttended = statistics.attendedCount;
                let totalEvents = statistics.assignedCount;
                let percentageDiff = statistics.getWeekDifference();
                
                let timeDiv = timeChart.parentElement;
                timeDiv.removeChild(timeChart);
                let percentText = document.createElement("h3");
                let parentTextDiv = document.createElement("div");
                parentTextDiv.classList.add("d-flex", "flex-column", "w-auto", "justify-content-center","align-items-center");

                timeDiv.classList.add("d-flex","justify-content-center","align-items-center");

                percentText.innerText = percentageDiff + "%";
                percentText.style.color = percentageDiff > -1 ? "#32cd32" : "#ff0000";
                percentText.style.fontSize = "50px";
                
                let additionalText = document.createElement("p");
                additionalText.innerText = "Attendance Delta";
                if(percentageDiff>0){
                    percentText.insertAdjacentHTML('beforeend','<i class="fa-solid fa-chevron-up mx-2"></i>')
                }
                else if(percentageDiff<0){
                    percentText.insertAdjacentHTML('beforeend','<i class="fa-solid fa-chevron-down mx-2"></i>')
                }
                else{
                    percentText.insertAdjacentHTML('beforeend','<i class="fa-solid fa-minus mx-2"></i>')
                }
                additionalText.classList.add("attendance-delta")
                parentTextDiv.appendChild(percentText);
                parentTextDiv.appendChild(additionalText);
                timeDiv.appendChild(parentTextDiv);
                

                if (totalEvents == 0){
                    createDoughnutChart(attendanceChart, [0 ,100], `0%`, chartNames[0]);
                }

                else{
                    createDoughnutChart(attendanceChart, [totalAttended/totalEvents ,1- totalAttended/totalEvents], `${Math.round((totalAttended/totalEvents)*100)}%`, chartNames[0]);
                }
            }
            else{
                statistics.processData();

                let totalAttended = statistics.attendedCount;
                let totalEvents = statistics.totalEventCount;
                let totalOnTime = statistics.onTimeCount;
                if (totalEvents == 0){
                    createDoughnutChart(attendanceChart, [0 ,100], `0%`, chartNames[0]);
                    createDoughnutChart(timeChart, [0 , 100], `0%`, chartNames[1] );
                }

                else{
                    createDoughnutChart(attendanceChart, [totalAttended/totalEvents ,1- totalAttended/totalEvents], `${Math.round((totalAttended/totalEvents)*100)}%`, chartNames[0]);
                    createDoughnutChart(timeChart, [totalOnTime/totalEvents ,1- totalOnTime/totalEvents], `${Math.round((totalOnTime/totalEvents)*100)}%`, chartNames[1] );
                }
            }
        }
        catch(e){
            // display error message
            console.log(e.message);
            createDoughnutChart(attendanceChart, [0 ,100], `N/A`, chartNames[0]);
            createDoughnutChart(timeChart, [0 , 100], `N/A`, chartNames[1] );
            createDoughnutChart(rankChart, [0 , 100], ` N/A`, chartNames[2] );
        }
    }
    else if (this.status==400){
        console.log(JSON.parse(this.responseText)["error"]);
    }
};

xmlhttp.open("POST", "../php/get-statistics-data.php", true);
xmlhttp.send();



document.addEventListener("DOMContentLoaded", function () {
    // Create charts
    
    const attendanceChart = document.getElementById("attendanceChart").getContext("2d");
    const timeChart = document.getElementById("timeChart").getContext("2d");
    const rankChart = document.getElementById("rankChart").getContext("2d");

});

var calendarAjax = new XMLHttpRequest();

calendarAjax.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        // update the calendar
        try{
            let json_data = JSON.parse(this.responseText);
            // console.log("TTJSON",json_data)
            json_data = cleanData(json_data);
            if (Object.keys(json_data).includes("student")){

                json_data["student"].forEach(element => {
                    addEvent(element);
                });
            }

            if (Object.keys(json_data).includes("staff")){
                json_data["staff"].forEach(element => {
                    addStaffEvent(element);
                });
            }
            if (classLists[0].childElementCount == 0){
                // add a message: no events today
                classLists[0].innerHTML = `<p class="text-primary no-dash-class" style="text-align:center">You have no events scheduled for today.</p>`;
            }

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

calendarAjax.open("POST", "../calendar/get-calendar-data.php", true);
calendarAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
calendarAjax.send("start_date="+Date.today().toString("yyyy-MM-dd")+"&end_date="+Date.today().toString("yyyy-MM-dd"));

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

async function runLeaderboard(){
    try{
        const response = await fetch("../leaderboard/get-leaderboard-data.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
        });
        if(!response.ok){
            throw new error(`Response status ${response.status}`);
        }
        const json_data = await response.json();
        // console.log(json_data)
        const lstatistics = new StatisticsCalculator(json_data);
        lstatistics.processLeaderboardData();
        const userIndex = [...lstatistics.leaderboard_data].findIndex(element=>element[0]==userId);
        if(lstatistics.leaderboard_data.get(userId).classes===0){
            createDoughnutChart(rankChart, [0,100], "100%", chartNames[2]);
        }
        else{
            const rank = ((userIndex+1)/[...lstatistics.leaderboard_data].length)*100;
            createDoughnutChart(rankChart, [rank , 100-rank], rank+"%", chartNames[2]);
        }
       
    }
    catch(error){
        console.error(error.message);
    }
}
runLeaderboard()
