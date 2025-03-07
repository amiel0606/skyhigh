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
<!-- Product Upload Modal -->
<div id="uploadProductModal" class="modal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Add Product</p>
            <button class="delete" aria-label="close" onclick="closeModal()"></button>
        </header>
        <form action="./controller/uploadProducts.php" method="POST" enctype="multipart/form-data">
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Product Name</label>
                    <div class="control">
                        <input class="input" type="text" name="product_name" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Product Image</label>
                    <div class="file has-name is-fullwidth">
                        <label class="file-label">
                            <input class="file-input" type="file" name="product_image" required>
                            <span class="file-cta">
                                <span class="icon">
                                    <i class="fas fa-upload"></i>
                                </span>
                                <span>Choose a file…</span>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Description</label>
                    <div class="control">
                        <textarea class="textarea" name="description" required></textarea>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Price</label>
                    <div class="control">
                        <input class="input" type="number" name="price" step="0.01" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Category</label>
                    <div class="control">
                        <input class="input" type="text" name="category" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Stock</label>
                    <div class="control">
                        <input class="input" type="number" name="stock" required>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-success" type="submit">Save</button>
                <button class="button" type="button" onclick="closeModal()">Cancel</button>
            </footer>
        </form>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="is-flex is-align-items-center is-justify-content-space-between">
            <h1 class="title">Products</h1>
            <div class="field has-addons">
                <div class="control mr-6">
                    <button id="editProducts" class="button is-small is-primary" onclick="editProducts()">Edit
                        Products</button>
                    <button id="saveProduct" class="button is-small is-primary" style="display: none;"
                        onclick="saveProducts()">Save Products</button>
                    <button class="button is-small is-primary" onclick="openModal()">Add Product</button>

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
                    <!-- Data will be loaded here using AJAX -->
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
            for (let i = 0; i < cells.length - 1; i++) { // Exclude last column (Status)
                if (i === 1) continue; // Skip the image column

                const cellContent = cells[i].textContent.trim();
                cells[i].innerHTML = `<input type="text" value="${cellContent}" class="input is-small">`;
            }
        }
    }

    function saveProducts() {
        document.getElementById('editProducts').style.display = 'inline-block';
        document.getElementById('saveProduct').style.display = 'none';

        const tableBody = document.getElementById('productsTableBody');
        const rows = tableBody.getElementsByTagName('tr');

        let updatedProducts = [];

        for (let row of rows) {
            const cells = row.getElementsByTagName('td');

            let productData = {
                name: cells[0].getElementsByTagName('input')[0].value,
                description: cells[2].getElementsByTagName('input')[0].value,
                price: cells[3].getElementsByTagName('input')[0].value.replace(/[₱,]/g, ''),
                category: cells[4].getElementsByTagName('input')[0].value,
                stock: cells[5].getElementsByTagName('input')[0].value,
                id: row.dataset.productId 
            };

            updatedProducts.push(productData);

            // Restore table content
            cells[0].textContent = productData.name;
            cells[2].textContent = productData.description;
            cells[3].textContent = productData.price;
            cells[4].textContent = productData.category;
            cells[5].textContent = productData.stock;
        }

        // Send data to server via AJAX
        $.ajax({
            url: "./controller/updateProducts.php",
            type: "POST",
            data: { products: JSON.stringify(updatedProducts) },
            success: function (response) {
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.error("Error updating products:", error);
            }
        });
    }


    function fetchProducts() {
        $.ajax({
            url: "./controller/fetchProducts.php",
            type: "GET",
            dataType: "json",
            success: function (response) {
                let tableContent = "";
                if (response.length > 0) {
                    response.forEach(product => {
                        let statusClass = product.status.toLowerCase() === "available" ? "available" : "unavailable";
                        tableContent += `
                                <tr data-product-id="${product.product_id}"> >
                                    <td>${product.product_name}</td>
                                    <td>
                                        <div class="image-container">
                                            <img src="${product.image}" width="50px" height="50px" alt="Product Image">
                                            <div class="overlay-buttons">
                                                <button class="button is-small is-info"><i class="fa-solid fa-upload"></i></button>
                                                <button class="button is-small is-danger"><i class="fa-solid fa-x"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${product.product_desc}</td>
                                    <td>₱${product.price}</td>
                                    <td>${product.product_category}</td>
                                    <td>${product.stock}</td>
                                    <td>
                                        <button class="toggle-button ${statusClass}" onclick="toggleStatus(this)">${product.status}</button>
                                    </td>
                                </tr>
                            `;
                    });
                } else {
                    tableContent = "<tr><td colspan='7'>No products found.</td></tr>";
                }
                $("#productsTableBody").html(tableContent);
            },
            error: function () {
                $("#productsTableBody").html("<tr><td colspan='7'>Error fetching data.</td></tr>");
            }
        });
    }
    fetchProducts(); // Load products on page load

    function openModal() {
        document.getElementById("uploadProductModal").classList.add("is-active");
    }

    function closeModal() {
        document.getElementById("uploadProductModal").classList.remove("is-active");
    }
</script>
<?php include_once('./includes/footer.php'); ?>