import StatisticsCalculator from "../../js/StatisticsCalculator.js";


const classLists = document.querySelectorAll('.class-block-list');


const rows = document.querySelectorAll('.outer');

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

const classBlock = `<div class="col-md-6 col-xl-4 class-block-container gap-3">
<div class="class-block bg-primary mb-4 text-secondary shrink">
<div class="p-4">
<div class="row class-block-upper mb-2">
<div class="col-6 class-code">
<h4>comp16321</h4>
</div>
<div class="colzzzzzz-6 class-time">
<h4>09:00 - 10:00</h4>
</div>
</div>
<div class="row class-block-mid mb-2">
<div class="col-6 class-type">
<h4>workshop</h4>
</div>
<div class="col-6 class-day">
<h4>tuesday</h4>
</div>
</div>
<div class="row class-block-lower">
<div class="class-venue">
<h4>kilburn th 1.1</h4>
</div>
</div>
<div class='row class-attend-block mt-2 d-none'>
<button class="btn btn-primary rounded-pill"><h4 class='text-secondary'>attend</h4></button>
</div>
</div>
</div> 
</div>
`

for(let i=0;i<6;i++){
   
    for(const list of classLists){
        list.insertAdjacentHTML('beforeend',classBlock);
        const classElement = list.lastElementChild.querySelector('.class-block');;
        classElement.addEventListener('click', toggleClassClick);
    }
}


// Reusable chart creation function
function createDoughnutChart(ctx, data, label1, label2) {
    return new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: [],
            datasets: [{
                data: data,
                backgroundColor: ["#660099", "#ededed"],
                hoverBackgroundColor: ["#7a00b3", "#ededed"]
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
                ctx.fillStyle = "#660099";

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

            createDoughnutChart(attendanceChart, [totalAttended/totalEvents ,1- totalAttended/totalEvents], `${Math.round((totalAttended/totalEvents)*100)}%`, "Attendance");
            createDoughnutChart(timeChart, [totalOnTime/totalEvents ,1- totalOnTime/totalEvents], `${Math.round((totalOnTime/totalEvents)*100)}%`, "On Time");
            createDoughnutChart(rankChart, [100,0],`10%`, "Ranking");
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


