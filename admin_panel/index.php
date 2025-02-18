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
        <figure class="image is-128x128">
            <img class="is-rounded" src="https://via.placeholder.com/128" alt="Profile">
        </figure>
        <h3 class="title is-4">ADMIN</h3>
        <button class="button is-danger is-fullwidth">Log out</button>
        <aside class="menu">
            <ul class="menu-list">
                <li><a class="is-active">Dashboard</a></li>
                <li><a>Mechanics</a></li>
                <li><a>Inventory</a></li>
                <li><a>Customer</a></li>
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
                        <button class="button is-danger is-fullwidth circle-button">View Analytics</button>
                        <button class="button is-danger is-fullwidth circle-button">View Scheduled</button>
                        <button class="button is-danger is-fullwidth circle-button">View Orders</button>
                        <button class="button is-danger is-fullwidth circle-button">Chat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>