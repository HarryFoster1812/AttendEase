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
        this.processData();
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

}
