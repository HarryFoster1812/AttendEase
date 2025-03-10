import StatisticsCalculator from "../js/StatisticsCalculator.js";

const canvas = document.getElementById('AttendanceChart');
const ctx = canvas.getContext('2d');

const moduleSelect = document.getElementById('ModuleDropdown');
const typeSelect = document.getElementById('TypeDropdown');

moduleSelect.addEventListener("change", onModuleChange);
typeSelect.addEventListener("change", onTypeChange);
var statistics;
var chart;

function addChart(labels, data, type){

    console.log(canvas);
    chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels, // Days of the week
            datasets: [
                {
                    label: type,
                    data: data, // Example Data for Course 2
                    borderColor: '#FF5733', // Orange-Red Line
                    backgroundColor: 'rgba(255, 87, 51, 0.2)', // Light Fill
                    borderWidth: 2,
                    pointBackgroundColor: '#FF5733',
                    pointBorderColor: '#FF5733',
                    pointRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Percentage attendance data over time',
                    color: '#FFCC33',
                    font: { size: 24, family: 'Convergence' } // Convergence font, bigger size
                },
                legend: {
                    display: true,
                    position: 'right', // Legend on the right
                    labels: {
                        color: 'white',
                        font: { size: 24, family: 'Convergence' },
                        boxWidth: 20,
                        borderWidth: 3, // Add border thickness
                        borderColor: 'white', // Legend border color
                        borderRadius: 10, // Curvy borders for the legend
                        padding: 10,
                        backgroundColor: '#660099'
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#FFCC33',
                        font: { size: 16, family: 'Convergence' }
                    }
                },
                y: {
                    ticks: {
                        color: '#FFCC33',
                        font: { size: 16, family: 'Convergence' }
                    },
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
}


function addModules(modules){
    moduleSelect.innerHTML = "";
    modules.forEach((module, index) => {
        moduleSelect.innerHTML += `<option ${index==0 ? "selected" : ""}>${module}</option>`; 
    });

    let event = new Event("change");
    moduleSelect.dispatchEvent(event);
}

function onModuleChange(){
    // get the all unique types
    // change types inner html
    // dispach type change event
    typeSelect.innerHTML = "<option selected>All</option>";
    let selectedModule = moduleSelect.value;
    let typesList = statistics.getTypeList(selectedModule);
    typesList.forEach(type => {
        typeSelect.innerHTML += `<option>${type}</option>`;
    });

    let event = new Event("change");
    typeSelect.dispatchEvent(event);
}


function onTypeChange(){
    // get the current type
    // recalculate data
    // display data
    let tempType = "*";
    if(typeSelect.value !== "All"){
        tempType = typeSelect.value;
    }

    let graph_data = statistics.calculateStaffData(moduleSelect.value, tempType);

    if (chart === undefined){
        addChart(graph_data[0], graph_data[1], typeSelect.value);
    }

    else{
        console.log(typeSelect.va);
        chart.data.labels = graph_data[0];
        chart.data.datasets[0].data = graph_data[1];
        chart.data.datasets[0].label = typeSelect.value;
        chart.update();
    }
}

let xmlhttp = new XMLHttpRequest(); 

xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {

        try{
            let jsonData = JSON.parse(this.responseText);
            console.log(jsonData);
            statistics = new StatisticsCalculator(jsonData);
            statistics.processStaffData();
            console.log(statistics.getModuleList());
            addModules(statistics.getModuleList());
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
