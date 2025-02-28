const ctx = document.getElementById('AttendanceChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], // Days of the week
                    datasets: [
                        {
                            label: 'Lecture',
                            data: [95, 90, 93, 88, 96, 94, 97], // Example Data for Course 1
                            borderColor: '#FFCC33', // Gold Line
                            backgroundColor: 'rgba(255, 204, 51, 0.2)', // Light Fill
                            borderWidth: 2,
                            pointBackgroundColor: '#FFCC33',
                            pointBorderColor: '#FFCC33',
                            pointRadius: 5
                        },
                        {
                            label: 'Workshop',
                            data: [85, 88, 90, 87, 89, 92, 91], // Example Data for Course 2
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
                            text: 'Weekly percentage attendance for COMP10120',
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