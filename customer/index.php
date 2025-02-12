<?php
include_once './includes/header.php';
?>
<style>
    .modal-card {
        background: rgba(0, 0, 0, 0.8);
        color: white;
        border-radius: 10px;
    }

    .input,
    .select select {
        background: rgba(255, 255, 255, 0.9);
    }

    .button-submit {
        background: yellow;
        font-weight: bold;
        border: none;
    }
</style>
<h1 class="logo-text-motorcycle text-center">Just Ride & Go with SkyHigh.</h1>
<p class="text text-center">How is your ride today, Sounds like not good! Don’t worry. Find your mechanic
    online
    Book as you wish with SkyHigh. We offer you a free inquiries, Make your appointment now.</p>
<div class="container text-center mt-5">
    <button class="button btn-primary" data-bs-toggle="modal" data-bs-target="#appointmentModal">Set an
        Appointment</button>
</div>
<div class="container has-text-centered mt-5">
    <button class="button is-primary"
        onclick="document.getElementById('appointmentModal').classList.add('is-active')">Set an Appointment</button>
</div>

<div id="appointmentModal" class="modal">
    <div class="modal-background" onclick="document.getElementById('appointmentModal').classList.remove('is-active')">
    </div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title has-text-centered">SET AN APPOINTMENT</p>
            <button class="delete" aria-label="close"
                onclick="document.getElementById('appointmentModal').classList.remove('is-active')"></button>
        </header>
        <section class="modal-card-body">
            <form>
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
                                <input type="text" class="input" placeholder="09xxxxxxxxx">
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
                                <input type="time" class="input">
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
                    <button type="submit" class="button button-submit">SUBMIT</button>
                </div>
            </form>
        </section>
    </div>
</div>
<?php
include_once './includes/footer.php';
?>