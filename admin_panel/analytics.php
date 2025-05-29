<?php include_once('./includes/header.php'); ?>
<?php include './includes/notification.php'; ?>
<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: ./login.php');
    exit();
}
?>
<style>
    .chart-container {
        max-width: 1000px;
        height: 400px;
        margin: 50px auto 0 auto;
        padding: 20px;
    }
    
    .metrics-dashboard {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
    }
    
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .metric-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border-left: 4px solid #3273dc;
        transition: transform 0.2s ease;
    }
    
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .metric-card.revenue {
        border-left-color: #48c774;
    }
    
    .metric-card.orders {
        border-left-color: #ffdd57;
    }
    
    .metric-card.appointments {
        border-left-color: #ff3860;
    }
    
    .metric-card.users {
        border-left-color: #00d1b2;
    }
    
    .metric-value {
        font-size: 2rem;
        font-weight: bold;
        color: #363636;
        margin-bottom: 5px;
    }
    
    .metric-label {
        font-size: 0.9rem;
        color: #7a7a7a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .loading {
        text-align: center;
        padding: 20px;
        color: #7a7a7a;
    }
    
    .service-display {
        position: relative;
        cursor: pointer;
    }
    
    .service-tooltip {
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #363636;
        color: white;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 0.8rem;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease;
        z-index: 1000;
        margin-bottom: 5px;
    }
    
    .service-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 5px solid transparent;
        border-top-color: #363636;
    }
    
    .service-display:hover .service-tooltip {
        opacity: 1;
        visibility: visible;
    }
</style>

<section class="section">
    <div class="container">
        <h2 class="title has-text-centered">Analytics Dashboard</h2>
        
        <!-- Metrics Dashboard -->
        <div class="metrics-dashboard">
            <div id="metricsLoading" class="loading">Loading analytics data...</div>
            <div id="metricsGrid" class="metrics-grid" style="display: none;">
                <div class="metric-card orders">
                    <div class="metric-value" id="totalOrders">-</div>
                    <div class="metric-label">Orders Placed</div>
                </div>
                
                <div class="metric-card revenue">
                    <div class="metric-value" id="totalRevenue">-</div>
                    <div class="metric-label">Total Revenue</div>
                </div>
                
                <div class="metric-card">
                    <div class="metric-value" id="topSellingItem">-</div>
                    <div class="metric-label">Top Selling Item</div>
                </div>
                
                <div class="metric-card">
                    <div class="metric-value service-display" id="topServiceDisplay">
                        <span id="topService">-</span>
                        <div class="service-tooltip" id="serviceTooltip" style="display: none;"></div>
                    </div>
                    <div class="metric-label">Top Service</div>
                </div>
                
                <div class="metric-card">
                    <div class="metric-value" id="mostScheduledTime">-</div>
                    <div class="metric-label">Most Scheduled Time</div>
                </div>
                
                <div class="metric-card">
                    <div class="metric-value" id="mostScheduledDay">-</div>
                    <div class="metric-label">Most Scheduled Day</div>
                </div>
                
                <div class="metric-card appointments">
                    <div class="metric-value" id="totalAppointments">-</div>
                    <div class="metric-label">Total Appointments</div>
                </div>
                
                <div class="metric-card users">
                    <div class="metric-value" id="activeUsers">-</div>
                    <div class="metric-label">Active Users</div>
                </div>
                
                <div class="metric-card">
                    <div class="metric-value" id="walkInAppointments">-</div>
                    <div class="metric-label">Walk-in Appointments</div>
                </div>
                
            </div>
        </div>
        
        <!-- Charts Section -->
        <div class="chart-container">
            <label for="filterSelect">Show data by:</label>
            <select id="filterSelect">
                <option value="month">Monthly</option>
                <option value="week">Weekly</option>
            </select>
            <canvas id="appointmentsChart" width="400" height="200"></canvas>
            <canvas id="revenueChart" width="400" height="200"></canvas>
            <canvas id="serviceBookingsChart" width="400" height="200"></canvas>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    document.getElementById('filterSelect').addEventListener('change', fetchData);

    let appointmentsChartInstance = null;
    let revenueChartInstance = null;
    let serviceBookingsChartInstance = null;

    // Fetch analytics metrics
    async function fetchAnalyticsData() {
        try {
            const response = await axios.get('./controller/getAnalyticsData.php');
            const data = response.data;
            
            if (data.error) {
                console.error('Error fetching analytics data:', data.error);
                document.getElementById('metricsLoading').textContent = 'Error loading analytics data';
                return;
            }
            
            // Update metric values
            document.getElementById('totalOrders').textContent = data.totalOrders;
            document.getElementById('totalRevenue').textContent = '₱ ' + Number(data.totalRevenue / 100).toLocaleString();
            document.getElementById('topSellingItem').textContent = data.topSellingItem;
            
            // Handle top service with potential ties
            const topServiceData = data.topService;
            const topServiceElement = document.getElementById('topService');
            const serviceTooltip = document.getElementById('serviceTooltip');
            
            if (topServiceData.message) {
                // No services yet
                topServiceElement.textContent = topServiceData.message;
                serviceTooltip.style.display = 'none';
            } else {
                const services = topServiceData.services;
                if (services.length === 1) {
                    // Single top service
                    topServiceElement.textContent = services[0];
                    serviceTooltip.style.display = 'none';
                } else if (services.length <= 3) {
                    // 2-3 services, show all with ellipses
                    topServiceElement.textContent = services.join(', ') + '...';
                    serviceTooltip.innerHTML = `All top services (${topServiceData.count} each): ${services.join(', ')}`;
                    serviceTooltip.style.display = 'block';
                } else {
                    // More than 3 services, show first 3 with ellipses
                    topServiceElement.textContent = services.slice(0, 3).join(', ') + '...';
                    serviceTooltip.innerHTML = `All top services (${topServiceData.count} each): ${services.join(', ')}`;
                    serviceTooltip.style.display = 'block';
                }
            }
            
            document.getElementById('mostScheduledTime').textContent = data.mostScheduledTime;
            document.getElementById('mostScheduledDay').textContent = data.mostScheduledDay;
            document.getElementById('totalAppointments').textContent = data.totalAppointments;
            document.getElementById('activeUsers').textContent = data.activeUsers;
            document.getElementById('walkInAppointments').textContent = data.walkInAppointments;

            
            // Show metrics grid and hide loading
            document.getElementById('metricsLoading').style.display = 'none';
            document.getElementById('metricsGrid').style.display = 'grid';
            
        } catch (error) {
            console.error('Error fetching analytics data:', error);
            document.getElementById('metricsLoading').textContent = 'Error loading analytics data';
        }
    }

    async function fetchData() {
        const filter = document.getElementById('filterSelect').value;
        try {
            const responseAppointments = await axios.get('./controller/getAppointments.php?filter=' + filter);
            const responseRevenue = await axios.get('./controller/getRevenue.php?filter=' + filter);

            const appointmentsData = responseAppointments.data; 
            const revenueData = responseRevenue.data; 

            updateAppointmentsChart(appointmentsData, filter);
            updateRevenueChart(revenueData, filter);

        } catch (error) {
            console.error('Error fetching data', error);
        }
    }

    function updateAppointmentsChart(appointmentsData, filter) {
        const ctxAppointments = document.getElementById('appointmentsChart').getContext('2d');
        const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        const labels = filter === 'week' ? dayNames : [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        if (appointmentsChartInstance) {
            appointmentsChartInstance.destroy();
        }

        // For week, ensure data is in order Sunday-Saturday
        const data = filter === 'week'
            ? [1,2,3,4,5,6,7].map(i => (appointmentsData[i] || 0))
            : Object.values(appointmentsData).map(v => v);

        appointmentsChartInstance = new Chart(ctxAppointments, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Appointments",
                    backgroundColor: "rgb(254, 222, 139)",
                    borderColor: "rgba(255, 206, 86, 1)",
                    borderWidth: 1,
                    data: data
                }]
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

    function updateRevenueChart(revenueData, filter) {
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        const labels = filter === 'week' ? dayNames : [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        if (revenueChartInstance) {
            revenueChartInstance.destroy();
        }

        // For week, ensure data is in order Sunday-Saturday
        const data = filter === 'week'
            ? [1,2,3,4,5,6,7].map(i => (revenueData[i] || 0) / 100)
            : Object.values(revenueData).map(v => v / 100);

        revenueChartInstance = new Chart(ctxRevenue, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Revenue",
                    backgroundColor: "rgb(253, 87, 87)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 1,
                    data: data
                }]
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

    async function fetchServiceBookingsData() {
        try {
            const response = await axios.get('./controller/getAnalyticsData.php?serviceBookings=1');
            const data = response.data;
            updateServiceBookingsChart(data);
        } catch (error) {
            console.error('Error fetching service bookings data', error);
        }
    }

    function updateServiceBookingsChart(serviceBookingsData) {
        const ctx = document.getElementById('serviceBookingsChart').getContext('2d');
        const labels = Object.keys(serviceBookingsData);
        const data = Object.values(serviceBookingsData);
        if (serviceBookingsChartInstance) {
            serviceBookingsChartInstance.destroy();
        }
        serviceBookingsChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Bookings per Service',
                    backgroundColor: 'rgb(54, 162, 235)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    data: data
                }]
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

    // Initialize data
    fetchAnalyticsData();
    fetchData();
    fetchServiceBookingsData();
</script>
<?php include_once('./includes/footer.php'); ?>