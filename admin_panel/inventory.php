<?php include_once('./includes/header.php'); ?>
<?php include './includes/notification.php'; ?>
<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: ./login.php');
    exit();
}
?>
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

    .unavailable {
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

    .notification-container {
        position: fixed;
        top: 20px;
        right: 150px;
        z-index: 1000;
    }
    
    .notification {
        margin-bottom: 10px;
    }
</style>

<!-- Add notification container -->
<div id="notificationContainer" class="notification-container"></div>

<script>
// Function to show notification
function showNotification(message, type = 'is-success') {
    const container = document.getElementById('notificationContainer');
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    
    // Add delete button
    const deleteButton = document.createElement('button');
    deleteButton.className = 'delete';
    deleteButton.onclick = () => notification.remove();
    
    notification.appendChild(deleteButton);
    notification.appendChild(document.createTextNode(message));
    container.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => notification.remove(), 5000);
}

// Check for URL parameters on page load
window.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    
    if (error === 'none') {
        showNotification('Success!', 'is-success');
    }
    if (error === 'uploadFailed') {
        showNotification('Failed to upload product!', 'is-danger');
    }
    if (error === 'invalidImage') {
        showNotification('Invalid image format!', 'is-danger');
    }
    if (error === 'imageTooLarge') {
        showNotification('Image size too large!', 'is-danger');
    }
    if (error === 'stmtFailed') {
        showNotification('Database error occurred!', 'is-danger');
    }
});
</script>

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
                    <label class="label">Brand</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="brand_name" id="brandSelect" required>
                                <option value="">Select a brand</option>
                                <!-- Brands will be loaded here -->
                            </select>
                        </div>
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

<div id="brandModal" class="modal">
    <div class="modal-background" onclick="closeBrandModal()"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title" id="brandModalTitle">Add Brand</p>
            <button class="delete" aria-label="close" onclick="closeBrandModal()"></button>
        </header>

        <form id="brandForm">
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Brand Name</label>
                    <div class="control">
                        <input class="input" type="text" id="brandNameInput" name="brand_name" required>
                        <input type="hidden" id="brandIdInput" name="brand_id">
                    </div>
                </div>
            </section>

            <footer class="modal-card-foot">
                <button class="button is-success" type="submit">Save</button>
                <button class="button" type="button" onclick="closeBrandModal()">Cancel</button>
            </footer>
        </form>
    </div>
</div>

<!-- Service Modal -->
<div id="serviceModal" class="modal">
    <div class="modal-background" onclick="closeServiceModal()"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title" id="serviceModalTitle">Add Service</p>
            <button class="delete" aria-label="close" onclick="closeServiceModal()"></button>
        </header>

        <form id="serviceForm">
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Service Name</label>
                    <div class="control">
                        <input class="input" type="text" id="serviceNameInput" name="service_name" required>
                        <input type="hidden" id="serviceIdInput" name="service_id">
                    </div>
                </div>
                
                <div class="field">
                    <label class="label">Description</label>
                    <div class="control">
                        <textarea class="textarea" id="serviceDescInput" name="service_description" required></textarea>
                    </div>
                </div>
            </section>

            <footer class="modal-card-foot">
                <button class="button is-success" type="submit">Save</button>
                <button class="button" type="button" onclick="closeServiceModal()">Cancel</button>
            </footer>
        </form>
    </div>
</div>

<section class="section">
    <div class="container">
        <nav class="breadcrumb is-medium" aria-label="breadcrumbs" style="margin-bottom: 1rem;">
            <ul>
                <li id="tab-products"><a href="#" onclick="showTab('products')">Products</a></li>
                <li id="tab-brands"><a href="#" onclick="showTab('brands')">Brands</a></li>
                <li id="tab-services"><a href="#" onclick="showTab('services')">Services</a></li>
            </ul>
        </nav>

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
                        <th>Brand</th>
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

<section class="section" id="brandsSection" style="display: none;">
    <div class="container">
        <nav class="breadcrumb is-medium" aria-label="breadcrumbs" style="margin-bottom: 1rem;">
            <ul>
                <li id="tab-products"><a href="#" onclick="showTab('products')">Products</a></li>
                <li class="is-active" id="tab-brands"><a href="#" onclick="showTab('brands')">Brands</a></li>
                <li id="tab-services"><a href="#" onclick="showTab('services')">Services</a></li>
            </ul>
        </nav>
        <div class="is-flex is-align-items-center is-justify-content-space-between">
            <h1 class="title">Brands</h1>
            <button class="button is-small is-primary" onclick="openBrandModal()">Add Brand</button>
        </div>
        <div class="table-container">
            <table class="table is-fullwidth is-striped">
                <thead>
                    <tr>
                        <th>Brand Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="brandsTableBody">
                    <!-- Brand data will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="section" id="servicesSection" style="display: none;">
    <div class="container">
        <nav class="breadcrumb is-medium" aria-label="breadcrumbs" style="margin-bottom: 1rem;">
            <ul>
                <li id="tab-products"><a href="#" onclick="showTab('products')">Products</a></li>
                <li id="tab-brands"><a href="#" onclick="showTab('brands')">Brands</a></li>
                <li class="is-active" id="tab-services"><a href="#" onclick="showTab('services')">Services</a></li>
            </ul>
        </nav>
        <div class="is-flex is-align-items-center is-justify-content-space-between">
            <h1 class="title">Services</h1>
            <button class="button is-small is-primary" onclick="openServiceModal()">Add Service</button>
        </div>
        <div class="table-container">
            <table class="table is-fullwidth is-striped" id="servicesTable">
                <thead>
                    <tr>
                        <th>Service Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="servicesTableBody">
                    <!-- Service data will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>
</section>

<script src="../node_modules/axios/dist/axios.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetchBrands();

        document.getElementById('brandForm').addEventListener('submit', function (e) {
            e.preventDefault();
            submitBrandForm();
        });

        document.getElementById('serviceForm').addEventListener('submit', function (e) {
            e.preventDefault();
            submitServiceForm();
        });
    });
    function toggleStatus(button) {
        let productId = button.getAttribute("data-id");
        let currentStatus = button.classList.contains('available') ? 'available' : 'unavailable';
        let newStatus = currentStatus === 'available' ? 'unavailable' : 'available';

        button.classList.toggle('available');
        button.classList.toggle('unavailable');
        button.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

        axios.post('./controller/updateStatus.php', {
            product_id: productId,
            status: newStatus
        })
            .then(response => {
                if (!response.data.success) {
                    alert("Failed to update product status.");
                    console.error(response.data.message);
                    button.classList.toggle('available');
                    button.classList.toggle('unavailable');
                    button.textContent = currentStatus.charAt(0).toUpperCase() + currentStatus.slice(1);
                } else {
                    fetchProducts();
                }
            })
            .catch(error => {
                console.error("Error updating status:", error);
                alert("Something went wrong!");
                button.classList.toggle('available');
                button.classList.toggle('unavailable');
                button.textContent = currentStatus.charAt(0).toUpperCase() + currentStatus.slice(1);
            });
    }

    function editProducts() {
        document.getElementById('editProducts').style.display = 'none';
        document.getElementById('saveProduct').style.display = 'inline-block';

        // First fetch all brands
        axios.get('./controller/fetchBrands.php')
            .then(function (response) {
                const brands = response.data;
                const tableBody = document.getElementById('productsTableBody');
                const rows = tableBody.getElementsByTagName('tr');

                for (let row of rows) {
                    const cells = row.getElementsByTagName('td');
                    for (let i = 0; i < cells.length - 1; i++) {
                        if (i === 1) continue; // Skip image cell

                        if (i === 5) { // Brand column
                            const currentBrandId = row.dataset.brandId; // Get brand ID from data attribute
                            let brandDropdown = `<select class="input is-small">`;
                            brands.forEach(brand => {
                                const selected = brand.b_id === currentBrandId ? 'selected' : '';
                                brandDropdown += `<option value="${brand.b_id}" ${selected}>${brand.brand_name}</option>`;
                            });
                            brandDropdown += '</select>';
                            cells[i].innerHTML = brandDropdown;
                        } else {
                            const cellContent = cells[i].textContent.trim();
                            cells[i].innerHTML = `<input type="text" value="${cellContent}" class="input is-small">`;
                        }
                    }
                }
            })
            .catch(function (error) {
                console.error("Error fetching brands:", error);
                showNotification('Error loading brands', 'is-danger');
            });
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
                brand: cells[5].getElementsByTagName('select')[0].value,
                stock: cells[6].getElementsByTagName('input')[0].value,
                id: row.dataset.productId
            };

            updatedProducts.push(productData);
            cells[0].textContent = productData.name;
            cells[2].textContent = productData.description;
            cells[3].textContent = productData.price;
            cells[4].textContent = productData.category;
            cells[5].textContent = cells[5].getElementsByTagName('select')[0].options[cells[5].getElementsByTagName('select')[0].selectedIndex].text;
            cells[6].textContent = productData.stock;
        }

        axios.post("./controller/updateProducts.php", { products: JSON.stringify(updatedProducts) })
            .then(function (response) {
                if (response.data.success) {
                    showNotification('Products updated successfully!', 'is-success');
                } else {
                    showNotification('Failed to update products', 'is-danger');
                }
                fetchProducts();
            })
            .catch(function (error) {
                console.error("Error updating products:", error);
                showNotification('Error updating products', 'is-danger');
            });
    }


    function fetchProducts() {
        axios.get("./controller/fetchProducts.php")
            .then(function (response) {
                let tableContent = "";
                if (response.data.length > 0) {
                    response.data.forEach(product => {
                        let statusClass = product.status.toLowerCase() === "available" ? "available" : "unavailable";
                        tableContent += `
                                <tr data-product-id="${product.product_id}" data-brand-id="${product.brand}">
                                    <td>${product.product_name}</td>
                                    <td>
                                        <div class="image-container">
                                            <img src="${product.image}" width="150px" height="150px" alt="Product Image">
                                            <div class="overlay-buttons">
                                                <button class="button is-small is-info" onclick="uploadProductImage(${product.product_id})"><i class="fa-solid fa-upload"></i></button>
                                                <button class="button is-small is-primary" onclick="viewProductImage('${product.image}')"><i class="fa-solid fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${product.product_desc}</td>
                                    <td>₱${product.price}</td>
                                    <td>${product.product_category}</td>
                                    <td>${product.brand_name}</td>
                                    <td>${product.stock}</td>
                                    <td>
                                        <button data-id="${product.product_id}" class="toggle-button ${statusClass}" onclick="toggleStatus(this)">${product.status}</button>
                                    </td>
                                </tr>
                            `;
                    });
                } else {
                    tableContent = "<tr><td colspan='8'>No products found.</td></tr>";
                }
                $("#productsTableBody").html(tableContent);
            })
            .catch(function () {
                $("#productsTableBody").html("<tr><td colspan='8'>Error fetching data.</td></tr>");
            });
    }
    fetchProducts();

    function openModal() {
        populateBrandDropdown();
        document.getElementById("uploadProductModal").classList.add("is-active");
    }

    function closeModal() {
        document.getElementById("uploadProductModal").classList.remove("is-active");
    }

    // Tab switching
    function showTab(tab) {
        if (tab === 'products') {
            document.querySelector('#tab-products').classList.add('is-active');
            document.querySelector('#tab-brands').classList.remove('is-active');
            document.querySelector('#tab-services').classList.remove('is-active');
            document.querySelector('section.section').style.display = '';
            document.querySelector('#brandsSection').style.display = 'none';
            document.querySelector('#servicesSection').style.display = 'none';
        } else if (tab === 'brands') {
            document.querySelector('#tab-products').classList.remove('is-active');
            document.querySelector('#tab-brands').classList.add('is-active');
            document.querySelector('#tab-services').classList.remove('is-active');
            document.querySelector('section.section').style.display = 'none';
            document.querySelector('#brandsSection').style.display = '';
            document.querySelector('#servicesSection').style.display = 'none';
            fetchBrands();
        } else if (tab === 'services') {
            document.querySelector('#tab-products').classList.remove('is-active');
            document.querySelector('#tab-brands').classList.remove('is-active');
            document.querySelector('#tab-services').classList.add('is-active');
            document.querySelector('section.section').style.display = 'none';
            document.querySelector('#brandsSection').style.display = 'none';
            document.querySelector('#servicesSection').style.display = '';
            fetchServices();
        }
    }

    // Brand Modal
    function openBrandModal(edit = false, brand = null) {
        document.getElementById('brandModal').classList.add('is-active');
        document.getElementById('brandModalTitle').textContent = edit ? 'Edit Brand' : 'Add Brand';
        document.getElementById('brandNameInput').value = brand ? brand.brand_name : '';
        document.getElementById('brandIdInput').value = brand ? brand.b_id : '';
    }
    function closeBrandModal() {
        document.getElementById('brandModal').classList.remove('is-active');
    }

    function fetchBrands() {
        axios.get('./controller/fetchBrands.php')
            .then(function (response) {
                const brands = response.data;
                const $tbody = $('#brandsTableBody');
                $tbody.empty();

                if (brands.length > 0) {
                    brands.forEach(brand => {
                        const $row = $('<tr></tr>');
                        $row.append(`<td>${escapeHtml(brand.brand_name)}</td>`);

                        const $actions = $('<td></td>');

                        const $editBtn = $('<button class="button is-small is-info">Edit</button>');
                        $editBtn.on('click', () => openBrandModal(true, brand));

                        const $deleteBtn = $('<button class="button is-small is-danger">Delete</button>');
                        $deleteBtn.on('click', () => deleteBrand(brand.b_id));

                        $actions.append($editBtn, ' ', $deleteBtn);
                        $row.append($actions);
                        $tbody.append($row);
                    });
                } else {
                    $tbody.html('<tr><td colspan="2">No brands found.</td></tr>');
                }
            })
            .catch(() => {
                $('#servicesTable').html('<tr><td colspan="2">Error fetching data.</td></tr>');
            });
    }

    function submitBrandForm(e) {
        const brandName = $('#brandNameInput').val().trim();
        const brandId = $('#brandIdInput').val();
        if (!brandName) return alert('Brand name is required.');

        const url = brandId ? './controller/updateBrand.php' : './controller/addBrand.php';
        axios.post(url, {
            brand_name: brandName,
            brand_id: brandId
        })
            .then(() => {
                closeBrandModal();
                fetchBrands();
            })
            .catch(() => {
                alert("Error saving brand.");
            });
    }

    function deleteBrand(brandId) {
        if (!confirm("Are you sure you want to delete this brand?")) return;

        axios.post('./controller/deleteBrand.php', {
            brand_id: brandId
        })
        .then(response => {
            const data = response.data;
            if (data.success) {
                showNotification(data.message, 'is-success');
                fetchBrands();
            } else {
                showNotification(data.message, 'is-danger');
            }
        })
        .catch(() => {
            showNotification("Error deleting brand.", 'is-danger');
        });
    }

    function openBrandModal(isEdit = false, brand = null) {
        $('#brandModalTitle').text(isEdit ? 'Edit Brand' : 'Add Brand');
        $('#brandNameInput').val(isEdit ? brand.brand_name : '');
        $('#brandIdInput').val(isEdit ? brand.b_id : '');
        $('#brandModal').addClass('is-active');
    }

    function closeBrandModal() {
        document.getElementById('brandForm')[0].reset();
        $('#brandIdInput').val('');
        $('#brandModal').removeClass('is-active');
    }

    function escapeHtml(text) {
        if (typeof text !== 'string') return '';
        return text.replace(/[&<>"']/g, function (match) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return map[match];
        });
    }

    function populateBrandDropdown() {
        axios.get('./controller/fetchBrands.php')
            .then(function (response) {
                const brands = response.data;
                const $brandSelect = $('#brandSelect');
                $brandSelect.empty();
                $brandSelect.append('<option value="">Select a brand</option>');
                brands.forEach(function (brand) {
                    $brandSelect.append(`<option value="${brand.b_id}">${escapeHtml(brand.brand_name)}</option>`);
                });
            })
            .catch(function () {
                $('#brandSelect').html('<option value="">Error loading brands</option>');
            });
    }

    // View Product Image in Modal
    function viewProductImage(imageUrl) {
        if (!document.getElementById('viewImageModal')) {
            const modalHtml = `
                <div class="modal" id="viewImageModal">
                    <div class="modal-background" onclick="closeViewImageModal()"></div>
                    <div class="modal-content" style="display: flex; justify-content: center; align-items: center;">
                        <img id="modalProductImage" src="" style="max-width: 90vw; max-height: 80vh; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.2);" />
                    </div>
                    <button class="modal-close is-large" aria-label="close" onclick="closeViewImageModal()"></button>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }
        document.getElementById('modalProductImage').src = imageUrl;
        document.getElementById('viewImageModal').classList.add('is-active');
    }

    function closeViewImageModal() {
        document.getElementById('viewImageModal').classList.remove('is-active');
    }

    function uploadProductImage(productId) {
        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.accept = 'image/*';
        fileInput.style.display = 'none';

        fileInput.addEventListener('change', function () {
            if (fileInput.files.length === 0) return;
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('product_image', fileInput.files[0]);

            axios.post('./controller/updateProducts.php', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
            .then(function (response) {
                if (response.data.success) {
                    showNotification('Image uploaded successfully!', 'is-success');
                    fetchProducts(); 
                } else {
                    showNotification('Failed to upload image.', 'is-danger');
                }
            })
            .catch(function () {
                showNotification('Error uploading image.', 'is-danger');
            });
        });

        document.body.appendChild(fileInput);
        fileInput.click();
        fileInput.addEventListener('blur', function () {
            document.body.removeChild(fileInput);
        });
    }

    // Service Management Functions
    function fetchServices() {

        const $tbody = $('#servicesTableBody');
        $tbody.empty();
        axios.get('./controller/fetchServices.php')
            .then(function (response) {
                const services = response.data;
                const $tbody = $('#servicesTableBody');
                $tbody.empty();

                if (services.length > 0) {
                    services.forEach(service => {
                        const $row = $('<tr></tr>');
                        $row.append(`<td>${escapeHtml(service.service_name)}</td>`);
                        $row.append(`<td>${escapeHtml(service.description)}</td>`);

                        const $actions = $('<td></td>');

                        const $editBtn = $('<button class="button is-small is-info">Edit</button>');
                        $editBtn.on('click', () => openServiceModal(true, service));

                        const $deleteBtn = $('<button class="button is-small is-danger">Delete</button>');
                        $deleteBtn.on('click', () => deleteService(service.s_id));

                        $actions.append($editBtn, ' ', $deleteBtn);
                        $row.append($actions);
                        $tbody.append($row);
                    });
                } else {
                    $tbody.html('<tr><td colspan="3">No services found.</td></tr>');
                }
            })
            .catch(() => {
                $('#servicesTableBody').html('<tr><td colspan="3">Error fetching data.</td></tr>');
            });
    }

    function openServiceModal(isEdit = false, service = null) {
        $('#serviceModalTitle').text(isEdit ? 'Edit Service' : 'Add Service');
        $('#serviceNameInput').val(isEdit ? service.service_name : '');
        $('#serviceDescInput').val(isEdit ? service.description : '');
        $('#serviceIdInput').val(isEdit ? service.s_id : '');
        $('#serviceModal').addClass('is-active');
    }

    function closeServiceModal() {
        document.getElementById('serviceForm').reset();
        $('#serviceIdInput').val('');
        $('#serviceModal').removeClass('is-active');
    }

    function submitServiceForm() {
        const serviceName = $('#serviceNameInput').val().trim();
        const serviceDesc = $('#serviceDescInput').val().trim();
        const serviceId = $('#serviceIdInput').val();
        
        if (!serviceName) return alert('Service name is required.');
        if (!serviceDesc) return alert('Service description is required.');

        const url = serviceId ? './controller/updateService.php' : './controller/addService.php';
        axios.post(url, {
            service_name: serviceName,
            service_description: serviceDesc,
            service_id: serviceId
        })
            .then(() => {
                showNotification(serviceId ? 'Service updated successfully!' : 'Service added successfully!', 'is-success');
                closeServiceModal();
                fetchServices();
            })
            .catch(() => {
                showNotification("Error saving service.", 'is-danger');
            });
    }

    function deleteService(serviceId) {
        if (!confirm("Are you sure you want to delete this service?")) return;

        axios.post('./controller/deleteService.php', {
            service_id: serviceId
        })
        .then(response => {
            const data = response.data;
            if (data.success) {
                showNotification(data.message, 'is-success');
                fetchServices();
            } else {
                showNotification(data.message, 'is-danger');
            }
        })
        .catch(() => {
            showNotification("Error deleting service.", 'is-danger');
        });
    }
</script>
<?php include_once('./includes/footer.php'); ?>