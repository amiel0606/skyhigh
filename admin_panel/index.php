<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKYHIGH MOTORCYCLE | Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #ddd;
            padding: 20px;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        .dashboard-card {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .full-height {
            height: 100% !important;
            display: flex;
            flex-direction: column;
        }

        .circle-button {
            border-radius: 20px;
        }

        .content {
            flex-grow: 1;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <figure class="image is-128x128 ml-6 mb-6">
            <img class="is-rounded" src="./assets/images/dp.jpg" alt="Profile">
        </figure>
        <h3 class="title is-4 has-text-centered">ADMIN</h3>
        <button class="button is-danger is-fullwidth">Log out</button>
        <hr>
        <aside class="menu mt-6">
            <ul class="menu-list">
                <li><a><i class="fa-solid fa-house mr-6"></i>Dashboard</a></li>
                <li><a><i class="fa-solid fa-wrench mr-6"></i>Mechanics</a></li>
                <li><a><i class="fa-solid fa-gear mr-6"></i>Inventory</a></li>
                <li><a><i class="fa-solid fa-users mr-6"></i>Customer</a></li>
            </ul>
        </aside>
    </div>
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
                        <p class="title has-text-weight-bold mb-6" >Weekly Appointments Scheduled: <span class="is-size-1" >50</span></p>
                        <p class="title has-text-weight-bold mt-6" >Weekly New Users: <span class="is-size-1">50</span></p>
                    </div>
                    <div class="buttons mt-auto">
                        <button class="button is-danger is-fullwidth circle-button"> <span class="icon-text"> <span class="icon"> <i class="fa-solid fa-chart-line"></i> </span> <span>View Analytics</span> </span></button>
                        <button class="button is-danger is-fullwidth circle-button"> <span class="icon-text"> <span class="icon"> <i class="fa-solid fa-calendar-days"></i> </span> <span>View Scheduled</span> </span></button>
                        <button class="button is-danger is-fullwidth circle-button"><span class="icon-text"> <span class="icon"> <i class="fa-solid fa-list"></i> </span> <span>View Orders</span> </span> </button>
                        <button class="button is-danger is-fullwidth circle-button"><span class="icon-text"> <span class="icon"> <i class="fa-solid fa-comments"></i> </span> <span>Chat</span> </span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>