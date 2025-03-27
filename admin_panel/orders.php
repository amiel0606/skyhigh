<?php include_once('./includes/header.php'); ?>
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
                        <th>Address</th>
                        <th>Orders</th>
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

<?php include_once('./includes/footer.php'); ?>