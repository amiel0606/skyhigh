<?php
include_once './includes/header.php';
?>
<style>
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
            <form action="" method="POST">
                <div class="columns">
                    <div class="column">
                        <h5 class="title is-5">Client Information</h5>
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input type="text" class="input" placeholder="Enter name">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input type="email" class="input" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Address</label>
                            <div class="control">
                                <input type="text" class="input" placeholder="Enter address">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Phone Number</label>
                            <div class="control">
                                <input type="number"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    type="number" maxlength="11" class="input" placeholder="09xxxxxxxxx">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <h5 class="title is-5">Appointment Information</h5>
                        <div class="field">
                            <label class="label">Type of Vehicle</label>
                            <div class="control">
                                <input type="text" class="input" placeholder="Enter vehicle type">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Select Service</label>
                            <div class="control">
                                <input type="text" class="input" placeholder="Enter service">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Select Time</label>
                            <div class="control">
                                <input type="time" min="10:00" max="20:00" class="input">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Date</label>
                            <div class="control">
                                <input type="date" class="input">
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
<?php
include_once './includes/footer.php';
?>