<?php include_once('./includes/header.php'); ?>
<div class="main-content">
    <section class="hero is-small"
        style="background: url('./assets/images/banner1.png') center/cover; padding: 100px; color: white;">
        <h1 class="sutitle has-text-white">WELCOME!</h1>
        <h2 class="title has-text-white has-text-weight-bold is-size-1">KEVIN PANITERCE</h2>
    </section>
    <div class="columns">
        <div class="column is-three-quarters">
            <div class="dashboard-card mt-6"> <i class="fa-solid fa-users fa-5x"></i> <span
                    class="is-size-1 has-text-weight-bold ml-3"> Total Active Users: </span> </div>
            <div class="dashboard-card"> <i class="fa-solid fa-wrench fa-5x"></i> <span
                    class="is-size-1 has-text-weight-bold ml-3"> Total Active Mechanics: </span></div>
            <div class="dashboard-card"> <i class="fa-solid fa-gear fa-5x"></i> <span
                    class="is-size-1 has-text-weight-bold ml-3"> Total Items Sales: </span></div>
            <div class="dashboard-card"><span class="is-size-4 has-text-weight-bold ml-3"> Upcoming Appointments:
                </span></div>
        </div>
        <div class="column">
            <div class="dashboard-card full-height d-flex flex-column mt-6">
                <div class="content">
                    <p class="title has-text-weight-bold mb-6">Weekly Appointments Scheduled: <br>
                        <span class="is-size-1">  50</span></p>
                    <p class="title has-text-weight-bold mt-6">Weekly New Users: <span class="is-size-1">50</span>
                    </p>
                </div>
                <div class="buttons mt-auto">
                    <button class="button is-danger is-fullwidth circle-button">
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
                    <button class="button is-danger is-fullwidth circle-button">
                        <span class="icon-text">
                            <span class="icon">
                                <i class="fa-solid fa-list"></i>
                            </span>
                            <span>View Orders</span>
                        </span>
                    </button>
                    <button class="button is-danger is-fullwidth circle-button">
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

<?php include_once('./includes/footer.php'); ?>