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
    
    .controls-section {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .controls-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        align-items: end;
    }
    
    .control-group {
        display: flex;
        flex-direction: column;
    }
    
    .control-group label {
        font-weight: 600;
        margin-bottom: 5px;
        color: #363636;
    }
    
    .view-toggle {
        display: flex;
        gap: 10px;
    }
    
    .view-toggle .button {
        flex: 1;
    }
    
    .view-toggle .button.is-active {
        background-color: #3273dc;
        color: white;
    }
    
    .data-section {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #363636;
    }
    
    .table-container {
        overflow-x: auto;
        max-height: 400px;
        overflow-y: auto;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #dbdbdb;
    }
    
    .table th {
        background-color: #f5f5f5;
        font-weight: 600;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .table tbody tr:hover {
        background-color: #f9f9f9;
    }
    
    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-confirmed {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-completed {
        background-color: #cce5ff;
        color: #004085;
    }
    
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-declined {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .status-paid {
        background-color: #d4edda;
        color: #155724;
    }
    
    .hidden {
        display: none !important;
    }
</style>

<section class="section">
    <div class="container">
        <h2 class="title has-text-centered">Analytics Dashboard</h2>
        
        <!-- Controls Section -->
        <div class="controls-section">
            <div class="controls-grid">
                <div class="control-group">
                    <label for="filterSelect">Time Period:</label>
                    <select id="filterSelect" class="input">
                        <option value="daily">Daily (Last 30 Days)</option>
                        <option value="week">Weekly (Days of Week)</option>
                        <option value="month">Monthly (This Year)</option>
                        <option value="yearly">Yearly</option>
                        <option value="custom">Custom Date Range</option>
                    </select>
                </div>
                
                <div class="control-group" id="quickRangeGroup" style="display: none;">
                    <label for="quickRange">Quick Range:</label>
                    <select id="quickRange" class="input">
                        <option value="">Select a range...</option>
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="last7days">Last 7 Days</option>
                        <option value="last30days">Last 30 Days</option>
                        <option value="thisweek">This Week</option>
                        <option value="lastweek">Last Week</option>
                        <option value="thismonth">This Month</option>
                        <option value="lastmonth">Last Month</option>
                        <option value="thisyear">This Year</option>
                        <option value="lastyear">Last Year</option>
                    </select>
                </div>
                
                <div class="control-group" id="dateRangeGroup" style="display: none;">
                    <label for="startDate">Start Date:</label>
                    <input type="date" id="startDate" class="input">
                </div>
                
                <div class="control-group" id="endDateGroup" style="display: none;">
                    <label for="endDate">End Date:</label>
                    <input type="date" id="endDate" class="input">
                </div>
                
                <div class="control-group">
                    <label>View Type:</label>
                    <div class="view-toggle">
                        <button id="chartViewBtn" class="button is-active">Charts</button>
                        <button id="tableViewBtn" class="button">Tables</button>
                    </div>
                </div>
                
                <div class="control-group">
                    <button id="applyFiltersBtn" class="button is-primary">Apply Filters</button>
                </div>
                
                <div class="control-group">
                    <label>Export Data:</label>
                    <div class="view-toggle">
                        <button id="exportExcelBtn" class="button is-success">
                            <span class="icon">
                                <i class="fas fa-file-excel"></i>
                            </span>
                            <span>Excel</span>
                        </button>
                        <button id="exportPdfBtn" class="button is-danger">
                            <span class="icon">
                                <i class="fas fa-file-pdf"></i>
                            </span>
                            <span>PDF</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
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
        <div id="chartsSection">
            <div class="data-section">
                <h3 class="section-title">Appointments Chart</h3>
                <div class="chart-container">
                    <canvas id="appointmentsChart" width="400" height="200"></canvas>
                </div>
            </div>
            
            <div class="data-section">
                <h3 class="section-title">Revenue Chart</h3>
                <div class="chart-container">
                    <canvas id="revenueChart" width="400" height="200"></canvas>
                </div>
            </div>
            
            <div class="data-section">
                <h3 class="section-title">Service Bookings Chart</h3>
                <div class="chart-container">
                    <canvas id="serviceBookingsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Tables Section -->
        <div id="tablesSection" class="hidden">
            <div class="data-section">
                <h3 class="section-title">Appointments Data</h3>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Service</th>
                                <th>Vehicle</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody id="appointmentsTableBody">
                            <tr><td colspan="8" class="has-text-centered">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="data-section">
                <h3 class="section-title">Revenue Data</h3>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Transaction ID</th>
                                <th>Customer Name</th>
                                <th>Username</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="revenueTableBody">
                            <tr><td colspan="6" class="has-text-centered">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="data-section">
                <h3 class="section-title">Service Bookings Data</h3>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Total Bookings</th>
                                <th>Confirmed</th>
                                <th>Completed</th>
                                <th>Pending</th>
                                <th>Declined</th>
                            </tr>
                        </thead>
                        <tbody id="serviceBookingsTableBody">
                            <tr><td colspan="6" class="has-text-centered">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // Global variables
    let appointmentsChartInstance = null;
    let revenueChartInstance = null;
    let serviceBookingsChartInstance = null;
    let currentView = 'charts';
    
    // Event listeners
    document.getElementById('filterSelect').addEventListener('change', handleFilterChange);
    document.getElementById('chartViewBtn').addEventListener('click', () => switchView('charts'));
    document.getElementById('tableViewBtn').addEventListener('click', () => switchView('tables'));
    document.getElementById('applyFiltersBtn').addEventListener('click', applyFilters);
    document.getElementById('quickRange').addEventListener('change', handleQuickRangeChange);
    document.getElementById('exportExcelBtn').addEventListener('click', () => exportData('excel'));
    document.getElementById('exportPdfBtn').addEventListener('click', () => exportData('pdf'));
    
    function handleFilterChange() {
        const filter = document.getElementById('filterSelect').value;
        const dateRangeGroup = document.getElementById('dateRangeGroup');
        const endDateGroup = document.getElementById('endDateGroup');
        const quickRangeGroup = document.getElementById('quickRangeGroup');
        
        if (filter === 'custom') {
            dateRangeGroup.style.display = 'block';
            endDateGroup.style.display = 'block';
            quickRangeGroup.style.display = 'block';
        } else {
            dateRangeGroup.style.display = 'none';
            endDateGroup.style.display = 'none';
            quickRangeGroup.style.display = 'none';
            applyFilters();
        }
    }
    
    function handleQuickRangeChange() {
        const quickRange = document.getElementById('quickRange').value;
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');
        
        if (!quickRange) return;
        
        const today = new Date();
        const formatDate = (date) => date.toISOString().split('T')[0];
        
        let startDate, endDate;
        
        switch (quickRange) {
            case 'today':
                startDate = endDate = today;
                break;
            case 'yesterday':
                const yesterday = new Date(today);
                yesterday.setDate(yesterday.getDate() - 1);
                startDate = endDate = yesterday;
                break;
            case 'last7days':
                startDate = new Date(today);
                startDate.setDate(startDate.getDate() - 7);
                endDate = today;
                break;
            case 'last30days':
                startDate = new Date(today);
                startDate.setDate(startDate.getDate() - 30);
                endDate = today;
                break;
            case 'thisweek':
                const thisWeekStart = new Date(today);
                thisWeekStart.setDate(today.getDate() - today.getDay());
                startDate = thisWeekStart;
                endDate = today;
                break;
            case 'lastweek':
                const lastWeekEnd = new Date(today);
                lastWeekEnd.setDate(today.getDate() - today.getDay() - 1);
                const lastWeekStart = new Date(lastWeekEnd);
                lastWeekStart.setDate(lastWeekEnd.getDate() - 6);
                startDate = lastWeekStart;
                endDate = lastWeekEnd;
                break;
            case 'thismonth':
                startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                endDate = today;
                break;
            case 'lastmonth':
                const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                const lastMonthEnd = new Date(today.getFullYear(), today.getMonth(), 0);
                startDate = lastMonth;
                endDate = lastMonthEnd;
                break;
            case 'thisyear':
                startDate = new Date(today.getFullYear(), 0, 1);
                endDate = today;
                break;
            case 'lastyear':
                startDate = new Date(today.getFullYear() - 1, 0, 1);
                endDate = new Date(today.getFullYear() - 1, 11, 31);
                break;
        }
        
        startDateInput.value = formatDate(startDate);
        endDateInput.value = formatDate(endDate);
    }
    
    function switchView(view) {
        currentView = view;
        const chartViewBtn = document.getElementById('chartViewBtn');
        const tableViewBtn = document.getElementById('tableViewBtn');
        const chartsSection = document.getElementById('chartsSection');
        const tablesSection = document.getElementById('tablesSection');
        
        if (view === 'charts') {
            chartViewBtn.classList.add('is-active');
            tableViewBtn.classList.remove('is-active');
            chartsSection.classList.remove('hidden');
            tablesSection.classList.add('hidden');
        } else {
            tableViewBtn.classList.add('is-active');
            chartViewBtn.classList.remove('is-active');
            chartsSection.classList.add('hidden');
            tablesSection.classList.remove('hidden');
            loadTableData();
        }
    }
    
    function applyFilters() {
        if (currentView === 'charts') {
            fetchData();
            fetchServiceBookingsData();
        } else {
            loadTableData();
        }
    }
    
    function getFilterParams() {
        const filter = document.getElementById('filterSelect').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        let params = `filter=${filter}`;
        
        if (filter === 'custom' && startDate && endDate) {
            params += `&startDate=${startDate}&endDate=${endDate}`;
        }
        
        return params;
    }

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
        const params = getFilterParams();
        try {
            const responseAppointments = await axios.get('./controller/getAppointments.php?' + params);
            const responseRevenue = await axios.get('./controller/getRevenue.php?' + params);

            const appointmentsData = responseAppointments.data; 
            const revenueData = responseRevenue.data; 

            updateAppointmentsChart(appointmentsData, document.getElementById('filterSelect').value);
            updateRevenueChart(revenueData, document.getElementById('filterSelect').value);

        } catch (error) {
            console.error('Error fetching data', error);
        }
    }

    function updateAppointmentsChart(appointmentsData, filter) {
        const ctxAppointments = document.getElementById('appointmentsChart').getContext('2d');
        let labels, data;
        
        if (filter === 'custom' || filter === 'daily') {
            // For custom date range or daily, use dates as labels
            labels = Object.keys(appointmentsData);
            data = Object.values(appointmentsData);
        } else if (filter === 'week') {
            const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            labels = dayNames;
            // For week, ensure data is in order Sunday-Saturday
            data = [1,2,3,4,5,6,7].map(i => (appointmentsData[i] || 0));
        } else if (filter === 'yearly') {
            // For yearly, use years as labels
            labels = Object.keys(appointmentsData);
            data = Object.values(appointmentsData);
        } else {
            // Monthly
            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            labels = monthNames;
            data = Object.values(appointmentsData).map(v => v);
        }

        if (appointmentsChartInstance) {
            appointmentsChartInstance.destroy();
        }

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
                    },
                    x: {
                        ticks: {
                            maxRotation: filter === 'daily' || filter === 'custom' ? 45 : 0
                        }
                    }
                }
            }
        });
    }

    function updateRevenueChart(revenueData, filter) {
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        let labels, data;
        
        if (filter === 'custom' || filter === 'daily') {
            // For custom date range or daily, use dates as labels
            labels = Object.keys(revenueData);
            data = Object.values(revenueData).map(v => v / 100);
        } else if (filter === 'week') {
            const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            labels = dayNames;
            // For week, ensure data is in order Sunday-Saturday
            data = [1,2,3,4,5,6,7].map(i => (revenueData[i] || 0) / 100);
        } else if (filter === 'yearly') {
            // For yearly, use years as labels
            labels = Object.keys(revenueData);
            data = Object.values(revenueData).map(v => v / 100);
        } else {
            // Monthly
            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            labels = monthNames;
            data = Object.values(revenueData).map(v => v / 100);
        }

        if (revenueChartInstance) {
            revenueChartInstance.destroy();
        }

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
                                return `${tooltipItem.dataset.label}: ₱${tooltipItem.raw.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        ticks: {
                            maxRotation: filter === 'daily' || filter === 'custom' ? 45 : 0
                        }
                    }
                }
            }
        });
    }

    async function fetchServiceBookingsData() {
        try {
            const params = getFilterParams();
            const response = await axios.get('./controller/getAnalyticsData.php?serviceBookings=1&' + params);
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
    
    // Table data functions
    async function loadTableData() {
        await Promise.all([
            loadAppointmentsTable(),
            loadRevenueTable(),
            loadServiceBookingsTable()
        ]);
    }
    
    async function loadAppointmentsTable() {
        try {
            const params = getFilterParams() + '&detailed=1';
            const response = await axios.get('./controller/getAppointments.php?' + params);
            const data = response.data;
            
            const tbody = document.getElementById('appointmentsTableBody');
            tbody.innerHTML = '';
            
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="has-text-centered">No data available</td></tr>';
                return;
            }
            
            data.forEach(appointment => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${appointment.appointment_date}</td>
                    <td>${appointment.name}</td>
                    <td>${appointment.username}</td>
                    <td>${appointment.service}</td>
                    <td>${appointment.vehicle}</td>
                    <td>${appointment.time}</td>
                    <td><span class="status-badge status-${appointment.status.toLowerCase()}">${appointment.status}</span></td>
                    <td>${appointment.type}</td>
                `;
                tbody.appendChild(row);
            });
        } catch (error) {
            console.error('Error loading appointments table:', error);
            document.getElementById('appointmentsTableBody').innerHTML = 
                '<tr><td colspan="8" class="has-text-centered">Error loading data</td></tr>';
        }
    }
    
    async function loadRevenueTable() {
        try {
            const params = getFilterParams() + '&detailed=1';
            const response = await axios.get('./controller/getRevenue.php?' + params);
            const data = response.data;
            
            const tbody = document.getElementById('revenueTableBody');
            tbody.innerHTML = '';
            
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="has-text-centered">No data available</td></tr>';
                return;
            }
            
            data.forEach(transaction => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${transaction.transaction_date}</td>
                    <td>${transaction.payment_intent_id}</td>
                    <td>${transaction.name}</td>
                    <td>${transaction.username}</td>
                    <td>₱${(transaction.total / 100).toLocaleString()}</td>
                    <td><span class="status-badge status-${transaction.status.toLowerCase()}">${transaction.status}</span></td>
                `;
                tbody.appendChild(row);
            });
        } catch (error) {
            console.error('Error loading revenue table:', error);
            document.getElementById('revenueTableBody').innerHTML = 
                '<tr><td colspan="6" class="has-text-centered">Error loading data</td></tr>';
        }
    }
    
    async function loadServiceBookingsTable() {
        try {
            const params = getFilterParams() + '&detailed=1';
            const response = await axios.get('./controller/getAnalyticsData.php?serviceBookings=1&' + params);
            const data = response.data;
            
            const tbody = document.getElementById('serviceBookingsTableBody');
            tbody.innerHTML = '';
            
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="has-text-centered">No data available</td></tr>';
                return;
            }
            
            data.forEach(service => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${service.service}</td>
                    <td>${service.total_bookings}</td>
                    <td>${service.confirmed}</td>
                    <td>${service.completed}</td>
                    <td>${service.pending}</td>
                    <td>${service.declined}</td>
                `;
                tbody.appendChild(row);
            });
        } catch (error) {
            console.error('Error loading service bookings table:', error);
            document.getElementById('serviceBookingsTableBody').innerHTML = 
                '<tr><td colspan="6" class="has-text-centered">Error loading data</td></tr>';
        }
    }

    // Initialize data
    fetchAnalyticsData();
    fetchData();
    fetchServiceBookingsData();
    
    // Export functionality
    function exportData(format) {
        const params = getFilterParams();
        const viewType = currentView;
        
        // Show loading state
        const exportBtn = format === 'excel' ? 
            document.getElementById('exportExcelBtn') : 
            document.getElementById('exportPdfBtn');
        
        const originalText = exportBtn.innerHTML;
        exportBtn.innerHTML = '<span class="icon"><i class="fas fa-spinner fa-spin"></i></span><span>Exporting...</span>';
        exportBtn.disabled = true;
        
        // Create export URL
        const exportUrl = `./controller/exportAnalytics.php?format=${format}&view=${viewType}&${params}`;
        
        // Create a temporary link to download the file
        const link = document.createElement('a');
        link.href = exportUrl;
        link.download = `analytics_${format}_${new Date().toISOString().split('T')[0]}`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Reset button state after a delay
        setTimeout(() => {
            exportBtn.innerHTML = originalText;
            exportBtn.disabled = false;
        }, 2000);
    }
</script>
<?php include_once('./includes/footer.php'); ?>