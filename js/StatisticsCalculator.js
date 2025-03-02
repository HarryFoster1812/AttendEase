import "../js/date.js";

export default class StatisticsCalculator { data;
    totalAttended;
    totalOnTime;
    totalEvents;
    hightAttended;
    lowestAttended;
    streak;
    graphDataThisWeek;
    graphDataAllWeeks;
    hoursAttended;
    hoursScheduled;

    constructor(json_data) {
        this.data = json_data;
        this.totalAttended=0;
        this.totalOnTime=0;
        this.hightAttended=0;
        this.lowestAttended=0;
        this.streak=0;
        this.hoursAttended=0;
        this.hoursScheduled = 0;
        this.graphDataThisWeek=0;
        this.graphDataAllWeeks=0;
        this.totalEvents = this.data.length;
    } 

    processData(){ 
        let tmpStreak = 0;
        let attendanceCounts = {};
        let tempHighest = {course: "", count: 0};
        let tempLowest = {course: "", count: Infinity};

        this.data.forEach(element => { // check if course is in attendanceCounts 

            if (!(element["course_title"] in attendanceCounts)){ 
                attendanceCounts[element["course_title"]] = [0, 0];
            }

            if (element.status == "Attended"){ 
                this.totalAttended++;
                this.totalOnTime++;
                tmpStreak++;
                attendanceCounts[element["course_title"]][0]++;
                this.hoursAttended += StatisticsCalculator.calculateTimeDifference(element["start_time"], element["end_time"]);
            } 
            else if (element.status == "Late"){ 
                this.totalAttended++;
                tmpStreak++;
                attendanceCounts[element["course_title"]][0]++;
                this.hoursAttended += StatisticsCalculator.calculateTimeDifference(element["start_time"], element["end_time"]);
            } 

            else{ 
                tmpStreak = 0;
            } 

            attendanceCounts[element["course_title"]][1]++; // increment the number of classes for the course 
            this.hoursScheduled += StatisticsCalculator.calculateTimeDifference(element["start_time"], element["end_time"]);

            this.streak = Math.max(this.streak, tmpStreak);
        });
        // find highest and lowest attendance 
        for (let course in attendanceCounts) { 
            const [attendedCount, totalClassesCount] = attendanceCounts[course];

            // Check for highest attended course 
            if ((attendedCount/totalClassesCount)*100 > tempHighest.count) { 
                tempHighest = { course, count: (attendedCount/totalClassesCount)*100 };
            } 
            // Check for lowest attended course 
            if ((attendedCount/totalClassesCount)*100 < tempLowest.count) { 
                tempLowest = { course, count: (attendedCount/totalClassesCount)*100 };
            } 

        } 
        this.hightAttended = tempHighest.course;
        this.lowestAttended = tempLowest.course;

        // need to do graphData somehow. we need to know week data (eg. which weeks are are arent academic)
    }

    calcualteWeekData(week_start, week_end, target_module="*"){
        // for target module pass "*" for all
        // if targeting a module pass a string not an array
        let temp_data = structuredClone(this.data);
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        let week_data = {
            "Monday": [0, 0], 
            "Tuesday": [0, 0], 
            "Wednesday": [0, 0], 
            "Thursday": [0, 0], 
            "Friday": [0, 0]
        }

        if(target_module != "*"){
            temp_data.forEach((event) => {
                if(event["course_title"] === target_module){
                    if(Date.parse(event["date"]).between(Date.parse(week_start),Date.parse(week_end))){
                        let d = new Date(event["date"]);
                        let dayName = days[d.getDay()];

                        if(event.status == "Attended"){week_data[dayName][0] ++;}
                        week_data[dayName][1]++;

                    }
                }
            });
        }

        else{
            temp_data.forEach((event) => {
                if(Date.parse(event["date"]).between(Date.parse(week_start),Date.parse(week_end))){
                    let d = new Date(event["date"]);
                    let dayName = days[d.getDay()];

                    if(event.status == "Attended"){week_data[dayName][0] ++;}
                    week_data[dayName][1]++;

                }
            }); 
        }


        //we assume that the data is already sorted by ascending date
        return week_data;

    }

    calculateMonthData(){
        // go through each month, if there is data then
        // start september end june
        let months = ["September", "October", "November", "December", "January", "Feburary", "March", "April", "May", "June", "July", "August"]
        
        let month_map = {
            "09":0, 
            "10":1, 
            "11":2, 
            "12":3, 
            "01":4, 
            "02":5, 
            "03":6, 
            "04":7, 
            "05":8, 
            "06":9, 
            "07":10, 
            "08":11 
        };
        
        let month_data = [[0,0], [0,0], [0,0], [0,0], [0,0], [0,0], [0,0], [0,0], [0,0], [0,0], [0,0], [0,0]];
        this.data.forEach((event) => {
            let month_index = month_map[event["date"].split("-")[1]];     
            month_data[month_index][1]++;
            if(event["status"] === "Attended" || event["status"] === "Late"){
                month_data[month_index][0]++;
            }
        });

        let percentages = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        for (let i=0;i<months.length;i++){
            try{
                let percentage = Math.floor((month_data[i][0] / month_data[i][1])*100); 
                percentages[i] = percentage;
            }
            catch{
                percentages[i] = 0;
            }
        };

        return [months, percentages];
    }

    calculateStaffData(moduleName){
        // filter for the module
        // get each class data
        // filter for each week
    }


    static calculateTimeDifference(start_time, end_time){
        const hourMs = 1000*60*60; 
        start_time = Date.parse(start_time);
        end_time = Date.parse(end_time);
        let differenceMs = end_time - start_time;
        return differenceMs/hourMs;
    }

    get attendedCount(){
        return this.totalAttended;
    }

    get onTimeCount(){
        return this.totalOnTime;
    }

    get totalEventCount(){
        return this.totalEvents;
    }

    get hoursAttended(){
        return this.hoursAttended;
    }

    get highestAttended(){
        return this.hightAttended;
    }

    get lowestAttended(){
        return this.lowestAttended;
    }
    
    get hoursScheduled(){
        return this.hoursScheduled;
    }

    get streak(){
        return this.streak;
    }

    currentWeekGraph(week_start, week_end, target_module="*"){
        let return_data = this.calcualteWeekData(week_start, week_end, target_module="*");
        // unpack the list into two arrays one of labels and one of data
        let labelsArry = [];
        let dataArry = [];


        for(var day in return_data){
            // look through and replace any 0% with 100%
            if(return_data[day][1] == 0){
                dataArry.push(0);
            }
            else{
                dataArry.push(Math.floor((return_data[day][0] / return_data[day][1])*100));
            }
            labelsArry.push(day);
        }

        return [labelsArry, dataArry];
    }

}
