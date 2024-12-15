document.getElementById("table_slider").checked=false;
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
}
