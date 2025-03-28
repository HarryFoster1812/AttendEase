<?php
class TimeslotManager {
    private $db;
    private $user;

    public function __construct(Database $db, User $user) {
        $this->db = $db;
        $this->user = $user;
    }

    public function getTimeslots($startDate, $endDate) {
        $data = [];
        
        // Student or GTA (Student Lessons)
        if ($this->user->getRoleId() == 0 || $this->user->getRoleId() == 1) {
            $data["student"] = $this->getStudentTimeslots($startDate, $endDate);
        }

        // Lecture or GTA (Lecture Lessons)
        if ($this->user->getRoleId() == 1 || $this->user->getRoleId() == 2) {
            $data["staff"] = $this->getStaffTimeslots($startDate, $endDate);
        }

        // Admin
        if ($this->user->getRoleId() == 3) {
            $data["student"] = $this->getStudentTimeslots($startDate, $endDate);
            $data["staff"] = $this->getStaffTimeslots($startDate, $endDate);
        }

        return $data;
    }

    private function getStudentTimeslots($startDate, $endDate) {
        $query = "
            SELECT TimeSlot.timeslot_id, Attendance.user_id, status, start_time, end_time, date, location_name, name, course_title, Attendance.appeal 
            FROM Attendance 
            INNER JOIN TimeSlot ON Attendance.timeslot_id = TimeSlot.timeslot_id 
            INNER JOIN Location ON TimeSlot.location_id = Location.location_id 
            INNER JOIN CourseAssignment ON TimeSlot.course_id = CourseAssignment.course_id 
            INNER JOIN Course ON CourseAssignment.course_id = Course.course_id
            INNER JOIN User ON CourseAssignment.lecturer_id = User.user_id 
            WHERE Attendance.user_id = :user_id 
            AND TimeSlot.Date <= :end_date 
            AND TimeSlot.Date >= :start_date
            ORDER BY TimeSlot.Date, TimeSlot.start_time";

        return $this->db->query($query, [
            ":user_id" => $this->user->getUserId(),
            ":end_date" => $endDate,
            ":start_date" => $startDate
        ]);
    }

    private function getStaffTimeslots($startDate, $endDate) {
        $query = "
            SELECT timeslot_id,start_time, end_time, date, location_name, name, course_title 
            FROM TimeSlot 
            INNER JOIN Location ON TimeSlot.location_id = Location.location_id 
            INNER JOIN CourseAssignment ON TimeSlot.course_id = CourseAssignment.course_id 
            INNER JOIN User ON CourseAssignment.lecturer_id = User.user_id 
            INNER JOIN Course ON CourseAssignment.course_id = Course.course_id
            WHERE CourseAssignment.lecturer_id = :user_id 
            AND TimeSlot.Date <= :end_date 
            AND TimeSlot.Date >= :start_date
            ORDER BY TimeSlot.Date, TimeSlot.start_time";
        
        return $this->db->query($query, [
            ":user_id" => $this->user->getUserId(),
            ":end_date" => $endDate,
            ":start_date" => $startDate
        ]);
    }

    public function getStudentStatistics(){
        // the user should be authenticated
        $query = "SELECT * 
            FROM Attendance 
            INNER JOIN TimeSlot ON Attendance.timeslot_id = TimeSlot.timeslot_id
            INNER JOIN Course ON TimeSlot.course_id = Course.course_id
            WHERE user_id = :user_id AND 
                (date < DATE(NOW()) or date=DATE(NOW()) AND start_time<Time(NOW()))
            ORDER BY date, start_time 
            ";
        
        return $this->db->query($query, [
            ":user_id" => $this->user->getUserId(),
        ]);
    
    } 
    public function getLeaderboardStatistics(){
        // the user should be authenticated
        $query = "SELECT Attendance.user_id, name, status 
            FROM Attendance 
            INNER JOIN TimeSlot ON Attendance.timeslot_id = TimeSlot.timeslot_id
            INNER JOIN Course ON TimeSlot.course_id = Course.course_id
            INNER JOIN User on Attendance.user_id = User.user_id
            WHERE User.leaderboard_opt_in = 1 AND User.role_id<=1
            ORDER BY User.user_id,TimeSlot.date,TimeSlot.start_time
            ";
        
        return $this->db->query($query);
    
    } 

    public function getStaffStatistics(){
        // need to edit to also return the type of class when the database is updated
        $query = "
                SELECT
                    course_title,
                    start_time,
                    end_time,
                    date,
                    type,
                    COUNT(DISTINCT Attendance.user_id) AS total_assigned,
                    COUNT(DISTINCT CASE WHEN Attendance.status IN ('Attended', 'Late') THEN Attendance.user_id END) AS total_attended
                FROM
                    Course
                JOIN
                    CourseAssignment ON Course.course_id = CourseAssignment.course_id
                JOIN
                    TimeSlot ON Course.course_id = TimeSlot.course_id
                JOIN
                    Attendance ON TimeSlot.timeslot_id = Attendance.timeslot_id
                WHERE
                    CourseAssignment.lecturer_id = :user_id AND
                    (date < DATE(NOW()) or date=DATE(NOW()) AND start_time<Time(NOW()))
                GROUP BY
                    Course.course_id,
                    TimeSlot.timeslot_id
                ORDER BY
                    date, start_time
        ";

        return $this->db->query($query, [
            ":user_id" => $this->user->getUserId(),
        ]);
    } 
}
?>
