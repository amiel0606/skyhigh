<?php
include_once './includes/header.php';
?>
<style>
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
        width: 1700px;
        height: 100vh !important;
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
        height: calc(100vh - 100px);
        /* Adjust if header size is different */
        overflow-y: auto;
        overflow-x: hidden;
        padding: 20px;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    #productContainer {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        width: 100%;
        max-width: 1000px;
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
        height: 380px;
        /* fixed height for uniformity */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-item:hover {
        transform: scale(1.05);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .product-image {
        width: 100%;
        height: 150px;
        /* fixed height */
        object-fit: cover;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .product-item p {
        margin-bottom: 8px;
        font-size: 14px;
    }
</style>

<div class="columns is-centered">
    <!-- Sidebar -->
    <div class="column is-2 sidebar has-text-white">
        <p class="title is-5 has-text-white">Brand</p>
        <aside class="menu" id="brandMenu">
            <!-- Brands will be dynamically added here -->
        </aside>
    </div>

    <!-- Main Content -->
    <div class="column is-10">
        <div class="box has-background-primary product-container">
            <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
                <label for="priceSort" style="color: white; margin-right: 10px;">Sort by Price:</label>
                <select id="priceSort" style="width: 150px;">
                    <option value="">Default</option>
                    <option value="asc">Low to High</option>
                    <option value="desc">High to Low</option>
                </select>
            </div>
            <div class="columns is-multiline is-mobile" id="productContainer">
                <!-- Products will be dynamically added here -->
            </div>
        </div>
    </div>
</div>
<script src="./js/changeWindows.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function toggleDropdown(id) {
        let dropdown = document.getElementById(id);
        dropdown.classList.toggle("is-hidden");
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('body').append('<div id="notification-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>');
        
        let selectedBrand = '';
        let selectedSort = '';

        function showNotification(notification) {
            const { type, title, message } = notification;
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
                <div id="${notificationId}" class="${notificationClass}">
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
            
            $('#notification-container').append(notificationHtml);
            
            $(`#${notificationId} .delete`).on('click', function() {
                $(`#${notificationId}`).fadeOut(300, function() {
                    $(this).remove();
                });
            });
            
            setTimeout(function() {
                $(`#${notificationId}`).fadeOut(300, function() {
                    $(this).remove();
                });
            }, 5000);
        }
        
        function fetchData(brand = '', sort = '') {
            let url = './controllers/fetchProductsByCategory.php';
            let params = [];
            if (brand) params.push('brand=' + encodeURIComponent(brand));
            if (sort) params.push('sort=' + encodeURIComponent(sort));
            if (params.length > 0) url += '?' + params.join('&');

            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    let brandMenu = "";
                    // Add "All Brands" option
                    brandMenu += `
                        <p class="menu-label has-text-white">
                            <a class="has-text-white brand-link" data-brand="">All Brands</a>
                        </p>
                    `;
                    if (response.brands.length > 0) {
                        response.brands.forEach(brand => {
                            if (brand.count > 0) {
                                let brandId = brand.name ? brand.name.toLowerCase().replace(/\s+/g, '-') : '';
                                brandMenu += `
                                    <p class="menu-label has-text-white">
                                        <a class="has-text-white brand-link" data-brand="${brand.name}">${brand.name} (${brand.count})</a>
                                    </p>
                                `;
                            }
                        });
                    } else {
                        brandMenu += "<p class='menu-label has-text-white'>No Brands Found</p>";
                    }
                    $("#brandMenu").html(brandMenu);

                    let productContainer = "";
                    if (response.products.length > 0) {
                        response.products.forEach(product => {
                            productContainer += `
                            <div class="column is-one-third">
                                <div class="box product-item">
                                    <img src="../admin_panel/${product.image}" alt="Product" class="product-image">
                                    <p class="has-text-weight-bold">${product.product_name}</p>
                                    <p class="has-text-weight-bold">${product.product_desc}</p>
                                    <p class="has-text-weight-bold">Brand: ${product.brand || ''}</p>
                                    <p class="has-text-weight-bold">Price: ₱${product.price}</p>
                                    <p class="has-text-weight-bold">Available Stocks: ${product.stock}</p>
                                    <button class="button is-primary add-to-cart-btn" data-id="${product.product_id}" data-name="${product.product_name}" data-price="${product.price}">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        `;
                        });
                    } else {
                        productContainer = "<p class='has-text-white'>No Products Available</p>";
                    }
                    $("#productContainer").html(productContainer);
                    // Highlight the selected brand
                    if (brand) {
                        $(`.brand-link[data-brand="${brand}"]`).addClass("has-background-primary");
                    } else {
                        $(".brand-link[data-brand='']").addClass("has-background-primary");
                    }
                },
                error: function () {
                    $("#brandMenu").html("<p class='menu-label has-text-white'>Error fetching brands.</p>");
                    $("#productContainer").html("<p class='has-text-white'>Error fetching products.</p>");
                }
            });
        }

        // Initial load
        fetchData();

        // Handle brand click
        $(document).on("click", ".brand-link", function() {
            selectedBrand = $(this).data("brand");
            // Highlight selected brand
            $(".brand-link").removeClass("has-background-primary");
            $(this).addClass("has-background-primary");
            fetchData(selectedBrand, selectedSort);
        });

        // Handle price sort change
        $(document).on("change", "#priceSort", function() {
            selectedSort = $(this).val();
            fetchData(selectedBrand, selectedSort);
        });

        // Handle add to cart
        $(document).on("click", ".add-to-cart-btn", function () {
            let productId = $(this).data("id");
            let productName = $(this).data("name");
            let productPrice = $(this).data("price");

            axios.post("./controllers/addToCart.php", {
                product_id: productId,
                product_name: productName,
                product_price: productPrice,
                quantity: 1
            })
                .then(response => {
                    if (response.data.success) {
                        // Show success notification
                        if (response.data.notification) {
                            showNotification(response.data.notification);
                        }
                    } else {
                        // Check if login is required
                        if (response.data.requireLogin) {
                            // Show login modal
                            var login = document.getElementById('loginModal');
                            if (login) {
                                login.classList.add('is-active');
                            } else {
                                // If login modal doesn't exist, redirect to login page
                                window.location.href = './login.php';
                            }
                        }
                        
                        // Show error notification
                        if (response.data.notification) {
                            showNotification(response.data.notification);
                        }
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    showNotification({
                        type: 'error',
                        title: 'Error',
                        message: 'Failed to add to cart. Please try again.'
                    });
                });
        });
    });
</script>

<?php
include_once './includes/footer.php';
?>