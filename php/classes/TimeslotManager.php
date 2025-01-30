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
            $data[] = $this->getStudentTimeslots($startDate, $endDate);
        }

        // Lecture or GTA (Lecture Lessons)
        if ($this->user->getRoleId() == 1 || $this->user->getRoleId() == 2) {
            $data[] = $this->getStaffTimeslots($startDate, $endDate);
        }

        // Admin
        if ($this->user->getRoleId() == 3) {
            $data[] = $this->getStudentTimeslots($startDate, $endDate);
            $data[] = $this->getStaffTimeslots($startDate, $endDate);
        }

        return $data;
    }

    private function getStudentTimeslots($startDate, $endDate) {
        $query = "
            SELECT status, start_time, end_time, date, location_name, name 
            FROM Attendance 
            INNER JOIN TimeSlot ON Attendance.timeslot_id = TimeSlot.timeslot_id 
            INNER JOIN Location ON TimeSlot.location_id = Location.location_id 
            INNER JOIN CourseAssignment ON TimeSlot.course_id = CourseAssignment.course_id 
            INNER JOIN User ON CourseAssignment.lecturer_id = User.user_id 
            WHERE Attendance.user_id = :user_id 
            AND TimeSlot.Date <= :end_date 
            AND TimeSlot.Date >= :start_date";

        return $this->db->query($query, [
            ":user_id" => $this->user->getUserId(),
            ":end_date" => $endDate,
            ":start_date" => $startDate
        ]);
    }

    private function getStaffTimeslots($startDate, $endDate) {
        $query = "
            SELECT start_time, end_time, date, location_name 
            FROM TimeSlot 
            INNER JOIN Location ON TimeSlot.location_id = Location.location_id 
            INNER JOIN CourseAssignment ON TimeSlot.course_id = CourseAssignment.course_id 
            INNER JOIN User ON CourseAssignment.lecturer_id = User.user_id 
            WHERE CourseAssignment.lecturer_id = :user_id 
            AND TimeSlot.Date <= :end_date 
            AND TimeSlot.Date >= :start_date";

        return $this->db->query($query, [
            ":user_id" => $this->user->getUserId(),
            ":end_date" => $endDate,
            ":start_date" => $startDate
        ]);
    }
}
