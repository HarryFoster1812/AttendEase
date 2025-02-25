import StatisticsCalculator from "../js/StatisticsCalculator.js";


const classLists = document.querySelectorAll('.class-block-list');


const rows = document.querySelectorAll('.outer');
var dashStyles;
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
    console.log(row,idx)
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
    console.log(event.target);
    const buttonBlock = this.querySelector('.class-attend-block');
    buttonBlock.classList.toggle('d-none');
    this.classList.toggle('bg-primary');
    this.classList.toggle('bg-secondary');
    this.classList.toggle('text-primary');
    this.classList.toggle('text-secondary');
    this.classList.toggle('expand');

}



function addEvent(event_info){
    const classBlock = `<div class="col-md-6 col-xl-4 class-block-container gap-3">
                            <div class="class-block bg-primary mb-4 text-secondary shrink">
                                <div class="p-4">
                                    <div class="row class-block-upper mb-2">
                                        <div class="col-6 class-code">
                                            <h4>${event_info["course_title"]}</h4>
                                        </div>
                                        <div class="colzzzzzz-6 class-time">
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
                                            <h4 class='text-secondary'>attend</h4>
                                        </button>
                                    </div>
                                </div>
                            </div> 
                        </div>`

    classLists[0].insertAdjacentHTML('beforeend',classBlock);
    const classElement = classLists[0].lastElementChild.querySelector('.class-block');;
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
            console.log(this.responseText);
            let jsonData = JSON.parse(this.responseText);

            // send this data to a function to calculate statistics
            var statistics = new StatisticsCalculator(jsonData);
            console.log(statistics);
            let totalAttended = statistics.attendedCount;
            let totalEvents = statistics.totalEventCount;
            let totalOnTime = statistics.onTimeCount;
            if (totalEvents == 0){
                createDoughnutChart(attendanceChart, [0 ,100], `0%`, "Attendance");
                createDoughnutChart(timeChart, [0 , 100], `0%`, "On Time");
                createDoughnutChart(rankChart, [0,100],`0%`, "Ranking");
            }

            else{
                createDoughnutChart(attendanceChart, [totalAttended/totalEvents ,1- totalAttended/totalEvents], `${Math.round((totalAttended/totalEvents)*100)}%`, "Attendance");
                createDoughnutChart(timeChart, [totalOnTime/totalEvents ,1- totalOnTime/totalEvents], `${Math.round((totalOnTime/totalEvents)*100)}%`, "On Time");
                createDoughnutChart(rankChart, [100,0],`0%`, "Ranking");
            }
        }
        catch(e){
            // display error message
            console.log(e.message);
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

            if (Object.keys(json_data).includes("student")){

                json_data["student"].forEach(element => {
                    addEvent(element);
                });
            }

            if (Object.keys(json_data).includes("staff")){
                json_data["staff"].forEach(element => {
                    addEvent(element);
                });
            }
            if (classLists[0].childElementCount == 0){
                // add a message: no events today
                classLists[0].innerHTML = `<p class="text-primary" style="text-align:center">You have no events scheduled for today.</p>`;
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

calendarAjax.open("POST", "/calendar/get-calendar-data.php", true);
calendarAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
calendarAjax.send("start_date="+Date.today().toString("yyyy-MM-dd")+"&end_date="+Date.today().toString("yyyy-MM-dd"));
