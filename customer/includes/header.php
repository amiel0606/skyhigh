<?php
session_start();
date_default_timezone_set('Asia/Manila');
$today = date(format: 'Y-m-d');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKYHIGH MOTORCYCLE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.1/css/bulma.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <style>
        input[type="time"]::-webkit-calendar-picker-indicator,
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            background-color: transparent;
        }

        input[type="time"]::-moz-calendar-picker-indicator,
        input[type="date"]::-moz-calendar-picker-indicator {
            filter: invert(1);
        }

        input[type="time"]::-ms-clear,
        input[type="date"]::-ms-clear {
            filter: invert(1);
        }

        :root {
            --bulma-primary-h: 210deg;
            --bulma-primary-s: 30%;
            --bulma-primary-l: 55%;
            --bulma-warning-h: 46deg;
            --bulma-warning-l: 50%;
        }

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
            z-index: 100;
            color: white;
            padding: 20px;
            width: 700px;
            margin: auto;
        }

        .text {
            font-weight: 500;
        }

        .bbtn {
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

        .modal {
            z-index: 100 !important;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0;
        }

        .no-acc-btn {
            background-color: transparent;
            background-repeat: no-repeat;
            border: none;
            cursor: pointer;
            overflow: hidden;
            outline: none;
            color: #FFC300;
        }

        .dashed {
            border-style: dashed;
        }

        .custom-modal {
            background: transparent;
        }

        .custom-box {
            background: rgba(70, 130, 180, 0.9);

            border-radius: 15px;
            padding: 2rem;
            text-align: center;
        }

        .input {
            background-color: #fff;
            color: black;
        }
    </style>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a href="./index.php">
                <div class="d-flex align-items-center">
                    <img src="../img/logo.png" alt="Logo" class="me-2 logo-img">
                    <div class="logo-container">
                        <span class="logo-text logo-text-skyhigh">SKYHIGH</span>
                        <span class="logo-text logo-text-motorcycle">MOTORCYCLE</span>
                    </div>
                    <span class="middle-text">Parts/Trading</span>
                </div>
            </a>
            <div class="d-flex ms-auto">
                <!-- Sign Up and Log In Buttons (Hidden if Logged In) -->
                <button class="bbtn btn-outline-light me-2 <?php echo isset($_SESSION['uID']) ? 'is-hidden' : ''; ?>"
                    type="button" onclick="document.getElementById('registerModal').classList.add('is-active')">Sign
                    Up</button>
                <button class="bbtn btn-light <?php echo isset($_SESSION['uID']) ? 'is-hidden' : ''; ?>" type="button"
                    onclick="document.getElementById('loginModal').classList.add('is-active')">Log In</button>

                <!-- Cart Button (Visible only if Logged In) -->
                <button class="bbtn btn-outline-light me-2 <?php echo isset($_SESSION['uID']) ? '' : 'is-hidden'; ?>"
                    type="button" onclick="window.location.href = 'userCart.php'">
                    <i class="fa-solid fa-cart-shopping"></i>
                </button>

                <!-- Log Out Button (Visible only if Logged In) -->
                <button class="bbtn btn-outline-light me-2 <?php echo isset($_SESSION['uID']) ? '' : 'is-hidden'; ?>"
                    type="button" onclick="window.location.href = './controllers/logout.php'">Log out</button>
            </div>

        </div>
    </nav>
    <nav class="navbar navbar-expand-lg bg-secondary">
        <div class="container-fluid">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="./parts.php">Parts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./message.php">Inquire</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./message.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./faq.php">FAQs</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="background-container">
        <div class="is-pulled-right m-3">
            <button id="btnOrders"
                class="button is-warning is-pulled-right is-fullwidth <?php echo !isset($_SESSION['uID']) ? 'is-hidden' : ''; ?>">View
                Orders</button> <br> <br>
            <button id="btnAppointments"
                class="button is-warning is-pulled-right <?php echo !isset($_SESSION['uID']) ? 'is-hidden' : ''; ?>">View
                Appointments</button>
        </div>
        <div class="content">
            <div id="registerModal" class="modal">
                <div class="modal-background"
                    onclick="document.getElementById('registerModal').classList.remove('is-active')">
                </div>
                <div class="modal-card">
                    <header class="modal-card-head has-background-dark ">
                        <p class="modal-card-title has-text-weight-bold has-text-white has-text-centered">Create an
                            Account</p>
                        <button class="delete" aria-label="close"
                            onclick="document.getElementById('registerModal').classList.remove('is-active')"></button>
                    </header>
                    <section class="modal-card-body has-background-primary">
                        <form action="./controllers/register.php" method="POST">
                            <div class="columns dashed">
                                <div class="column">
                                    <div class="field">
                                        <label class="label">Name</label>
                                        <div class="control">
                                            <input type="text" name="name" class="input" placeholder="Enter name">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Email</label>
                                        <div class="control">
                                            <input type="email" name="email" class="input" placeholder="Enter email">
                                        </div>
                                    </div>
                                    <p class="is-size-6">Click <button class="no-acc-btn">here </button> to Log in</p>
                                </div>
                                <div class="column">
                                    <div class="field">
                                        <label class="label">Address</label>
                                        <div class="control">
                                            <input type="text" name="address" class="input" placeholder="Enter address">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Phone Number</label>
                                        <div class="control">
                                            <input type="number"
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                type="number" name="contact" maxlength="11" class="input"
                                                placeholder="09xxxxxxxxx">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Password</label>
                                        <div class="control">
                                            <input type="password" name="password" class="input"
                                                placeholder="Enter Password">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Confirm Password</label>
                                        <div class="control">
                                            <input type="password" name="confPassword" class="input"
                                                placeholder="Confirm your password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="has-text-centered">
                                <button type="submit" class="button button-submit is-warning">Register</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
            <div id="loginModal" class="modal">
                <div class="modal-background"
                    onclick="document.getElementById('loginModal').classList.remove('is-active')">
                </div>
                <div class="modal-card">
                    <header class="modal-card-head has-background-dark ">
                        <p class="modal-card-title has-text-weight-bold has-text-white has-text-centered">Log in</p>
                        <button class="delete" aria-label="close"
                            onclick="document.getElementById('loginModal').classList.remove('is-active')"></button>
                    </header>
                    <section class="modal-card-body has-background-primary">
                        <form action="./controllers/login.php" method="POST">
                            <div class="field">
                                <label class="label">Email</label>
                                <div class="control">
                                    <input type="email" name="username" class="input" placeholder="Enter Email">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Password</label>
                                <div class="control">
                                    <input type="password" name="password" class="input"
                                        placeholder="Enter your password">
                                </div>
                            </div>
                            <div class="has-text-centered">
                                <button type="submit" name="Login"
                                    class="button button-submit is-warning">Login</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>