
const classLists = document.querySelectorAll('.class-block-list');
console.log(classLists);


const rows = document.querySelectorAll('.outer');
var dashStyles;


const observer = new IntersectionObserver(entries => {
    entries.forEach((entry,idx) => {
        if(entry.isIntersecting) {
            entry.target.style.transform = 'translateX(0)';
            entry.target.style.transition = 'transform 0.8s ease';
        }
        else{
            entry.target.style.transform = 'translateX(0)';
            entry.target.style.transition = 'transform 0.8s ease';


        }
    });
},{
    root:null, rootMargin: '0px', threshold:0.5
}
);
rows.forEach((row,idx) =>{
    row.style.transform = 'transform 0.8s ease'
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
for(let i=0;i<6;i++){
    const classBlock = `
<div class="col-md-6 col-xl-4 class-block-container gap-3">
    <div class="class-block bg-primary mb-4">
        <div class="p-4">
            <div class="row class-block-upper mb-2">
                <div class="col-6 class-code">
                    <h4>COMP16321</h4>
                </div>
                <div class="col-6 class-time">
                    <h4>09:00 - 10:00</h4>
                </div>
            </div>
            <div class="row class-block-mid mb-2">
                <div class="col-6 class-type">
                    <h4>Workshop</h4>
                </div>
                <div class="col-6 class-day">
                    <h4>Tuesday</h4>
                </div>
            </div>
            <div class="row class-block-lower">
                <div class="class-venue">
                    <h4>Kilburn TH 1.1</h4>
                </div>
            </div>
        </div>
    </div> 
</div>
`
    for(const list of classLists){
        console.log(list);
        list.insertAdjacentHTML('beforeend',classBlock);
    }
}





document.addEventListener("DOMContentLoaded", function () {
    const isDark = true;            //Set this to the value stored in the cookie
    if(!isDark){
        dashStyles = ["#660099",'#7a00b3','#ededed']
    }
    else{
        dashStyles = ["#ffcc33",'#eaab00','#333333']
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
                    hoverBackgroundColor: [dashStyles[1], dashStyles[2]]
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

    // Create charts
    const attendanceChart = document.getElementById("attendanceChart").getContext("2d");
    const timeChart = document.getElementById("timeChart").getContext("2d");
    const rankChart = document.getElementById("rankChart").getContext("2d");

    createDoughnutChart(attendanceChart, [70, 30], "70%", "Attendance");
    createDoughnutChart(timeChart, [80, 20], "80%", "On Time");
    createDoughnutChart(rankChart, [92, 8], "92%", "Ranking");
});


