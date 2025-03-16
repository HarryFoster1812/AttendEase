import "../js/date.js";

export default class StatisticsCalculator { data;
    totalAttended;
    totalAssigned;
    totalOnTime;
    totalEvents;
    hightAttended;
    lowestAttended;
    streak;
    graphDataThisWeek;
    graphDataAllWeeks;
    hoursAttended;
    hoursScheduled;
    module_data;

    constructor(json_data) {
        this.data = json_data;
        this.totalAssigned = 0;
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
        this.leaderboard_data = new Map()
    } 

    processLeaderboardData(){ 
        this.data.forEach(element => { // check if course is in attendanceCounts 
            if(!this.leaderboard_data.has(element.user_id)){
                this.leaderboard_data.set(element.user_id,{
                    streak: 0,
                    attendance: 0,
                    onTime: 0,
                    classes: 0,
                    name: element.name,
                    tempStreak: 0
                })
            }
            if (element.status == "Attended"){ 
                this.leaderboard_data.get(element.user_id).attendance+=1;
                this.leaderboard_data.get(element.user_id).onTime+=1;
                this.leaderboard_data.get(element.user_id).tempStreak+=1;
            } 
            else if (element.status == "Late"){ 
                this.leaderboard_data.get(element.user_id).attendance+=1;
                this.leaderboard_data.get(element.user_id).tempStreak+=1;
            } 

            else{ 
                this.leaderboard_data.get(element.user_id).tempStreak=0;
            } 

            this.leaderboard_data.get(element.user_id).streak = Math.max(this.leaderboard_data.get(element.user_id).streak,this.leaderboard_data.get(element.user_id).tempStreak);
            this.leaderboard_data.get(element.user_id).classes+=1;
        });
        this.leaderboard_data = new Map([...this.leaderboard_data].sort((a, b) => {
            const aValue = a[1]; 
            const bValue = b[1]; 
        
            // Compare streaks
            if (aValue.streak > bValue.streak) return -1;
            if (aValue.streak < bValue.streak) return 1;
        
            // Compare onTime
            if (aValue.onTime > bValue.onTime) return -1;
            if (aValue.onTime < bValue.onTime) return 1;
        
            // Compare attendance ratio
            const aAttendanceRatio = aValue.attendance / aValue.classes;
            const bAttendanceRatio = bValue.attendance / bValue.classes;
            if (aAttendanceRatio > bAttendanceRatio) return -1;
            if (aAttendanceRatio < bAttendanceRatio) return 1;
        
            return 0;
        }));
        
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

    calculateStaffData(moduleName, type="*"){
        if(type === "*"){
            // go through each date
            let dates = {};
            Object.keys(this.module_data[moduleName]).forEach(moduleType => {
                Object.keys(this.module_data[moduleName][moduleType]).forEach(date => {

                    let date_attendance = this.module_data[moduleName][moduleType][date][0]; 
                    let date_total      = this.module_data[moduleName][moduleType][date][1]; 
                    if(Object.keys(dates).includes(date)){
                        dates[date][0] += date_attendance;
                        dates[date][1] += date_total;
                    }
                    else{
                        dates[date] = [date_attendance, date_total];
                    }
                    
                });
            });

            // go through the dates and convert them into an array of dates and percentages

            let date_percentage_array = Object.keys(dates).map((key) => {
                return [key, Math.floor((dates[key][0]/dates[key][1])*100)]
            })

            // sort the dates
            date_percentage_array.sort((date, percentage)=>{
                return Date.parse(date);
            });
            

            // split into parallel arrays

            let date_array = [];
            let percentage_array = [];

            for(let i=0;i<date_percentage_array.length;i++){
                date_array.push(date_percentage_array[i][0]);
                percentage_array.push(date_percentage_array[i][1]);
            }

            return [date_array, percentage_array];
        }

        let percentages = []
        Object.keys(this.module_data[moduleName][type]).forEach((date, index) => {
            let date_attendance = this.module_data[moduleName][type][date][0]; 
            let date_total      = this.module_data[moduleName][type][date][1]; 
            percentages[index] = Math.round((date_attendance / date_total)*100)
        });
        return [Object.keys(this.module_data[moduleName][type]), percentages]; 
    }

    processStaffData(){
        this.module_data = {};
        this.data.forEach(event => {
            let course = event["course_title"]; 
            let type = event["type"]; 
            let date = event["date"]; 
            let attendedCount = event["total_attended"];
            let totalAssigned = event["total_assigned"];

            this.totalAttended += attendedCount;
            this.totalAssigned += totalAssigned;

            if(!Object.keys(this.module_data).includes(course)){
                // create a new dictionary for the course
                this.module_data[course] = {};
                // add the type to the dictionary and a date dictionary
                this.module_data[course][type] = {}
                // for the data add a array which is [attendedCount, totalCount]
                this.module_data[course][type][date] = [attendedCount, totalAssigned]; 
            }
            // check if type does not exists in course
            else if(!Object.keys(this.module_data[course]).includes(type)){
                // add the type to the dictionary and a date dictionary
                this.module_data[course][type] = {}
                // for the data add a array which is [attendedCount, totalCount]
                this.module_data[course][type][date] = [attendedCount, totalAssigned];
            }
            // check if date does not exist
            else if(!Object.keys(this.module_data[course][type]).includes(date)){
                // for the data add a array which is [attendedCount, totalCount]
                this.module_data[course][type][date] = [attendedCount, totalAssigned];
            }
            else{
                this.module_data[course][type][date][0] += attendedCount; 
                this.module_data[course][type][date][1] += totalAssigned;
            }
        });
    }


    


    getWeekDifference(){
        // get this week (weekend inclusive)
        let thisWeekRange = calculateCurrentWeek();
        let thisWeekData = [0, 0];
        // get last week (weekend inclusive)
        let lastWeekRange = calculateLastWeek();
        let lastWeekData = [0, 0];
        Object.keys(this.module_data).forEach(moduleName => {
            Object.keys(this.module_data[moduleName]).forEach(moduleType => {

                let filteredKeys  = Object.keys(this.module_data[moduleName][moduleType]).filter((date) => {
                    if(Date.parse(date).between(lastWeekRange[0], thisWeekRange[1])) return true;
                });
                // we have all the dates for this module that is between last week and this week

                filteredKeys.forEach(date => {
                    event = this.module_data[moduleName][moduleType][date];
                    if (Date.parse(date).between(thisWeekRange[0], thisWeekRange[1])){
                        thisWeekData[0] = thisWeekData[0] + Number(event[0]);
                        thisWeekData[1] = thisWeekData[1] + Number(event[1]);
                    }
                    else{
                        lastWeekData[0] = lastWeekData[0] + Number(event[0]);
                        lastWeekData[1] = lastWeekData[1] + Number(event[1]);
                    }
                });

            });
        });
        // loop over all data for this week
        let thisWeekPercent = Math.round((thisWeekData[0]/thisWeekData[1])*100);
        if(isNaN(thisWeekPercent)){
            thisWeekPercent = 0;
        }
        let lastWeekPercent = Math.round((lastWeekData[0]/lastWeekData[1])*100);
        if(isNaN(lastWeekPercent)){
            lastWeekPercent = 0;
        }
        let percentage_difference = thisWeekPercent - lastWeekPercent; 
        return percentage_difference; 
        // loop over all data for last week

    }

    getModuleList(){
        return Object.keys(this.module_data);
    }

    getTypeList(moduleName){
        return Object.keys(this.module_data[moduleName]);

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

    get assignedCount(){
        return this.totalAssigned;
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



function calculateCurrentWeek(){
    let today = Date.today();
    if (today.is().weekday()){
       if(today.is().monday()){
            return [today, today];
        }
        else if(today.is().friday()){
            return [structuredClone(today).previous().monday(), today];
        }
        else{
            return [structuredClone(today).previous().monday(), today];
        }
    }
    else{
            return [today.previous().monday(), today.next().friday()];
    }
}


function calculateLastWeek(){
    let thisWeek = calculateCurrentWeek();
    let friday = thisWeek[1];
    if(!friday.is().friday()){
        friday.next().friday();
        friday.addWeeks(-1);
    }
    return [thisWeek[0].addWeeks(-1), friday];
    
}
