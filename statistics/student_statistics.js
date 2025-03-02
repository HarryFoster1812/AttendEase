import StatisticsCalculator from "../js/StatisticsCalculator.js";

function createAttendanceBar(labels, data){
    const ctx1 = document.getElementById('AttendanceBar').getContext('2d');
    // Create bar chart
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: labels, // Months
            datasets: [{
                label: 'Attendance (%)',
                data: data, // Example data
                backgroundColor: '#FFCC33', // Your primary color #660099
                borderColor: '#FFCC33',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Your percentage attendance over time',
                    color: '#FFCC33', // Title color
                    font: { size: 24, family: 'Convergence' } // Convergence font
                },
                legend: {
                    display: false // Hide legend
                }
            },
            scales: {
                x: {
                    ticks: { color: '#ffcc33',font: { size: 16, family: 'Convergence' } }
                },
                y: {
                    ticks: { color: '#ffcc33',font: { size: 16, family: 'Convergence' }},
                    beginAtZero: true,
                    max: 100

                }
            }
        }
    });
}

function createAttendanceLine(labels, data){
    const ctx2 = document.getElementById('AttendanceLine').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: labels, // Days of the week
            datasets: [{
                label: 'Attendance (%)',
                data: data, // Example Data
                borderColor: '#FFCC33', // Line Color
                backgroundColor: 'rgba(255, 204, 51, 0.2)', // Light fill under the line
                borderWidth: 2,
                pointBackgroundColor: '#FFCC33', // Point Color
                pointBorderColor: '#FFCC33',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Your attendance this week',
                    color: '#FFCC33',
                    font: { size: 24, family: 'Convergence' } // Convergence font, bigger size
                },
                legend: {
                    display: false // Hide legend
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#FFCC33',
                        font: { size: 16, family: 'Convergence' } // Convergence font for labels
                    }
                },
                y: {
                    ticks: {
                        color: '#FFCC33',
                        font: { size: 16, family: 'Convergence' } // Convergence font for labels
                    },
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

}


let xmlhttp = new XMLHttpRequest(); 

xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {

        try{
            console.log(this.responseText);
            let jsonData = JSON.parse(this.responseText);

            // send this data to a function to calculate statistics
            var statistics = new StatisticsCalculator(jsonData);
            statistics.processData();

            let totalEvents = statistics.totalEventCount;

            if (totalEvents == 0){
                document.getElementById("TotalAttended").innerText = "No Data";
                document.getElementById("MostAttended").innerText = "No Data";
                document.getElementById("TotalMissed").innerText = "No Data"; 
                document.getElementById("LeastAttened").innerText = "No Data";
                document.getElementById("TotalOnTime").innerText = "No Data";
                document.getElementById("Streak").innerText = "No Data";
                let BarCtx = document.getElementById("AttendanceBar").getContext("2d"); 
                BarCtx.font = "50px Arial"; 
                BarCtx.fillText("No Data", 10, 80); 

                let LineCtx =  document.getElementById("AttendanceLine").getContext("2d");
                LineCtx.font = "50px Arial";
                LineCtx.fillText("No Data", 10, 80);
               // display no data error 
            }

            else{
                document.getElementById("TotalAttended").innerText = statistics.totalAttended;
                document.getElementById("MostAttended").innerText = statistics.highestAttended;
                document.getElementById("TotalMissed").innerText = statistics.totalEventCount - statistics.attendedCount;
                document.getElementById("LeastAttened").innerText = statistics.lowestAttended;
                document.getElementById("TotalOnTime").innerText = statistics.onTimeCount;
                document.getElementById("Streak").innerText = statistics.streak;

                let dates = calculateCurrentWeek();
                let weekGraphData = statistics.currentWeekGraph(dates[0], dates[1]); 
                createAttendanceLine(weekGraphData[0], weekGraphData[1]);
                let monthData = statistics.calculateMonthData();
                createAttendanceBar(monthData[0], monthData[1]);
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


function calculateCurrentWeek(){
    let today = Date.today();
    if (today.is().weekday()){
       if(today.is().monday()){
            return [today.toString("yyyy-MM-dd"), today.next().friday().toString("yyyy-MM-dd")];
        }
        else if(today.is().friday()){
            return [structuredClone(today).previous().monday().toString("yyyy-MM-dd"), today.toString("yyyy-MM-dd")];
        }
        else{
            return [today.previous().monday().toString("yyyy-MM-dd"), today.next().friday().toString("yyyy-MM-dd")];
        }
    }
    else{

            return [today.previous().monday().toString("yyyy-MM-dd"), today.next().friday().toString("yyyy-MM-dd")];
    }
}
