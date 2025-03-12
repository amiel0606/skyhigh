<?php include_once('./includes/header.php'); ?>
<style>
    .sticky-header th {
        position: sticky;
        top: 0;
        background: white;
        z-index: 2;
    }

    .profile-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }

    .container {
        margin-left: 350px;
    }

    .table-container {
        height: 600px;
        overflow-y: auto;
    }

    th {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 1;
    }

    .modal-content {
        width: 400px;
    }

    .buttons {
        justify-content: center;
        gap: 15px;
    }
</style>
<section class="section">
    <div class="container">
        <div class="mb-4">
            <a href="./index.php" class="button is-white">
                <span class="icon">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span>Back</span>
            </a>
        </div>

        <div class="is-flex is-align-items-center is-justify-content-space-between">
            <h1 class="title">Schedule</h1>

            <div class="control has-icons-left">
                <input class="input is-small" id="searchInput" type="text" placeholder="Search">
                <span class="icon is-left">
                    <i class="fas fa-search"></i>
                </span>
            </div>
        </div>

        <div class="table-container">
            <table class="table is-fullwidth is-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>CP No.</th>
                        <th>Vehicle</th>
                        <th>Service</th>
                        <th>Date/Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="scheduleTableBody">
                </tbody>
            </table>

        </div>

        <div class="mt-3">
            <button class="button is-small is-danger">
                <span class="icon">
                    <i class="fas fa-sort"></i>
                </span>
                <span>Sort</span>
            </button>
        </div>

        <div class="is-fixed-bottom is-pulled-right m-4">
            <button class="button is-black is-rounded">
                <span class="icon">
                    <i class="fas fa-comment-dots"></i>
                </span>
            </button>
        </div>
        <!-- APPOINTMENT MODAL -->
        <div id="appointmentModal" class="modal">
            <div class="modal-background"
                onclick="document.getElementById('appointmentModal').classList.remove('is-active')">
            </div>
            <div class="modal-card">
                <header class="modal-card-head has-background-dark ">
                    <p class="modal-card-title has-text-weight-bold has-text-white">Re-schedule an appointment</p>
                    <button class="delete" aria-label="close"
                        onclick="document.getElementById('appointmentModal').classList.remove('is-active')"></button>
                </header>
                <section class="modal-card-body has-background-white">
                    <form id="appointmentForm">
                        <input type="hidden" name="appointmentId" id="appointmentId">
                        <div class="columns dashed">
                            <div class="column">
                                <h5 class="title is-5">Client Information</h5>
                                <div class="field">
                                    <label class="label">Name</label>
                                    <div class="control">
                                        <input type="text" id="appointmentName" name="name" readonly class="input"
                                            placeholder="Enter name">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Email</label>
                                    <div class="control">
                                        <input type="email" id="appointmentEmail" name="username" readonly class="input"
                                            placeholder="Enter email">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Address</label>
                                    <div class="control">
                                        <input type="text" id="appointmentAddress" name="address" readonly class="input"
                                            placeholder="Enter address">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Phone Number</label>
                                    <div class="control">
                                        <input name="contact" type="number" id="appointmentContact"
                                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                            type="number" maxlength="11" class="input" readonly
                                            placeholder="09xxxxxxxxx">
                                    </div>
                                </div>
                            </div>

                            <div class="column">
                                <h5 class="title is-5">Appointment Information</h5>
                                <div class="field">
                                    <label class="label">Type of Vehicle</label>
                                    <div class="control">
                                        <input type="text" id="appointmentVehicle" readonly name="vehicle" class="input"
                                            placeholder="Enter vehicle type">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Select Service</label>
                                    <div class="control">
                                        <input type="text" id="appointmentService" readonly name="service" class="input"
                                            placeholder="Enter service">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Select Time</label>
                                    <div class="control">
                                        <input type="time" id="appointmentTime" name="time" class="input" min="10:00"
                                            max="20:00">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Date</label>
                                    <div class="control">
                                        <input type="date" id="appointmentDate" name="date" class="input"
                                            min="<?php echo $today; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Reason</label>
                            <div class="control">
                                <textarea rows="14" cols="96" id="appointmentReason" name="reason"
                                    placeholder="Enter Reason"></textarea>
                            </div>
                        </div>
                        <p class="has-text-centered mt-3">Appointment Starts at 10:00 AM</p>
                        <div class="has-text-centered">
                            <button type="submit" class="button button-submit is-success">SAVE</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
        <div id="confirmationModal" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="box">
                    <h4 class="title is-4">Enter reason for cancellation</h4>
                    <textarea id="cancelReason" cols="50" rows="10" name="" placeholder="Enter reason for cancellation..."></textarea>
                    <div class="buttons is-centered">
                        <button id="confirmCancelBtn" class="button is-danger">Submit</button>
                        <button id="cancelModalBtn" class="button">No, keep it</button>
                    </div>
                </div>
            </div>
            <button class="modal-close is-large" aria-label="close"></button>
        </div>
        <div id="loading" style="display: none;">
            <span>Loading...</span>
        </div>
    </div>
</section>
<script src="../node_modules/axios/dist/axios.min.js"></script>

<script>
    let selectedAppointmentId = null;
    document.addEventListener("DOMContentLoaded", function () {
        fetchSchedules();
        let searchTimeout;
        document.getElementById("searchInput").addEventListener("input", function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                fetchSchedules(this.value);
            }, 300);
        });
    });

    async function fetchSchedules(searchQuery = '') {
        document.getElementById('loading').style.display = 'block';

        let url = './controller/getSchedules.php';
        if (searchQuery) {
            url += `?query=${encodeURIComponent(searchQuery)}`;
        }

        try {
            const response = await axios.get(url);
            const data = response.data;

            let tableBody = document.getElementById("scheduleTableBody");
            tableBody.innerHTML = "";

            if (data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="7" class="has-text-centered">No results found</td></tr>`;
                return;
            }

            data.forEach(schedule => {
                let row = `<tr>
                <td>${schedule.name}</td>
                <td>${schedule.username}</td>
                <td>${schedule.address}</td>
                <td>${schedule.contact}</td>
                <td>${schedule.vehicle}</td>
                <td>${schedule.service}</td>
                <td>${schedule.date} ${schedule.time}</td>
                <td>
                    <span class="tag ${schedule.status === 'Confirmed' ? 'is-success' : schedule.status === 'Declined' ? 'is-danger' : 'is-warning'}">
                        ${schedule.status}
                    </span>
                </td>
                <td>
                    <div class="buttons">`;
                if (schedule.status === 'Pending') {
                    row += `
                    <button id="${schedule.a_id}" class="button btn-accept is-small is-success">
                        <span class="icon">
                            <i class="fas fa-check"></i>
                        </span>
                    </button>
                    <button id="${schedule.a_id}" data-status="${schedule.status}" class="button btn-reject is-small is-danger">
                        <span class="icon">
                            <i class="fas fa-times"></i>
                        </span>
                    </button>
                    <button id="${schedule.a_id}" class="button showResched is-small is-warning">
                        <span class="icon">
                            <i class="fa-solid fa-calendar-days"></i>
                        </span>
                    </button>
                `;
                } else if (schedule.status === 'Confirmed') {
                    row += `
                    <button id="${schedule.a_id}" data-status="${schedule.status}" class="button btn-reject is-small is-danger">
                        <span class="icon">
                            <i class="fas fa-times"></i>
                        </span>
                    </button>
                    <button id="${schedule.a_id}" class="button showResched is-small is-warning">
                        <span class="icon">
                            <i class="fa-solid fa-calendar-days"></i>
                        </span>
                    </button>
                `;
                } else if (schedule.status === 'Declined') {
                    row += `
                    <button id="${schedule.a_id}" class="button showResched is-small is-warning">
                        <span class="icon">
                            <i class="fa-solid fa-calendar-days"></i>
                        </span>
                    </button>
                `;
                }

                row += `</div></td></tr>`;

                tableBody.innerHTML += row;
            });
            const rescheduleButtons = document.querySelectorAll('.showResched');
            rescheduleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const appointmentId = this.id;
                    fetchScheduleDetails(appointmentId);
                });
            });

            addApproveButtonEventListeners();
            addRejectButtonEventListeners();
        } catch (error) {
            console.error("Error fetching data:", error);
        } finally {
            document.getElementById('loading').style.display = 'none';
        }
    }

    function addApproveButtonEventListeners() {
        const approveButtons = document.querySelectorAll('.btn-accept');
        approveButtons.forEach(button => {
            button.addEventListener('click', function () {
                const appointmentId = this.id;
                approveAppointment(appointmentId);
            });
        });
    }

    function addRejectButtonEventListeners() {
        const rejectButtons = document.querySelectorAll('.btn-reject');
        rejectButtons.forEach(button => {
            button.addEventListener('click', function () {
                const appointmentId = this.id;
                const appointmentStatus = this.dataset.status;

                if (appointmentStatus === 'Confirmed' || appointmentStatus === 'Pending') {
                    showConfirmationModal(appointmentId);
                } else {
                    rejectAppointment(appointmentId);
                }
            });
        });
    }
    function showConfirmationModal(appointmentId) {
        const modal = document.getElementById('confirmationModal');
        const confirmBtn = document.getElementById('confirmCancelBtn');
        const cancelBtn = document.getElementById('cancelModalBtn');

        modal.classList.add('is-active');

        confirmBtn.onclick = function () {
            rejectAppointment(appointmentId);
            modal.classList.remove('is-active');
        };
        cancelBtn.onclick = function () {
            modal.classList.remove('is-active');
        };

        const closeModalBtn = modal.querySelector('.modal-close');
        closeModalBtn.onclick = function () {
            modal.classList.remove('is-active');
        };

        window.onclick = function (event) {
            if (event.target === modal) {
                modal.classList.remove('is-active');
            }
        };
    }

    function rejectAppointment(appointmentId) {
        const data = new URLSearchParams();
        data.append('appointmentId', appointmentId);
        data.append('status', 'declined');
        data.append('reason', document.getElementById('cancelReason').value);
        axios.post('./controller/changeAppointmentStatus.php', data)
            .then(response => {
                if (response.data.success) {
                    alert('Appointment Cancelled!');
                    fetchSchedules();
                } else {
                    alert('Failed to cancel the appointment!');
                }
            })
            .catch(error => {
                console.error('There was an error rejecting the appointment:', error);
            });
    }

    function approveAppointment(appointmentId) {
        const data = new URLSearchParams();
        data.append('appointmentId', appointmentId);
        data.append('status', 'approved');

        axios.post('./controller/changeAppointmentStatus.php', data)
            .then(response => {
                if (response.data.success) {
                    alert('Appointment Approved!');
                    fetchSchedules();
                } else {
                    alert('Failed to approve the appointment!');
                }
            })
            .catch(error => {
                console.error('There was an error approving the appointment:', error);
            });
    }

    function fetchScheduleDetails(appointmentId) {
        let url = `./controller/getSchedules.php?id=${appointmentId}`;
        axios.get(url)
            .then(response => {
                const schedule = response.data;
                document.getElementById('appointmentName').value = schedule.name;
                document.getElementById('appointmentId').value = schedule.a_id;
                document.getElementById('appointmentEmail').value = schedule.username;
                document.getElementById('appointmentAddress').value = schedule.address;
                document.getElementById('appointmentContact').value = schedule.contact;
                document.getElementById('appointmentVehicle').value = schedule.vehicle;
                document.getElementById('appointmentService').value = schedule.service;
                document.getElementById('appointmentDate').value = schedule.date;
                document.getElementById('appointmentTime').value = schedule.time;
                document.getElementById('appointmentModal').classList.add('is-active');
            })
            .catch(error => {
                console.error("Error fetching schedule details:", error);
            });
    }

    document.getElementById('appointmentForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        axios.post('./controller/updateAppointment.php', formData)
            .then(response => {
                alert('Appointment saved successfully');
                window.location.reload();
            })
            .catch(error => {
                console.error(error);
                alert('There was an error saving the appointment');
            });
    });
</script>


<?php include_once('./includes/footer.php'); ?>