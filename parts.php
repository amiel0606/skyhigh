<?php
session_start();
include 'connection.php';   

$user = $_SESSION['user'] ?? null;

if (!$user) {
    echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
    exit();
}

$user = $_SESSION['user']; 
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
                        <span>
                            FAQs
                        </span>
                    </a>
                </li>
                <li>
                    <a href="parts.php">
                        <span class="active">
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
            <a href="">
                <img src="img/icon2.png" alt="">
            </a>
        </div>
    </nav>
    <main>
        <div id="banner">
            <img name="slide" class="slide" src="img/banner1.jpg" alt="">
            <img name="slide" class="slide" src="img/banner2.jpg" alt="">
            <img name="slide" class="slide" src="img/banner3.jpg" alt="">
            <div>
                <img src="images/#" alt="">
            </div>
        </div>



    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Order Form</h2>
            <form id="orderForm">
                <label for="userId">User ID:</label>
                <input type="number" id="userId" name="user_id" required>

                <label for="deliveredTo">Delivered To:</label>
                <input type="text" id="deliveredTo" name="delivered_to" required>

                <label for="phoneNo">Phone No:</label>
                <input type="text" id="phoneNo" name="phone_no" maxlength="10" required>

                <label for="deliverAddress">Delivery Address:</label>
                <input type="text" id="deliverAddress" name="deliver_address" required>

                <label for="payMethod">Payment Method:</label>
                <input type="text" id="payMethod" name="pay_method" required>

                <label for="payStatus">Payment Status:</label>
                <input type="number" id="payStatus" name="pay_status" value="1" required>

                <button type="submit">Submit Order</button>
            </form>
        </div>
    </div>

    <script src="./admin_panel/assets/js/firstscript.js"></script>

    <div id="products">
</div>
<div id="content">
    <section id="announcement" class="container">
        <div class="product-container">
            <?php
            include_once "connection.php";
            $sql = "SELECT * FROM product JOIN category ON product.category_id = category.category_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                <article class="product-card">
                    <div>
                        <img src="<?= $row["product_image"] ?>" alt="<?= $row["product_name"] ?>" class="product-image">
                    </div>
                    <h3 class="product-name"><?= strtoupper($row["product_name"]) ?></h3>
                    <p class="product-desc"><?= $row["product_desc"] ?></p>
                    <p class="category-name">Category: <?= $row["category_name"] ?></p>
                    <div class="action-buttons">
                        <button class="btn btn-buy" onclick="itemEditForm('<?= $row['product_id'] ?>')" aria-label="Edit <?= $row['product_name'] ?>">Buy Now</button>
                        <button class="btn btn-cart" onclick="itemDelete('<?= $row['product_id'] ?>')" aria-label="Delete <?= $row['product_name'] ?>">Add to Cart</button>
                    </div>
                </article>
            <?php
                }
            } else {
                echo "<p>No products found.</p>";
            }
            ?>
        </div>
    </section>
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