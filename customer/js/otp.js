document.addEventListener("DOMContentLoaded", function () {
    let isVerified = JSON.parse(document.getElementById('isVerified').textContent);
    let isLoggedIn = JSON.parse(document.getElementById('isLoggedIn').textContent);

    if (isLoggedIn && isVerified === "false") {
        document.getElementById("emailModal").classList.add("is-active");
    }

    document.querySelector(".modal-background").addEventListener("click", function () {
        document.getElementById("emailModal").classList.remove("is-active");
    });

    document.getElementById("resendOTP").addEventListener("click", function (e) {
        e.preventDefault();
        resendOTP();
    });

    document.getElementById("verifyOTP").addEventListener("click", function () {
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