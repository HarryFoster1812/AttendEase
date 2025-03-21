# AttendEase - Web-Based Attendance Management System

**AttendEase** is a feature-rich, web-based attendance management system developed as part of my university project. This platform is designed to simplify the process of tracking attendance for students and managing class data for lecturers. Built with **PHP**, **MySQL**, and **Bootstrap**, AttendEase leverages cutting-edge technologies like geolocation for accurate attendance tracking, while also offering user-friendly features like calendar integration, dark and light themes, and real-time statistics.

### Key Features

- **Geolocation-Based Attendance**: Uses the Geolocation API to confirm the student's presence at the designated location for class.
- **Backup Code System**: If geolocation is not available or fails, a secure backup code system ensures students can still mark their attendance.
- **Role-Based Access Control**: Four user roles with different levels of access:
  - **Student**: Marks attendance, views attendance history, and tracks their academic performance.
  - **Lecturer/Teacher**: Manages attendance for their classes, generates attendance reports, and monitors student engagement.
  - **GTA (Graduate Teaching Assistant)**: Assists with attendance tracking and supports lecturers in class management.
  - **Admin**: Full administrative control, including managing users, courses, and attendance data.
  
- **Calendar-Based Attendance System**: A visual calendar interface that shows attendance records, scheduled classes, and upcoming lectures.
- **Profile Pictures**: Users can upload profile pictures for a personalized experience.
- **Absence Appeals**: Students can submit appeals for absences, which are reviewed by lecturers or administrators.
- **Light and Dark Themes**: The app features a theme toggle to switch between light and dark modes for a customizable user experience.
- **Leaderboard System**: Displays a ranking of students based on attendance, incentivizing participation and engagement.
- **Statistics and Reports**: Provides detailed attendance and performance statistics for both students and lecturers to track progress and identify areas for improvement.

### Technologies & Tools Used

- **Frontend**: Built with **Bootstrap** to provide a clean, responsive design across devices.
- **Backend**: **PHP** for handling server-side logic, including database interactions and user management.
- **Database**: **MySQL** for storing user information, attendance records, and course details.
- **Geolocation API**: Used for verifying the location of students during attendance marking.
- **JavaScript**: To handle theme switching, dynamic content updates, and interactive calendar features.

### Role Descriptions
1. Student
- Mark attendance using geolocation or backup codes.
- Submit absence appeals if needed.
- View and track attendance, academic performance, and engagement statistics.
- Participate in the leaderboard system based on attendance.

2. Lecturer/Teacher
- Manage attendance for their courses and view attendance statistics.
- Review student absence appeals and approve or deny them.
- Access detailed reports on student performance and overall class engagement.

3. GTA (Graduate Teaching Assistant)
- Assist lecturers with tracking attendance and reviewing student engagement.
- Help manage the absence appeal process.

4. Admin
- Manage all aspects of the application, including creating and deleting user accounts, managing courses, and overseeing all attendance data.
- Full control over the app’s settings, including user roles and the leaderboard system.

