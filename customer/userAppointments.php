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
<!-- Modal HTML (Bulma Style) -->
<div id="appointmentModal" class="modal">
    <div class="modal-background"></div>
    <div class="modal-content has-background-primary p-5">
            <h1 class="title">Appointment Details</h1>
            <p><strong>Vehicle:</strong> <span id="modal-vehicle"></span></p>
            <p><strong>Service:</strong> <span id="modal-service"></span></p>
            <p><strong>Date:</strong> <span id="modal-date"></span></p>
            <p><strong>Time:</strong> <span id="modal-time"></span></p>
            <p><strong>Status:</strong> <span id="modal-status"></span></p>

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
        document.getElementById('modal-vehicle').textContent = appointment.vehicle;
        document.getElementById('modal-service').textContent = appointment.service;
        document.getElementById('modal-date').textContent = appointment.date;
        document.getElementById('modal-time').textContent = appointment.time;
        document.getElementById('modal-status').textContent = appointment.status;

        const modal = document.getElementById('appointmentModal');
        modal.classList.add('is-active');
    }

    document.getElementById('closeModal').addEventListener('click', function () {
        const modal = document.getElementById('appointmentModal');
        modal.classList.remove('is-active');
    });

    document.querySelector('.modal-background').addEventListener('click', function () {
        const modal = document.getElementById('appointmentModal');
        modal.classList.remove('is-active');
    });

    document.querySelector('.modal-close').addEventListener('click', function () {
        const modal = document.getElementById('appointmentModal');
        modal.classList.remove('is-active');
    });

</script>
<?php
include_once("./includes/footer.php");
?>