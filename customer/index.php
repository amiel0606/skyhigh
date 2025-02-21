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
</style>

<p class="logo-text-motorcycle is-size-3 text-center">Just Ride & Go with SkyHigh.</p>
<p class="text text-center">How is your ride today, Sounds like not good! Don’t worry. Find your mechanic
    online
    Book as you wish with SkyHigh. We offer you a free inquiries, Make your appointment now.</p>

<div class="container has-text-centered mt-5">
    <button class="button is-warning"
        onclick="document.getElementById('appointmentModal').classList.add('is-active')">Set an Appointment</button>
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
                                <input type="text" name="vehicle" class="input" placeholder="Enter vehicle type">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Select Service</label>
                            <div class="control">
                                <input type="text" name="service" class="input" placeholder="Enter service">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Select Time</label>
                            <div class="control">
                                <input type="time" name="time" class="input" min="10:00" max="20:00">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Date</label>
                            <div class="control">
                                <input type="date" name="date" class="input" min="<?php echo $today; ?>">
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
            Once it’s done, you will be able to start browsing. Thank you.
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let isVerified = <?php echo json_encode($_SESSION['verified']); ?>;
        let isLoggedIn = <?php echo isset($_SESSION["username"]) ? 'true' : 'false'; ?>;

        if (isLoggedIn && isVerified === "false") {
            document.getElementById("emailModal").classList.add("is-active");
        }

        document.querySelector(".modal-background").addEventListener("click", function () {
            document.getElementById("emailModal").classList.remove("is-active");
        });
        $("#resendOTP").click(function (e) {
            e.preventDefault();
            resendOTP();
        });
        $('#verifyOTP').click(function () {
            verifyOTP();
        });
    });
    function resendOTP() {
        let url = './controllers/resendOTP.php';
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    alert("OTP has been resent to your email.");
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function () {
                alert("Failed to resend OTP.");
            }
        });
    }

    function verifyOTP() {
        let otpValue = document.getElementById("otpInput").value; 
        $.ajax({
            url: './controllers/verifyOTP.php',
            type: "POST",
            data: { otp: otpValue },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    alert("Your email has been verified!");
                    document.getElementById("emailModal").classList.remove("is-active");
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert("Failed to verify OTP. Please try again.");
            }
        });
    }
</script>
<?php
include_once './includes/footer.php';
?>