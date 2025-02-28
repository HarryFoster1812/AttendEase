const ctx1 = document.getElementById('AttendanceBar').getContext('2d');

        // Create bar chart
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Months
                datasets: [{
                    label: 'Attendance (%)',
                    data: [95, 88, 92, 85, 90, 87, 94, 93, 89, 91, 96, 97], // Example data
                    backgroundColor: '#FFCC33', // Your primary color #660099
                    borderColor: '#FFCC33',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Your percentage attendance over time',
                        color: '#FFCC33', // Title color
                        font: { size: 24, family: 'Convergence' } // Convergence font
                    },
                    legend: {
                        display: false // Hide legend
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#ffcc33',font: { size: 16, family: 'Convergence' } }
                    },
                    y: {
                        ticks: { color: '#ffcc33',font: { size: 16, family: 'Convergence' }},
                        beginAtZero: true,
                        max: 100
                        
                    }
                }
            }
        });
        const ctx2 = document.getElementById('AttendanceLine').getContext('2d');

        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'], // Days of the week
                datasets: [{
                    label: 'Attendance (%)',
                    data: [90, 85, 92, 88, 95], // Example Data
                    borderColor: '#FFCC33', // Line Color
                    backgroundColor: 'rgba(255, 204, 51, 0.2)', // Light fill under the line
                    borderWidth: 2,
                    pointBackgroundColor: '#FFCC33', // Point Color
                    pointBorderColor: '#FFCC33',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Your attendance this week',
                        color: '#FFCC33',
                        font: { size: 24, family: 'Convergence' } // Convergence font, bigger size
                    },
                    legend: {
                        display: false // Hide legend
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#FFCC33',
                            font: { size: 16, family: 'Convergence' } // Convergence font for labels
                        }
                    },
                    y: {
                        ticks: {
                            color: '#FFCC33',
                            font: { size: 16, family: 'Convergence' } // Convergence font for labels
                        },
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });