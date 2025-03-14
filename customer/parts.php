<?php
include_once './includes/header.php';
?>
<style>
    .content {
        width: 1900px;
        height: 100vh;
    }

    .sidebar {
        background-color: #6A8DAF;
        width: 250px;
        height: 450px;
        padding: 20px;
    }

    .menu-label {
        font-weight: bold;
    }

    .menu-list a {
        color: white;
    }

    .menu-list a:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .columns {
        margin-top: 70px;
    }

    .content {
        margin: 0;
    }

    .list-item a {
        background-color: transparent !important;
    }

    .list-item a:hover {
        background-color: #212429 !important;
    }

    .list-item {
        list-style-type: none;
    }

    .product-container {
        max-height: 700;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 20px;
        border-radius: 10px;
        white-space: normal;
        display: flex;
        justify-content: center;
        margin-top: -100px;
    }

    .product-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        max-width: 900px;
    }

    .product-item {
        background-color: white;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
        width: 250px;
    }

    .product-item:hover {
        transform: scale(1.05);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .product-image {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    }
</style>

<div class="columns is-centered">
    <!-- Sidebar -->
    <div class="column is-2 sidebar has-text-white">
        <p class="title is-5 has-text-white">Category</p>
        <aside class="menu" id="categoryMenu">
            <!-- Categories will be dynamically added here -->
        </aside>
    </div>

    <!-- Main Content -->
    <div class="column is-10">
        <div class="box has-background-primary product-container">
            <div class="columns is-multiline is-mobile" id="productContainer">
                <!-- Products will be dynamically added here -->
            </div>
        </div>
    </div>
</div>
<script>
    function toggleDropdown(id) {
        let dropdown = document.getElementById(id);
        dropdown.classList.toggle("is-hidden");
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function fetchData() {
            $.ajax({
                url: "./controllers/fetchProducts.php",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    let categoryMenu = "";
                    if (response.categories.length > 0) {
                        response.categories.forEach(category => {
                            let categoryId = category.toLowerCase().replace(/\s+/g, '-') + "-dropdown";
                            categoryMenu += `
                                <p class="menu-label has-text-white">
                                    <a class="has-text-white">${category} </a>
                                </p>
                                <ul id="${categoryId}" class="menu-list is-hidden">
                                    <li class="list-item"><a href="#">Option 1</a></li>
                                    <li class="list-item"><a href="#">Option 2</a></li>
                                </ul>
                            `;
                        });
                    } else {
                        categoryMenu = "<p class='menu-label has-text-white'>No Categories Found</p>";
                    }
                    $("#categoryMenu").html(categoryMenu);

                    let productContainer = "";
                    if (response.products.length > 0) {
                        response.products.forEach(product => {
                            productContainer += `
                                <div class="column is-one-third">
                                    <div class="box product-item">
                                        <img src="../admin_panel/${product.image}" alt="Product" class="product-image">
                                        <p class="has-text-weight-bold">${product.product_name}</p>
                                        <p class="has-text-weight-bold">${product.product_desc}</p>
                                        <p class="has-text-weight-bold">Available Stocks: ${product.stock}</p>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        productContainer = "<p class='has-text-white'>No Products Available</p>";
                    }
                    $("#productContainer").html(productContainer);
                },
                error: function () {
                    $("#categoryMenu").html("<p class='menu-label has-text-white'>Error fetching categories.</p>");
                    $("#productContainer").html("<p class='has-text-white'>Error fetching products.</p>");
                }
            });
        }

        fetchData(); 
    });

    function toggleDropdown(id) {
        $("#" + id).toggleClass("is-hidden");
    }
</script>

<?php
include_once './includes/footer.php';
?>