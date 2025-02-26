<?php include_once('./includes/header.php'); ?>
<style>
    .table-container {
        max-height: 400px;
        overflow-y: auto;
    }

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

    .table-container {
        height: 700px;
        overflow-y: auto;
    }

    th {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 1;
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
                    <form action="./controllers/setAppointment.php" method="POST">
                        <div class="columns dashed">
                            <div class="column">
                                <h5 class="title is-5">Client Information</h5>
                                <div class="field">
                                    <label class="label">Name</label>
                                    <div class="control">
                                        <input type="text" id="appointmentName" name="name" value="<?php echo $name; ?>" class="input" placeholder="Enter name">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Email</label>
                                    <div class="control">
                                        <input type="email" id="appointmentEmail" name="username" value="<?php echo $username; ?>" class="input" placeholder="Enter email">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Address</label>
                                    <div class="control">
                                        <input type="text" id="appointmentAddress" name="address" value="<?php echo $address; ?>" class="input" placeholder="Enter address">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Phone Number</label>
                                    <div class="control">
                                        <input name="contact" type="number" id="appointmentContact"
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
                                        <input type="text" id="appointmentVehicle" name="vehicle" class="input" placeholder="Enter vehicle type">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Select Service</label>
                                    <div class="control">
                                        <input type="text" id="appointmentService" name="service" class="input" placeholder="Enter service">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Select Time</label>
                                    <div class="control">
                                        <input type="time" id="appointmentTime" name="time" class="input" min="10:00" max="20:00">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Date</label>
                                    <div class="control">
                                        <input type="date" id="appointmentDate" name="date" class="input" min="<?php echo $today; ?>">
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

    function fetchSchedules(searchQuery = '') {
        let url = './controller/getSchedules.php';
        if (searchQuery) {
            url += `?query=${encodeURIComponent(searchQuery)}`;
        }
        axios.get(url)
            .then(response => {
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
                <td>${schedule.address}</td>
                <td>${schedule.contact}</td>
                <td>${schedule.vehicle}</td>
                <td>${schedule.service}</td>
                <td>${schedule.date} ${schedule.time}</td>
                <td>
                    <span class="tag ${schedule.status === 'Confirmed' ? 'is-success' : 'is-warning'}">
                        ${schedule.status}
                    </span>
                </td>
                <td>
                    <div class="buttons">
                        <button class="button is-small is-success">
                            <span class="icon">
                                <i class="fas fa-check"></i>
                            </span>
                        </button>
                        <button id=${schedule.a_id} class="button btn-reject is-small is-danger">
                            <span class="icon">
                                <i class="fas fa-times"></i>
                            </span>
                        </button>
                        <button id=${schedule.a_id} class="button showResched is-small is-warning">
                            <span class="icon">
                                <i class="fa-solid fa-calendar-days"></i>
                            </span>
                        </button>
                    </div>
                </td>
            </tr>`;
                    tableBody.innerHTML += row;
                });

                const rescheduleButtons = document.querySelectorAll('.showResched');
                rescheduleButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const appointmentId = this.id; 
                        fetchScheduleDetails(appointmentId);
                    });
                });

            })
            .catch(error => {
                console.error("Error fetching data:", error);
            });
    }

    function fetchScheduleDetails(appointmentId) {
        let url = `./controller/getSchedules.php?id=${appointmentId}`;
        axios.get(url)
            .then(response => {
                const schedule = response.data; 
                document.getElementById('appointmentName').value = schedule.name;
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
</script>


<?php include_once('./includes/footer.php'); ?>