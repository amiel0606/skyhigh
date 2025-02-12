<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKYHIGH MOTORCYCLE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #262E36;
            position: relative;
            overflow: hidden;
        }

        .logo-text {
            background: linear-gradient(90deg, #ff7e5f, #feb47b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin: auto;
        }

        .logo-text-skyhigh {
            font-size: 60pt;
            font-weight: 900;
        }

        .logo-text-motorcycle {
            font-size: 35pt;
            font-weight: 900;
        }

        .middle-text {
            font-size: 20pt;
            color: white;
            margin-left: 20px;
            font-weight: 900;
        }

        .logo-img {
            height: 75px;
        }

        .navbar {
            background-color: #212529;
        }

        .navbar-nav .nav-item {
            margin-right: 50px;
        }

        .navbar-nav .nav-link {
            font-size: 18pt;
            font-weight: 600;
            color: white;
        }

        .bg-secondary {
            background-color: #262E36 !important;
        }

        .background-container {
            position: relative;
            height: 100vh;
            overflow: hidden;
        }

        .background-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('../img/background-home.png');
            background-size: cover;
            background-position: center;
            opacity: 0.35;
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            color: white;
            padding: 20px;
            width: 700px;
            margin: auto;
        }

        .text {
            font-weight: 500;
        }

        .button {
            background-color: #FFC300;
            color: black;
            border: none;
            padding: 10px 20px;
            font-size: 16pt;
            font-weight: 600;
            border-radius: 5px;
            margin-top: 100px;
            cursor: pointer;
            margin-left: 70;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="../img/logo.png" alt="Logo" class="me-2 logo-img">
                <div class="logo-container">
                    <span class="logo-text logo-text-skyhigh">SKYHIGH</span>
                    <span class="logo-text logo-text-motorcycle">MOTORCYCLE</span>
                </div>
                <span class="middle-text">Parts/Trading</span>
            </div>
            <div class="d-flex ms-auto">
                <button class="btn btn-outline-light me-2" type="button">Sign Up</button>
                <button class="btn btn-light" type="button">Log In</button>
            </div>
        </div>
    </nav>
    <nav class="navbar navbar-expand-lg bg-secondary">
        <div class="container-fluid">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">Parts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Inquire</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="background-container">
        <div class="content">