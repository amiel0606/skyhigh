<?php include_once('./includes/header.php'); ?>
<?php include './includes/notification.php'; ?>
<div class="main-content">
    <section class="hero is-small"
        style="background: url('./assets/images/banner1.png') center/cover; padding: 100px; color: white;">
        <h1 class="sutitle has-text-white">WELCOME!</h1>
        <h2 class="title has-text-white has-text-weight-bold is-size-1">KEVIN PANITERCE</h2>
    </section>
    <div class="columns">
        <div class="column is-three-quarters">
            <div class="dashboard-card mt-6"> <i class="fa-solid fa-users fa-5x"></i> <span
                    class="is-size-1 has-text-weight-bold ml-3"> Total Active Users: <span
                        id="total_active_users"></span> </span></div>
            <div class="dashboard-card"> <i class="fa-solid fa-wrench fa-5x"></i> <span
                    class="is-size-1 has-text-weight-bold ml-3"> Total Appointments: <span
                        id="total_appointments"></span> </span></div>
            <div class="dashboard-card"> <i class="fa-solid fa-gear fa-5x"></i> <span
                    class="is-size-1 has-text-weight-bold ml-3"> Total Items Sales: <span id="total_sales"></span>
                </span></div>
            <div class="dashboard-card"> <i class="fa-solid fa-clipboard-list fa-5x"></i> <span
                    class="is-size-1 has-text-weight-bold ml-3"> Total Walk-in Appointments: <span id="total_walkin"></span>
                </span></div>
        </div>
        <div class="column">
            <div class="dashboard-card full-height d-flex flex-column mt-6">
                <div class="content">
                    <p class="title has-text-weight-bold mb-6">Weekly Appointments Scheduled: <br>
                        <span id="weekly_appointments" class="is-size-1 has-text-centered "></span>
                    </p>
                </div>
                <div class="buttons mt-auto">
                    <button id="btn-analytics" class="button is-danger is-fullwidth circle-button">
                        <span class="icon-text">
                            <span class="icon">
                                <i class="fa-solid fa-chart-line"></i> </span>
                            <span>View Analytics</span>
                        </span>
                    </button>
                    <button id="btn-scheduled" class="button is-danger is-fullwidth circle-button">
                        <span class="icon-text">
                            <span class="icon">
                                <i class="fa-solid fa-calendar-days"></i>
                            </span>
                            <span>View Scheduled</span>
                        </span>
                    </button>
                    <button id="btn-orders" class="button is-danger is-fullwidth circle-button">
                        <span class="icon-text">
                            <span class="icon">
                                <i class="fa-solid fa-list"></i>
                            </span>
                            <span>View Orders</span>
                        </span>
                    </button>
                    <button id="btn-chat" class="button is-danger is-fullwidth circle-button">
                        <span class="icon-text">
                            <span class="icon">
                                <i class="fa-solid fa-comments"></i>
                            </span>
                            <span>Chat</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="./js/changeWindows.js"></script>
<script src="../node_modules/axios/dist/axios.min.js"></script>
<script>
    axios.get('./controller/getRevenue.php')
        .then(response => {
            const revenueData = response.data;
            const totalRevenue = Object.values(revenueData).reduce((acc, monthRevenue) => acc + parseFloat(monthRevenue), 0);
            const formattedTotalRevenue = totalRevenue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#total_sales').text(`₱ ${formattedTotalRevenue}`);
        })
        .catch(error => {
            console.error('Error fetching revenue:', error);
        });
    axios.get('./controller/getSchedules.php')
        .then(response => {
            const totalAppointments = response.data.length;
            $('#total_appointments').text(totalAppointments);
            const weeklyAppointments = response.data.filter(appointment => {
                const appointmentDate = new Date(appointment.date);
                const today = new Date();
                const diffTime = Math.abs(today - appointmentDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                return diffDays <= 7;
            });
            $('#weekly_appointments').text(weeklyAppointments.length);
        })
        .catch(error => {
            console.error('Error fetching appointments:', error);
        });
    axios.get('./controller/getActiveUsers.php')
        .then(response => {
            const totalActiveUsers = response.data;
            $('#total_active_users').text(totalActiveUsers);
        })
        .catch(error => {
            console.error('Error fetching active users:', error);
        });
    axios.get('./controller/getSchedules.php?type=Walk-in')
        .then(response => {
            const totalWalkInAppointments = response.data.length;
            $('#total_walkin').text(totalWalkInAppointments);
        })
        .catch(error => {
            console.error('Error fetching walk-in appointments:', error);
        });
</script>

<?php include_once('./includes/footer.php'); ?>