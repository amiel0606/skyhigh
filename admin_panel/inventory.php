<?php include_once('./includes/header.php'); ?>
<style>
    .is-primary {
        background-color: hsl(var(--bulma-primary-h), var(--bulma-primary-s), var(--bulma-primary-l)) !important;
    }

    .table-container {
        height: 400px;
        overflow-y: auto;
    }

    th {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 1;
    }

    .toggle-button {
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        border: none;
        color: white;
    }

    .available {
        background-color: green;
    }

    .not-available {
        background-color: red;
    }

    .image-container {
        position: relative;
        display: inline-block;
    }

    .image-container:hover .overlay-buttons {
        display: block;
    }

    .overlay-buttons {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        text-align: center;
        padding-top: 20%;
    }

    .overlay-buttons button {
        margin: 5px;
    }
</style>
<section class="section">
    <div class="container">
        <div class="is-flex is-align-items-center is-justify-content-space-between">
            <h1 class="title">Products</h1>
            <div class="field has-addons">
                <div class="control mr-6">
                    <button id="editProducts" class="button is-small is-primary" onclick="editProducts()">Edit Products</button>
                    <button id="saveProduct" class="button is-small is-primary" style="display: none;" onclick="saveProducts()">Save Products</button>
                </div>
                <div class="control has-icons-left">
                    <input class="input is-small" id="searchInput" type="text" placeholder="Search">
                    <span class="icon is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="table-container">
            <table class="table is-fullwidth is-striped">
                <thead class="has-text-centered">
                    <tr>
                        <th>Name</th>
                        <th>Product Image</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="has-text-centered" id="productsTableBody">
                    <tr>
                        <td>Colorado Bray</td>
                        <td>
                            <div class="image-container">
                                <img src="./assets/images/logo.png" width="50px" height="50px" alt="">
                                <div class="overlay-buttons">
                                    <button class="button is-small is-info"><i class="fa-solid fa-upload"></i></button>
                                    <button class="button is-small is-danger"><i class="fa-solid fa-x"></i></button>
                                </div>
                            </div>
                        </td>
                        <td>North-East Region</td>
                        <td>$3.38</td>
                        <td>FNJ76SDX3EW</td>
                        <td>10</td>
                        <td>
                            <button class="toggle-button available" onclick="toggleStatus(this)">Available</button>
                        </td>
                    </tr>
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
            <div class="is-fixed-bottom is-pulled-right">
                <button class="button is-black is-rounded">
                    <span class="icon">
                        <i class="fas fa-comment-dots"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>
</section>

<script>
    function toggleStatus(button) {
        if (button.classList.contains('available')) {
            button.classList.remove('available');
            button.classList.add('not-available');
            button.textContent = 'Not Available';
        } else {
            button.classList.remove('not-available');
            button.classList.add('available');
            button.textContent = 'Available';
        }
    }

    function editProducts() {
        document.getElementById('editProducts').style.display = 'none';
        document.getElementById('saveProduct').style.display = 'inline-block';

        const tableBody = document.getElementById('productsTableBody');
        const rows = tableBody.getElementsByTagName('tr');

        for (let row of rows) {
            const cells = row.getElementsByTagName('td');
            for (let i = 0; i < cells.length; i++) {
                if (i === 1) {
                    continue;
                }
                const cellContent = cells[i].textContent;
                cells[i].innerHTML = `<input type="text" value="${cellContent}" class="input is-small">`;
            }
        }
    }

    function saveProducts() {
        document.getElementById('editProducts').style.display = 'inline-block';
        document.getElementById('saveProduct').style.display = 'none';

        const tableBody = document.getElementById('productsTableBody');
        const rows = tableBody.getElementsByTagName('tr');

        for (let row of rows) {
            const cells = row.getElementsByTagName('td');
            for (let i = 0; i < cells.length; i++) {
                if (i === 1) {
                    continue;
                }
                const inputField = cells[i].getElementsByTagName('input')[0];
                cells[i].textContent = inputField.value;
            }
        }
    }
</script>
<?php include_once('./includes/footer.php'); ?>