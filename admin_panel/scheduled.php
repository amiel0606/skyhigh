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
    </div>
</section>
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

        fetch(url)
            .then(response => response.json())
            .then(data => {
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
                </tr>`;
                    tableBody.innerHTML += row;
                });
            })
            .catch(error => console.error("Error fetching data:", error));
    }
</script>


<?php include_once('./includes/footer.php'); ?>