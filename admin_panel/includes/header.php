<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKYHIGH MOTORCYCLE | Admin</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bulma-primary-h: 0deg;
            --bulma-primary-s: 33%;
            --bulma-primary-l: 43%;
        }

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

        .is-primary {
            background-color: hsl(var(--bulma-primary-h), var(--bulma-primary-s), var(--bulma-primary-l)) !important;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <figure class="image is-128x128 ml-6 mb-6">
            <img class="is-rounded" src="./assets/images/dp.jpg" alt="Profile">
        </figure>
        <h3 class="title is-4 has-text-centered">ADMIN</h3>
        <button class="button is-primary is-fullwidth">Log out</button>
        <hr>
        <aside class="menu mt-6">
            <ul class="menu-list">
                <li><a href="./index.php"><i class="fa-solid fa-house mr-6"></i>Dashboard</a></li>
                <li><a><i class="fa-solid fa-wrench mr-6"></i>Mechanics</a></li>
                <li><a href="./inventory.php"><i class="fa-solid fa-gear mr-6"></i>Inventory</a></li>
                <li><a><i class="fa-solid fa-users mr-6"></i>Customer</a></li>
            </ul>
        </aside>
    </div>