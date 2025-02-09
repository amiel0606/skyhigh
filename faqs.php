<?php
session_start();
include 'connection.php';

$user = $_SESSION['user'] ?? null;

if (!$user) {
    echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
    exit();
}

$user = $_SESSION['user']; // Get the current user's ID
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/Icon2.png" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="css/style.css">
    <title> Sky High Motorcycle</title>
</head>

<body>
    <!-- TOP NAVIGATION BAR -->
    <nav class="before-scroll">
        <!-- COLLAPSE NAVIGATION BUTTON -->
        <div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <!-- NAVIGATION BUTTONS -->
        <div class="collapse-nav">
            <ul>
                <li>
                    <a href="home.php">
                        <span>
                            Home
                        </span>
                    </a>
                </li>
                <li>
                    <a href="services.php">
                        <span>
                            Services
                        </span>
                    </a>
                </li>
                <li>
                    <a href="faqs.php">
                        <span class="active">
                            FAQs
                        </span>
                    </a>
                </li>
                <li>
                    <a href="parts.php">
                        <span>
                            Parts
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="before-scroll">
            <div id="no-user">
                <a href="">
                    <span>Log-In</span>
                </a>
                <span>|</span>
                <a href="">
                        Register
                    </a>
            </div>
            <div id="user" class="user-collapse">
                <a href="logout.php">
                    <span>Logout</span>
                </a>
                <div>
                    <a href="#none">
                        <span>Change Password</span>
                    </a>
                    <a href="logout.php">
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
        <div>
            <a href="home.php">
                <img src="img/icon2.png" alt="">
            </a>
        </div>
    </nav>
    <main>
        <div id="banner">
            <img name="slide" class="slide" src="img/faqs.jpg" alt="">
            <div>
                <img src="images/#" alt="">
            </div>
            <div>
                <a href="#"><span>Frequently Asked Questions</span></a>
            </div>
        </div>
        <div id="menu">
            <div class="container">
            </div>
        </div>
        <div id="content">
            <div id="announcement" class="container">
                <div>   
                    <a href="announcement-board.html">
                        <span>About Us</span>
                    </a>
                    <div>
                        <a href="" alt="news">
                            <div><span></span></div>
                            <div>
                                <p>What's New?</p>
                            </div>
                            <div><span><br>Lorem ipsum dolor sit <br>
                            amet consectetur adipisicing elit. <br>
                            Necessitatibus?</span></div>
                        </a>
                        <a href="" alt="notice">
                            <div><span></span></div>
                            <div>
                                <p>What do we offer?</p>
                            </div>
                            <div><span><br>Lorem ipsum dolor sit <br>
                            amet consectetur adipisicing elit. <br>
                            Necessitatibus?</span></div>
                        </a>
                        <a href="" alt="news">
                            <div><span></span></div>
                            <div>
                                <p>New mechanics?</p>
                            </div>
                            <div><span><br>Lorem ipsum dolor sit <br>
                            amet consectetur adipisicing elit. <br>
                            Necessitatibus?</span></div>
                        </a>
                        <a href="" alt="others">
                            <div><span></span></div>
                            <div>
                                <p>Our Location?</p>
                            </div>
                            <div><span><br>Lorem ipsum dolor sit <br>
                            amet consectetur adipisicing elit. <br>
                            Necessitatibus?</span></div>
                        </a>
                        <a href="" alt="notice">
                            <div><span></span></div>
                            <div>
                                <p>Available Parts?</p>
                            </div>
                            <div><span><br>Lorem ipsum dolor sit <br>
                            amet consectetur adipisicing elit. <br>
                            Necessitatibus?</span></div>
                        </a>
                        <a href="" alt="notice">
                            <div><span></span></div>
                            <div>
                                <p>Incoming Parts?</p>
                            </div>
                            <div><span><br>Lorem ipsum dolor sit <br>
                            amet consectetur adipisicing elit. <br>
                            Necessitatibus?</span></div>
                        </a>
                        <a href="" alt="notice">
                            <div><span></span></div>
                            <div>
                                <p>Our service Rates?</p>
                            </div>
                            <div><span><br>Lorem ipsum dolor sit <br>
                            amet consectetur adipisicing elit. <br>
                            Necessitatibus?</span></div>
                        </a>
                        <a href="" alt="notice">
                            <div><span></span></div>
                            <div>
                                <p>Home Service?</p>
                            </div>
                            <div><span><br>Lorem ipsum dolor sit <br>
                            amet consectetur adipisicing elit. <br>
                            Necessitatibus?</span></div>
                        </a>
                    </div>
                </div>
                <div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <div>
                <span>©SKY HIGH MOTORCYCLE PARTS TRADING, All rights reserved.</span>
                <span>All trademarks referenced herein are the properties of their respective owners.</span>
            </div>
        </div>
    </footer>
    <script src="javascript/scrollspy.js"></script>
    <script src="javascript/Collapse-Navigation.js"></script>
    <script src="javascript/Profile.js"></script>
    <script src="javascript/Banner-Slide.js"></script>
</body>