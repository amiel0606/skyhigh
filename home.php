<?php
session_start();
include 'connection.php';

$user = $_SESSION['user'] ?? null;

if (!$user) {
    echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
    exit();
}

$sql = "SELECT pname, pemail, paddress, ptel FROM user WHERE pemail = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("MySQL prepare error: " . $conn->error);
}

$stmt->bind_param("i", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die("MySQL query error: " . $stmt->error);
}

$userData = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sky High</title>
    <link rel="stylesheet" href="css/bookme.css" />
    <!-- boot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <style>
      #guestdetailpanel{
        display: none;
        
      }
      #guestdetailpanel .middle{
        height: 400px;
      }
    </style>
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
                    <a href="index.php">
                        <span class="active">
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
            <div id="user">
                <a href="logout.php">
                    <span>Logout</span>
                </a>
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
            
                <img src="images/#" alt="">
            </div>
            <div>
                <button class="orange-button" onclick="openbookbox()">Book Now</button>
            </div>

        </div>
        <div id="menu">
            <div class="container">
                <ul>
                    <li>
                        <a href="#banner">
                            <span>Main</span>
                        </a>
                    </li>
                    <li>
                        <a href="#video">
                            <span>About</span>
                        </a>
                    </li>
                    <li>
                        <a href="#announcement">
                            <span>Announcement</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

<!-- bookbox -->
<div id="guestdetailpanel">
    <form action="" method="POST" class="guestdetailpanelform" autocomplete="off">
        <div class="head">
            <h3>SET AN APPOINTMENT</h3>
            <i class="fa-solid fa-circle-xmark" onclick="closebox()"></i>
        </div>
        <div class="middle">
        <div class="guestinfo">
                    <h4>Client information</h4>
                    <input type="text" name="Name" placeholder="Enter Full name" value="<?php echo htmlspecialchars($userData['pname'] ?? ''); ?>">
                    <input type="email" name="Email" placeholder="Enter Email" value="<?php echo htmlspecialchars($userData['pemail'] ?? ''); ?>">
                    <input type="text" name="Address" placeholder="Enter Address" value="<?php echo htmlspecialchars($userData['paddress'] ?? ''); ?>">
                    <input type="tel" name="Phone" placeholder="Enter Contact No." value="<?php echo htmlspecialchars($userData['ptel'] ?? ''); ?>">
                </div>

            <div class="line"></div>

            <div class="reservationinfo">
                <h4>Appointment information</h4>
                <select name="Vehicle" class="selectinput" required>
                    <option value selected>Type Of Vehicle</option>
                    <option value="Motorcycle">Motorcycle</option>
                </select>
                <select name="Service" class="selectinput" required>
                    <option value selected>Select Service</option>
                    <option value="Full Cleaning">Full Cleaning</option>
                    <option value="Full Maintenance">Full Maintenance</option>
                    <option value="Engine Tuning">Engine Tuning</option>
                </select>
                <select name="time" class="selectinput" required>
                    <option value selected>Select Time</option>
                    <option value="1:00PM">1:00PM</option>
                    <option value="3:00PM">3:00PM</option>
                    <option value="5:00PM">5:00PM</option>
                </select>
                <div class="datesection">
                    <span>
                        <label for="cin">Appointment Starts at 1:00 PM</label>
                        <input name="cin" type="date" required>
                    </span>
                </div>
            </div>
        </div>
        <div class="footer">
            <button class="btn btn-success" name="guestdetailsubmit">Submit</button>
        </div>
    </form>

    <!-- ==== room book php ==== -->
    <?php
    if (isset($_POST['guestdetailsubmit'])) {
        $Name = $_POST['Name'];
        $Email = $_POST['Email'];
        $Address = $_POST['Address'];
        $Phone = $_POST['Phone'];
        $Vehicle = $_POST['Vehicle'];
        $Service = $_POST['Service'];
        $cin = $_POST['cin'];
        $time = $_POST['time'];

        if ($Name == "" || $Email == "" || $Address == "") {
            echo "<script>
                swal({
                    title: 'Fill in the proper details',
                    icon: 'error',
                });
            </script>";
        } else {
            $sta = "NotConfirm";
            $sql = "INSERT INTO appointment(Name, Email, Address, Phone, Vehicle, Service, cin, time) 
                    VALUES ('$Name', '$Email', '$Address', '$Phone', '$Vehicle', '$Service', '$cin', '$time')";
            
            // Execute query
            $result = mysqli_query($conn, $sql);

            // Check result and provide feedback
            if ($result) {
                echo "<script>
                    swal({
                        title: 'Reservation successful',
                        icon: 'success',
                    });
                </script>";
            } else {
                echo "<script>
                    swal({
                        title: 'Something went wrong',
                        icon: 'error',
                    });
                </script>";
            }
        }
    }
    ?>
</div>


          <div id="content">
            <div id="video" class="container">
                <iframe width="1280" height="720" src="https://www.youtube.com/watch?v=LQ7YHzYuVWw" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div id="announcement" class="container">
                <div>   
                    <a href="announcement-board.html">
                        <span>NEWS & ANNOUNCEMENTS</span>
                    </a>
                    <div>
                        <a href="" alt="news">
                            <div><span></span></div>
                            <div>
                                <p>New parts!</p>
                            </div>
                            <div><span>Aug-1-2024</span></div>
                        </a>
                        <a href="" alt="notice">
                            <div><span></span></div>
                            <div>
                                <p>Motor Show Event</p>
                            </div>
                            <div><span>Aug-2-2024</span></div>
                        </a>
                        <a href="" alt="news">
                            <div><span></span></div>
                            <div>
                                <p>New Artist</p>
                            </div>
                            <div><span>Aug-3-2024</span></div>
                        </a>
                        <a href="" alt="others">
                            <div><span></span></div>
                            <div>
                                <p>New Spot!</p>
                            </div>
                            <div><span>Aug-5-2024</span></div>
                        </a>
                        <a href="" alt="notice">
                            <div><span></span></div>
                            <div>
                                <p>New Trades</p>
                            </div>
                            <div><span>Aug-6-2024</span></div>
                        </a>
                    </div>
                </div>
                <div>
                    <div>
                        <a href="#">
                            <img src="img/trophy.png" alt="trophy">
                            <div>
                                <p>SERVICES</p>
                                <span>We make sure to deliver the best service we can offer.</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="#">
                            <img src="svg/donation.svg" alt="trophy">
                            <div>
                                <p>PARTS</p>
                                <span>Parts that are available in our shops.</span>
                            </div>  
                        </a>
                    </div>
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

<script>
function openbookbox() {
  var bookbox = document.getElementById("guestdetailpanel");
  bookbox.style.display = "flex";
}

function closebox() {
  var bookbox = document.getElementById("guestdetailpanel");
  bookbox.style.display = "none";
}
</script>

</html>