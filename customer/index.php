<?php
include_once './includes/header.php';
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : null;
$name = isset($_SESSION["name"]) ? $_SESSION["name"] : null;
$contact = isset($_SESSION["contact"]) ? $_SESSION["contact"] : null;
$role = isset($_SESSION["role"]) ? $_SESSION["role"] : null;
$address = isset($_SESSION["address"]) ? $_SESSION["address"] : null;
if (!isset($_SESSION['verified'])) {
    $_SESSION['verified'] = "false";
}

// Get error parameter from URL
$error = isset($_GET['error']) ? $_GET['error'] : null;
?>
<style>
    .input {
        width: 100%;
        color: white;
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

    .is-secondary {
        color: #262f36;
    }


    .input {
        background-color: #fff;
        color: black;
    }

    .notification-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
    }
    
    .notification {
        margin-bottom: 10px;
    }
</style>

<!-- Add notification container -->
<div id="notificationContainer" class="notification-container"></div>

<script>
// Function to show notification
function showNotification(message, type = 'is-success') {
    const container = document.getElementById('notificationContainer');
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    
    // Add delete button
    const deleteButton = document.createElement('button');
    deleteButton.className = 'delete';
    deleteButton.onclick = () => notification.remove();
    
    notification.appendChild(deleteButton);
    notification.appendChild(document.createTextNode(message));
    container.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => notification.remove(), 5000);
}

// Check for URL parameters on page load
window.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    
    if (error === 'loginSuccess') {
        showNotification('Success!', 'is-success');
    }
    if (error === 'InvalidRole') {
        showNotification('Invalid Role!', 'is-danger');
    }
    if (error === 'WrongPassword') {
        showNotification('Invalid email or password!', 'is-danger');
    }
    if (error === 'Registered') {
        showNotification('Successfully Registered!', 'is-success');
    }
    if (error === 'stmtFailed') {
        showNotification('Something went wrong!', 'is-danger');
    }
    if (error === 'OTPFailed') {
        showNotification('Invalid OTP!', 'is-danger');
    }
    if (error === 'OTPExpired') {
        showNotification('OTP Expired!', 'is-danger');
    }
    if (error === 'OTPNotSent') {
        showNotification('OTP Not Sent!', 'is-danger');
    }
    if (error === 'OTPNotVerified') {
        showNotification('OTP Not Verified!', 'is-danger');
    }
    if (error === 'none') {
        showNotification('Success!', 'is-success');
    }
    
});

document.addEventListener('DOMContentLoaded', function() {
    var serviceDropdown = document.getElementById('serviceDropdown');
    if (serviceDropdown) {
        serviceDropdown.addEventListener('change', function() {
            var otherDiv = document.getElementById('otherServiceDiv');
            if (this.value === 'Others') {
                otherDiv.style.display = 'block';
                document.getElementById('otherServiceInput').required = true;
            } else {
                otherDiv.style.display = 'none';
                document.getElementById('otherServiceInput').required = false;
            }
        });
    }
});
</script>

<p class="logo-text-motorcycle is-size-3 text-center">Just Ride & Go with SkyHigh.</p>
<p class="text text-center">How is your ride today, Sounds like not good! Don't worry. Find your mechanic online Book as
    you wish with SkyHigh. We offer you a free inquiries, Make your appointment now.</p>
<div class="container has-text-centered mt-5">
    <button class="button is-warning"
        onclick="document.getElementById('appointmentModal').classList.add('is-active')"><?php echo isset($_SESSION['uID']) ? 'Set an Appointment' : 'Set an Appointment as Guest'; ?></button>
</div>

<div id="appointmentModal" class="modal">
    <div class="modal-background" onclick="document.getElementById('appointmentModal').classList.remove('is-active')">
    </div>
    <div class="modal-card">
        <header class="modal-card-head has-background-dark ">
            <p class="modal-card-title has-text-weight-bold has-text-white">SET AN APPOINTMENT</p>
            <button class="delete" aria-label="close"
                onclick="document.getElementById('appointmentModal').classList.remove('is-active')"></button>
        </header>
        <section class="modal-card-body has-background-primary">
            <form action="./controllers/setAppointment.php" method="POST">
                <div class="columns dashed">
                    <div class="column">
                        <h5 class="title is-5">Client Information</h5>
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input type="text" name="name" value="<?php echo $name; ?>" class="input"
                                    placeholder="Enter name">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input type="email" name="username" value="<?php echo $username; ?>" class="input"
                                    placeholder="Enter email">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Address</label>
                            <div class="control">
                                <input type="text" name="address" value="<?php echo $address; ?>" class="input"
                                    placeholder="Enter address">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Phone Number</label>
                            <div class="control">
                                <input name="contact" type="number"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    type="number" value="<?php echo $contact; ?>" maxlength="11" class="input"
                                    placeholder="09xxxxxxxxx">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <h5 class="title is-5">Appointment Information</h5>
                        <div class="field">
                            <label class="label">Type of Vehicle</label>
                            <div class="control">
                                <input type="hidden" name="vehicle" value="Motorcycle" class="input" placeholder="Enter vehicle type">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Select Service</label>
                            <div class="control">
                                <div>
                                    <select name="service" id="serviceDropdown" class="input">
                                        <option value="">Select service</option>
                                        <option value="Change oil">Change oil</option>
                                        <option value="Tune up">Tune up</option>
                                        <option value="Adjust chain">Adjust chain</option>
                                        <option value="Replace Carburator">Replace Carburator</option>
                                        <option value="Replace Shock">Replace Shock</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                                <div id="otherServiceDiv" style="display:none; margin-top: 8px;">
                                    <input type="text" name="other_service" id="otherServiceInput" class="input" placeholder="Please specify service">
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Select Time</label>
                            <div class="control">
                                <select name="time" id="timeDropdown" class="input">
                                    <option value="">Select a time</option>
                                    <!-- Options will be populated by JS -->
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Date</label>
                            <div class="control">
                                <input type="date" name="date" id="dateInput" class="input" min="<?php echo $today; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <p class="has-text-centered mt-3">Appointment Starts at 10:00 AM</p>
                <div class="has-text-centered">
                    <button type="submit" class="button button-submit is-warning">SUBMIT</button>
                </div>
            </form>
        </section>
    </div>
</div>
<div class="modal custom-modal" id="emailModal">
    <div class="modal-background"></div>
    <div class="modal-content custom-box">
        <h1 class="title is-3">Verify your email address</h1>
        <p class="mb-4">
            Please confirm that you want to use this as your Skyhigh account email address.
            Once it's done, you will be able to start browsing. Thank you.
        </p>
        <div class="field">
            <div class="control">
                <input id="otpInput" class="input is-rounded" type="text" placeholder="Enter OTP">
            </div>
        </div>
        <button id="verifyOTP" class="button is-dark is-rounded mt-3">Submit</button>
        <a href="#" id="resendOTP" class="has-text-weight-semibold is-secondary">Resend OTP</a>
    </div>
</div>
<div id="isVerified" style="display:none;"><?php echo json_encode($_SESSION['verified']); ?></div>
<div id="isLoggedIn" style="display:none;"><?php echo isset($_SESSION["username"]) ? 'true' : 'false'; ?></div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="./js/otp.js"></script>
<script src="./js/changeWindows.js"></script>
<?php
include_once './includes/footer.php';
?>