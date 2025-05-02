<?php include_once('./includes/header.php'); ?>
<?php include './includes/notification.php'; ?>
<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: ./login.php');
    exit();
}
?>
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
        gap: 5px;
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
            <button class="button is-primary" id="addWalkinBtn">
                <span class="icon">
                    <i class="fas fa-user-plus"></i>
                </span>
                <span>Add Walk-in</span>
            </button>
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
                        <th>Appointment Type</th>
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
                    <textarea id="cancelReason" cols="50" rows="10" name=""
                        placeholder="Enter reason for cancellation..."></textarea>
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
        <!-- WALK-IN MODAL -->
        <div id="walkinModal" class="modal">
            <div class="modal-background"
                onclick="document.getElementById('walkinModal').classList.remove('is-active')"></div>
            <div class="modal-card">
                <header class="modal-card-head has-background-dark">
                    <p class="modal-card-title has-text-weight-bold has-text-white">Add Walk-in Appointment</p>
                    <button class="delete" aria-label="close"
                        onclick="document.getElementById('walkinModal').classList.remove('is-active')"></button>
                </header>
                <section class="modal-card-body has-background-white">
                    <form id="walkinForm">
                        <div class="columns">
                            <div class="column">
                                <h5 class="title is-5">Client Information</h5>
                                <div class="field">
                                    <label class="label">Name</label>
                                    <div class="control">
                                        <input type="text" id="walkinName" name="name" class="input"
                                            placeholder="Enter name" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Email</label>
                                    <div class="control">
                                        <input type="email" id="walkinEmail" name="username" class="input"
                                            placeholder="Enter email" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Address</label>
                                    <div class="control">
                                        <input type="text" id="walkinAddress" name="address" class="input"
                                            placeholder="Enter address" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Phone Number</label>
                                    <div class="control">
                                        <input name="contact" type="number" id="walkinContact" class="input"
                                            maxlength="11" placeholder="09xxxxxxxxx" required>
                                    </div>
                                </div>
                            </div>

                            <div class="column">
                                <h5 class="title is-5">Appointment Information</h5>
                                <div class="field">
                                    <label class="label">Type of Vehicle</label>
                                    <div class="control">
                                        <input type="text" id="walkinVehicle" name="vehicle" class="input"
                                            placeholder="Enter vehicle type" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Select Service</label>
                                    <div class="control">
                                        <input type="text" id="walkinService" name="service" class="input"
                                            placeholder="Enter service" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Select Time</label>
                                    <div class="control">
                                        <div class="select is-fullwidth">
                                            <select id="walkinTime" name="time" class="input" required>
                                                <option value="">Select Time</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Date</label>
                                    <div class="control">
                                        <input type="date" id="walkinDate" name="date" class="input" required>
                                    </div>
                                </div>
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
    </div>
</section>
<script src="../node_modules/axios/dist/axios.min.js"></script>

<script>
    let selectedAppointmentId = null;
    document.addEventListener("DOMContentLoaded", function () {
        fetchSchedules();
        const dateInput = document.getElementById('walkinDate');
        
        // Get current date in local timezone
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Set to start of day
        
        const maxDate = new Date();
        maxDate.setMonth(maxDate.getMonth() + 3);
        maxDate.setHours(0, 0, 0, 0);

        // Format dates for input
        const formatDate = (date) => {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };

        dateInput.min = formatDate(today);
        dateInput.max = formatDate(maxDate);
        dateInput.value = formatDate(today);

        // Update time slots when date changes
        dateInput.addEventListener('change', function () {
            updateTimeSlots(this.value);
        });

        // Initialize time slots when modal opens
        document.getElementById('addWalkinBtn').addEventListener('click', function () {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            dateInput.value = formatDate(today);
            updateTimeSlots(formatDate(today));
        });
        let searchTimeout;
        document.getElementById("searchInput").addEventListener("input", function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                fetchSchedules(this.value);
            }, 300);
        });

        // Add event listener for walk-in button
        document.getElementById("addWalkinBtn").addEventListener("click", function () {
            document.getElementById("walkinModal").classList.add("is-active");
        });

        // Add event listener for walk-in form submission
        document.getElementById("walkinForm").addEventListener("submit", function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            axios.post('./controller/addWalkinAppointment.php', formData)
                .then(response => {
                    if (response.data.success) {
                        showNotification('success', 'Success', 'Walk-in appointment added successfully');
                        document.getElementById("walkinModal").classList.remove("is-active");
                        fetchSchedules();
                    } else {
                        showNotification('error', 'Error', response.data.message);
                    }
                })
                .catch(error => {
                    console.error(error);
                    showNotification('error', 'Error', 'There was an error adding the walk-in appointment');
                });
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
                <td>${schedule.type}</td>
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
                    showNotification('success', 'Success', 'Appointment Cancelled!');
                    fetchSchedules();
                } else {
                    showNotification('error', 'Error', 'Failed to cancel the appointment!');
                }
            })
            .catch(error => {
                console.error('There was an error rejecting the appointment:', error);
                showNotification('error', 'Error', 'Failed to cancel the appointment!');
            });
    }

    function approveAppointment(appointmentId) {
        const data = new URLSearchParams();
        data.append('appointmentId', appointmentId);
        data.append('status', 'Confirmed');

        axios.post('./controller/changeAppointmentStatus.php', data)
            .then(response => {
                if (response.data.success) {
                    showNotification('success', 'Success', 'Appointment Approved!');
                    fetchSchedules();
                } else {
                    showNotification('error', 'Error', 'Failed to approve the appointment!');
                }
            })
            .catch(error => {
                console.error('There was an error approving the appointment:', error);
                showNotification('error', 'Error', 'Failed to approve the appointment!');
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
                showNotification('success', 'Success', 'Appointment saved successfully');
                window.location.reload();
            })
            .catch(error => {
                console.error(error);
                showNotification('error', 'Error', 'There was an error saving the appointment');
            });
    });

    function showNotification(type, title, message) {
        const notificationId = 'notification-' + Date.now();
        let notificationClass = 'notification is-light';
        let iconClass = 'fas fa-info-circle';

        if (type === 'success') {
            notificationClass += ' is-success';
            iconClass = 'fas fa-check-circle';
        } else if (type === 'error') {
            notificationClass += ' is-danger';
            iconClass = 'fas fa-exclamation-circle';
        } else if (type === 'warning') {
            notificationClass += ' is-warning';
            iconClass = 'fas fa-exclamation-triangle';
        }

        const notificationHtml = `
            <div id="${notificationId}" class="${notificationClass}" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
                <button class="delete"></button>
                <div class="is-flex is-align-items-center">
                    <span class="icon mr-2">
                        <i class="${iconClass}"></i>
                    </span>
                    <div>
                        <p class="has-text-weight-bold">${title}</p>
                        <p>${message}</p>
                    </div>
                </div>
            </div>
        `;

        $('body').append(notificationHtml);

        $(`#${notificationId} .delete`).on('click', function () {
            $(`#${notificationId}`).fadeOut(300, function () {
                $(this).remove();
            });
        });

        setTimeout(function () {
            $(`#${notificationId}`).fadeOut(300, function () {
                $(this).remove();
            });
        }, 5000);
    }

    function generateTimeSlots() {
        const slots = [];
        for (let hour = 10; hour <= 20; hour++) {
            const time24 = `${hour.toString().padStart(2, '0')}:00`;
            const time12 = new Date(`2000-01-01T${time24}`).toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });
            slots.push({ time24, time12 });
        }
        return slots;
    }

    function updateTimeSlots(selectedDate) {
        const timeSelect = document.getElementById('walkinTime');
        timeSelect.innerHTML = '<option value="">Select Time</option>';

        axios.get(`./controller/checkTimeSlots.php?date=${selectedDate}`)
            .then(response => {
                const bookedSlots = response.data.bookedSlots;
                const availableSlots = generateTimeSlots().filter(slot => !bookedSlots.includes(slot.time24));

                if (availableSlots.length === 0) {
                    showNotification('warning', 'No Available Slots', 'All time slots for this date are booked. Please select another date.');
                    timeSelect.disabled = true;
                    return;
                }

                timeSelect.disabled = false;
                availableSlots.forEach(slot => {
                    const option = document.createElement('option');
                    option.value = slot.time24;
                    option.textContent = slot.time12;
                    timeSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error checking time slots:', error);
                showNotification('error', 'Error', 'Failed to check available time slots');
            });
    }
</script>


<?php include_once('./includes/footer.php'); ?>