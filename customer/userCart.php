<?php
include_once("./includes/header.php");
?>
<style>
    .cart-container {
        padding: 15px;
        border-radius: 10px;
        max-height: 500px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #ccc rgba(30, 40, 60, 0.9);
    }

    .cart-container::-webkit-scrollbar {
        width: 8px;
    }

    .cart-container::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 4px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .cart-img-box {
        background-color: rgba(255, 255, 255, 0.1);
        padding: 5px;
        border-radius: 5px;
    }

    .cart-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 5px;
    }

    .cart-info {
        flex-grow: 1;
        padding: 0 10px;
        color: white;
    }

    .cart-price {
        font-weight: bold;
        color: #ffcc00;
    }

    .cart-qty {
        display: flex;
        align-items: center;
    }

    .qty-btn {
        background-color: #ffcc00;
        color: black;
        border: none;
        padding: 3px 8px;
        margin: 0 5px;
        cursor: pointer;
        border-radius: 3px;
    }

    .delete-btn {
        background-color: red;
        color: white;
        border: none;
        padding: 5px;
        cursor: pointer;
        border-radius: 3px;
    }
</style>
<div class="cart-container has-background-primary p-4">
    <h2 class="has-text-white">Your Cart</h2>
    <div class="table-container" style="max-height: 500px; overflow-y: auto;">
        <table class="table is-fullwidth is-striped is-hoverable has-text-white">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="cartItems">
                <!-- Cart items will be injected here -->
            </tbody>
        </table>
    </div>
    <p class="has-text-white">Total: <span id="totalPrice" class="has-text-weight-bold">P 0</span></p>
    <button class="button is-warning is-fullwidth mt-3" id="finishOrderBtn">Finish Order</button>
</div>
<script src="./js/changeWindows.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function fetchCartItems() {
        axios.get('./controllers/fetchCart.php')
            .then(response => {
                if (response.data.success) {
                    let cartItemsContainer = document.getElementById("cartItems");
                    let totalPrice = document.getElementById("totalPrice");
                    cartItemsContainer.innerHTML = "";

                    if (response.data.cartItems.length === 0) {
                        cartItemsContainer.innerHTML = `
                        <tr>
                            <td colspan="5" class="has-text-centered">No items in the cart yet.</td>
                        </tr>
                    `;
                        totalPrice.innerText = "P 0";
                        return;
                    }

                    response.data.cartItems.forEach(item => {
                        // Check if quantity is less than stock
                        const canIncrease = parseInt(item.quantity) < parseInt(item.stock);
                        
                        cartItemsContainer.innerHTML += `
                        <tr>
                            <td>
                                <div class="is-flex is-align-items-center">
                                    <figure class="image is-64x64 has-background-white p-1">
                                        <img src="../admin_panel/uploads/${item.product_image}" class="cart-img" alt="Product">
                                    </figure>
                                    <span class="ml-2">${item.product_name}</span>
                                </div>
                            </td>
                            <td>P ${item.price}</td>
                            <td>
                                <div class="buttons has-addons">
                                    <button class="button is-small is-warning decrease" data-id="${item.product_id}">-</button>
                                    <span class="px-2 quantity" data-id="${item.product_id}" data-stock="${item.stock}">${item.quantity}</span>
                                    <button class="button is-small is-warning increase" data-id="${item.product_id}" ${!canIncrease ? 'disabled' : ''}>+</button>
                                </div>
                                ${!canIncrease ? '<small class="has-text-danger">Stock limit reached</small>' : ''}
                            </td>
                            <td>P ${item.total_price}</td>
                            <td>
                                <button class="button is-small is-danger delete-btn" data-id="${item.product_id}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    });

                    totalPrice.innerText = `P ${response.data.totalPrice}`;

                    addCartEventListeners();
                }
            })
            .catch(error => {
                console.error("Error fetching cart:", error);
            });
    }

    function addCartEventListeners() {
        document.querySelectorAll(".increase").forEach(button => {
            button.addEventListener("click", () => {
                let productId = button.dataset.id;
                let quantityElement = document.querySelector(`.quantity[data-id="${productId}"]`);
                let currentQuantity = parseInt(quantityElement.innerText);
                let maxStock = parseInt(quantityElement.dataset.stock);

                if (currentQuantity < maxStock) {
                    updateCart(productId, "increase");
                } else {
                    alert("Cannot increase quantity. Stock limit reached!");
                }
            });
        });

        document.querySelectorAll(".decrease").forEach(button => {
            button.addEventListener("click", () => {
                updateCart(button.dataset.id, "decrease");
            });
        });

        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", () => {
                deleteCartItem(button.dataset.id);
            });
        });
    }

    function updateCart(productId, action) {
        axios.post('./controllers/updateCart.php', {
            product_id: productId,
            action: action
        })
            .then(response => {
                if (response.data.success) {
                    fetchCartItems();
                } else {
                    console.error("Update failed:", response.data.message);
                    alert(response.data.message || "Failed to update cart.");
                }
            })
            .catch(error => {
                console.error("Error updating cart:", error);
                alert("Error updating cart. Please try again.");
            });
    }

    function deleteCartItem(productId) {
        axios.post('./controllers/updateCart.php', {
            product_id: productId,
            action: "delete"
        })
            .then(response => {
                if (response.data.success) {
                    fetchCartItems();
                } else {
                    console.error("Delete failed:", response.data.message);
                    alert(response.data.message || "Failed to delete item.");
                }
            })
            .catch(error => {
                console.error("Error deleting cart item:", error);
                alert("Error deleting item. Please try again.");
            });
    }

    document.getElementById("finishOrderBtn").addEventListener("click", function () {
        axios.post("./controllers/createPayment.php")
            .then(response => {
                if (response.data.success) {
                    window.location.href = response.data.redirect_url; // Redirect to payment page
                } else {
                    alert("Payment initialization failed.");
                }
            })
            .catch(error => console.error("Error:", error));
    });

    fetchCartItems();
</script>

<?php
include_once("./includes/footer.php");
?>