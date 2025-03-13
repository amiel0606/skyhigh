<?php
include_once("./includes/header.php");
?>
<style>



</style>
<table id="appointmentsTable" class="table is-striped is-hoverable is-fullwidth">
    <thead>
        <tr>
            <th>Vehicle</th>
            <th>Service</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<div id="appointmentModal" class="modal">
    <div class="modal-background"></div>
    <div class="modal-close"></div>
    <div class="modal-content has-background-primary p-5">

    </div>
</div>


<script src="../node_modules/axios/dist/axios.min.js"></script>

<script>
    axios.get('./controllers/getAppointments.php')
        .then(function (response) {
            if (response.data.error) {
                alert("Error: " + response.data.error);
            } else {
                const tableBody = document.querySelector('#appointmentsTable tbody');
                response.data.forEach(appointment => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td>${appointment.vehicle}</td>
                    <td>${appointment.service}</td>
                    <td>${appointment.date}</td>
                    <td>${appointment.time}</td>
                    <td>${appointment.status}</td>
                `;
                    row.addEventListener('click', function () {
                        showModal(appointment);
                    });

                    tableBody.appendChild(row);
                });
            }
        })
        .catch(function (error) {
            console.error("There was an error making the request:", error);
        });

    function showModal(appointment) {
        const modalContent = document.querySelector('.modal-content');
        let actionButtons = '';
        if (appointment.status === 'Pending') {
            actionButtons = `
            <button class="button is-warning" onclick="reschedAppointment(${appointment.a_id})">Reschedule</button>
            <br>
            <button class="button is-danger" onclick="cancelAppointment(${appointment.a_id})">Cancel</button>
        `;
        }

        modalContent.innerHTML = `
        <h1 class="title">Appointment Details</h1>
        <p><strong>Vehicle:</strong> <span id="modal-vehicle">${appointment.vehicle}</span></p>
        <p><strong>Service:</strong> <span id="modal-service">${appointment.service}</span></p>
        <p><strong>Date:</strong> <span id="modal-date">${appointment.date}</span></p>
        <p><strong>Time:</strong> <span id="modal-time">${appointment.time}</span></p>
        <p><strong>Status:</strong> <span id="modal-status">${appointment.status}</span></p>
        ${actionButtons} <!-- Only appears when status is 'Pending' -->
    `;

        const modal = document.getElementById('appointmentModal');
        modal.classList.add('is-active');
    }

    document.querySelector('.modal-background').addEventListener('click', function () {
        const modal = document.getElementById('appointmentModal');
        modal.classList.remove('is-active');
    });

    document.querySelector('.modal-close').addEventListener('click', function () {
        const modal = document.getElementById('appointmentModal');
        modal.classList.remove('is-active');
    });

    function cancelAppointment(appointmentId) {
        if (!document.getElementById("cancelModal")) {
            const modalHtml = `
            <div id="cancelModal" class="modal is-active">
                <div class="modal-background"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Cancel Appointment</p>
                        <button class="delete" aria-label="close" onclick="closeCancelModal()"></button>
                    </header>
                    <section class="modal-card-body">
                        <label for="cancelReason">Reason for Cancellation:</label>
                        <textarea id="cancelReason" class="textarea" placeholder="Enter reason"></textarea>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button is-danger" onclick="submitCancellation(${appointmentId})">Confirm</button>
                        <button class="button" onclick="closeCancelModal()">Close</button>
                    </footer>
                </div>
            </div>
        `;
            document.body.insertAdjacentHTML("beforeend", modalHtml);
        }
    }

    function closeCancelModal() {
        const modal = document.getElementById("cancelModal");
        if (modal) {
            modal.remove();
        }
    }

    function submitCancellation(appointmentId) {
        const reason = document.getElementById("cancelReason").value.trim();

        if (!reason) {
            alert("Please provide a reason for cancellation.");
            return;
        }

        axios.post('./controllers/cancelAppointment.php', {
            appointment_id: appointmentId,
            cancellation_reason: reason
        })
            .then(response => {
                alert("Appointment cancelled successfully.");
                closeCancelModal();
                window.location.reload();
                const appointmentRow = document.getElementById(`appointment-${appointmentId}`);
                if (appointmentRow) {
                    appointmentRow.innerHTML = "<span class='tag is-danger'>Cancelled</span>";
                }
            })
            .catch(error => {
                console.error("Error cancelling appointment:", error);
                alert("Failed to cancel appointment. Please try again.");
            });
    }


</script>
<?php
include_once("./includes/footer.php");
?>