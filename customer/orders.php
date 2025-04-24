<?php
include_once("./includes/header.php");
?>
<style>
  .content {
    margin-left: 300px;
  }

  .hehe {
    overflow-y: auto;
  }
</style>
<div class="box hehe has-background-primary p-4 is-fullwidth" style="min-width: 1200px; max-height:700px ">
  <div id="ordersContainer" class="box has-background-white">
    <div class="container mt-4">
        <h2 class="has-text-black">My Orders</h2>
        
        <!-- Add status filter -->
        <div class="mb-4">
            <label for="statusFilter" class="form-label">Filter by Status:</label>
            <select class="form-select" id="statusFilter" style="max-width: 200px;">
                <option value="ALL">All Orders</option>
                <option value="PENDING">Pending</option>
                <option value="Ready For Pickup">Ready For Pickup</option>
                <option value="COMPLETED">Completed</option>
                <option value="Paid">Paid</option>
            </select>
        </div>

        <div id="ordersList">
            <!-- Orders will be loaded here -->
        </div>
    </div>
  </div>
</div>
<script src="./js/changeWindows.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
  // Initial load of orders
  document.addEventListener('DOMContentLoaded', () => {
    loadOrders();
  });

  // Add status filter change handler
  document.getElementById('statusFilter').addEventListener('change', function() {
    loadOrders(this.value);
  });

  function loadOrders(status = 'ALL') {
    fetch(`controllers/getOrders.php?status=${status}`)
      .then(response => response.json())
      .then(data => {
        const ordersList = document.getElementById('ordersList');
        if (!ordersList) {
          console.error('Element with ID "ordersList" not found');
          return;
        }
        
        ordersList.innerHTML = '';

        if (Object.keys(data).length === 0) {
          ordersList.innerHTML = '<div class="alert alert-info">No orders found.</div>';
          return;
        }

        Object.entries(data).forEach(([transactionId, items]) => {
          const orderCard = document.createElement('div');
          orderCard.className = 'card mb-3';
          
          const status = items[0].status;
          const statusClass = getStatusClass(status);
          const showButton = status === 'Ready for Pickup';
          
          orderCard.innerHTML = `
            <div class="card-header d-flex justify-content-between align-items-center">
              <span>Order #${transactionId}</span>
              <span class="badge ${statusClass}">${status}</span>
            </div>
            <div class="card-body">
              ${items.map(item => `
                <div class="d-flex align-items-center mb-3">
                  <img src="../admin_panel/uploads/${item.image}" alt="${item.name}" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                  <div>
                    <h6 class="mb-0">${item.name}</h6>
                    <small class="text-muted has-text-white">Quantity: ${item.quantity}</small>
                    <p class="text-danger mb-0">₱${item.original_price}</p>
                  </div>
                </div>
              `).join('')}
            </div>
            ${showButton ? `
            <div class="card-footer text-end">
              <button class="btn btn-success mark-received" data-transid="${transactionId}">Order Received</button>
            </div>
            ` : ''}
          `;
          
          ordersList.appendChild(orderCard);
        });

        // Add event listeners to the Order Received buttons
        document.querySelectorAll('.mark-received').forEach(button => {
          button.addEventListener('click', function() {
            const transID = this.getAttribute('data-transid');
            
            axios.post('./controllers/changeStatus.php', { transID })
              .then(response => {
                alert('Order marked as received!');
                loadOrders(); // Reload the orders
              })
              .catch(error => {
                console.error(error);
                alert('Failed to update order status.');
              });
          });
        });
      })
      .catch(error => {
        console.error('Error:', error);
        const ordersList = document.getElementById('ordersList');
        if (ordersList) {
          ordersList.innerHTML = '<div class="alert alert-danger">Error loading orders.</div>';
        }
      });
  }

  function getStatusClass(status) {
    switch(status.toUpperCase()) {
      case 'PENDING':
        return 'bg-warning';
      case 'READY FOR PICKUP':
        return 'bg-info';
      case 'COMPLETED':
        return 'bg-success';
      case 'PAID':
        return 'bg-primary';
      default:
        return 'bg-secondary';
    }
  }
</script>

<?php
include_once("./includes/footer.php");
?>