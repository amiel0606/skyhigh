<?php include_once('./includes/header.php'); ?>
<?php include './includes/notification.php'; ?>
<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: ./login.php');
    exit();
}
?>
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
            <h1 class="title">Orders</h1>

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
                        <th>Total</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
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

        <div id="loading" style="display: none;">
            <span>Loading...</span>
        </div>
    </div>
</section>
<script src="../node_modules/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetchPayments();
    });

    function fetchPayments() {
        let url = './controller/getPayments.php';

        const today = new Date();
        const currentDate = today.toISOString().split('T')[0];

        const startDate = '2025-01-27';

        axios.get(url)
            .then(response => {
                let payments = response.data.payments;

                payments = payments.filter(payment => {
                    const paymentDate = new Date(payment.date).toISOString().split('T')[0];
                    return paymentDate >= startDate && paymentDate <= currentDate;
                });

                let tableBody = document.getElementById("orderTableBody");
                tableBody.innerHTML = "";

                payments.forEach(payment => {
                    let payment_intent_id = payment.payment_intent_id;
                    let row = `<tr>
                        <td>${payment.name || 'N/A'}</td>
                        <td>${payment.username || 'N/A'}</td>
                        <td>${(payment.total / 100).toFixed(2)} PHP</td>
                        <td>${new Date(payment.date).toLocaleString()}</td>
                        <td>${payment.status.charAt(0).toUpperCase() + payment.status.slice(1)}</td>
                        <td>
                            <button class="button is-small is-warning" title="Preparing Order" onclick="updateStatus('${payment_intent_id}', 'Preparing')">
                                <span class="icon"><i class="fas fa-cogs"></i></span>
                            </button>
                            <button class="button is-small is-success" title="Ready for Pickup" onclick="updateStatus('${payment_intent_id}', 'Ready for Pickup')">
                                <span class="icon"><i class="fas fa-check-circle"></i></span>
                            </button>
                        </td>
                    </tr>`;
                    tableBody.innerHTML += row;
                });
            })
            .catch(error => {
                console.error("Error fetching payments:", error);
                document.getElementById("loading").innerHTML = `<span style="color:red;">Failed to fetch payments</span>`;
            });
    }

    function updateStatus(payment_intent_id, status) {
        axios.post('./controller/changeTransactionStatus.php', {
            payment_intent_id: payment_intent_id,
            status: status
        })
            .then(function (response) {
                console.log(response.data);
                alert(response.data.message);
            })
            .catch(function (error) {
                console.error(error);
                alert("Error updating the status.");
            });
    }
</script>

<?php include_once('./includes/footer.php'); ?>