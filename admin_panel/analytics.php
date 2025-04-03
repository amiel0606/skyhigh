<?php include_once('./includes/header.php'); ?>

<style>
    .chart-container {
        max-width: 1000px;
        height: 400px;
        margin: 50px auto 0 auto;
        padding: 20px;
    }
</style>

<section class="section">
    <div class="container">
        <h2 class="title has-text-centered">Analytics</h2>
        <div class="chart-container">
            <canvas id="appointmentsChart" width="400" height="200"></canvas>
            <canvas id="revenueChart" width="400" height="200"></canvas>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    async function fetchData() {
        try {
            const responseAppointments = await axios.get('./controller/getAppointments.php');
            const responseRevenue = await axios.get('./controller/getRevenue.php');

            const appointmentsData = responseAppointments.data; 
            const revenueData = responseRevenue.data; 

            updateAppointmentsChart(appointmentsData);
            updateRevenueChart(revenueData);
        } catch (error) {
            console.error('Error fetching data', error);
        }
    }

    function updateAppointmentsChart(appointmentsData) {
        const ctxAppointments = document.getElementById('appointmentsChart').getContext('2d');

        const appointmentsChart = new Chart(ctxAppointments, {
            type: 'bar',
            data: {
                labels: [
                    "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ],
                datasets: [
                    {
                        label: "Appointments",
                        backgroundColor: "rgb(254, 222, 139)",
                        borderColor: "rgba(255, 206, 86, 1)",
                        borderWidth: 1,
                        data: Object.values(appointmentsData)  
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function updateRevenueChart(revenueData) {
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');

        const revenueChart = new Chart(ctxRevenue, {
            type: 'bar',
            data: {
                labels: [
                    "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ],
                datasets: [
                    {
                        label: "Revenue",
                        backgroundColor: "rgb(253, 87, 87)",
                        borderColor: "rgba(255, 99, 132, 1)",
                        borderWidth: 1,
                        data: Object.values(revenueData) 
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    fetchData();
</script>
<?php include_once('./includes/footer.php'); ?>