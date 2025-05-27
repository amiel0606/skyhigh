<?php include_once('./includes/header.php'); ?>
<?php include './includes/notification.php'; ?>
<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: ./login.php');
    exit();
}
?>
<style>
    .custom-table {
        margin: 0 auto;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    .custom-table thead th {
        background-color: #e26600 !important;
        color: white !important;
        font-weight: bold;
        text-align: center;
    }
    .custom-table tbody tr:nth-child(even) {
        background-color: #f5f5f5 !important;
    }
    .custom-table tbody tr:nth-child(odd) {
        background-color: #ffffff !important;
    }
    .custom-table tbody tr:hover {
        background-color: #e8f4fd !important;
    }
    .custom-table td {
        vertical-align: middle;
        padding: 12px 15px;
    }
</style>

<section class="section">
    <div class="container">
        <h2 class="title has-text-centered has-text-primary" style="color: #e26600 !important; margin-bottom: 2rem;">Customers</h2>
        <div class="columns is-centered">
            <div class="column is-10">
                <table class="table is-fullwidth is-striped is-hoverable custom-table" id="usersTable">
                    <thead>
                        <tr>
                            <th class="has-text-centered">User ID</th>
                            <th class="has-text-centered">Name</th>
                            <th class="has-text-centered">Address</th>
                            <th class="has-text-centered">Email</th>
                            <th class="has-text-centered">Contact Number</th>
                            <th class="has-text-centered" style="min-width: 160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Edit User Modal -->
<div class="modal" id="editUserModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Edit User</p>
            <button class="delete" aria-label="close" onclick="closeEditModal()"></button>
        </header>
        <section class="modal-card-body">
            <form id="editUserForm">
                <input type="hidden" id="editUserId" name="userId">
                <div class="field">
                    <label class="label">Name</label>
                    <div class="control">
                        <input class="input" type="text" id="editName" name="name" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Address</label>
                    <div class="control">
                        <input class="input" type="text" id="editAddress" name="address">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Username</label>
                    <div class="control">
                        <input class="input" type="text" id="editUsername" name="username" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Contact Number</label>
                    <div class="control">
                        <input class="input" type="text" id="editContact" name="contact">
                    </div>
                </div>
            </form>
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success" onclick="updateUser()">Save changes</button>
            <button class="button" onclick="closeEditModal()">Cancel</button>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
});

function loadUsers() {
    axios.get('./controller/getUsers.php')
        .then(function(response) {
            if (response.data.status === 'success') {
                const users = response.data.users;
                const tbody = document.querySelector('#usersTable tbody');
                tbody.innerHTML = '';
                users.forEach(function(user, idx) {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="has-text-centered">${user.uID || ''}</td>
                        <td>${user.name || ''}</td>
                        <td>${user.address || ''}</td>
                        <td>${user.username || ''}</td>
                        <td>${user.contact || ''}</td>
                        <td>
                            <button class="button is-small is-warning" onclick="editUser('${user.uID}', '${user.name}', '${user.address}', '${user.username}', '${user.contact}')">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                            <button class="button is-small is-info" onclick="resetPassword('${user.uID}', '${user.name}', '${user.username}')" title="Reset Password">
                                <i class="fa-solid fa-key"></i>
                            </button>
                            <button class="button is-small is-danger" onclick="deleteUser('${user.uID}', '${user.name}')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                const tbody = document.querySelector('#usersTable tbody');
                tbody.innerHTML = '<tr><td colspan="6" class="has-text-centered">No users found.</td></tr>';
            }
        })
        .catch(function(error) {
            const tbody = document.querySelector('#usersTable tbody');
            tbody.innerHTML = '<tr><td colspan="6" class="has-text-centered">Error loading users.</td></tr>';
            console.error(error);
        });
}

function editUser(userId, name, address, username, contact) {
    document.getElementById('editUserId').value = userId;
    document.getElementById('editName').value = name || '';
    document.getElementById('editAddress').value = address || '';
    document.getElementById('editUsername').value = username || '';
    document.getElementById('editContact').value = contact || '';
    
    document.getElementById('editUserModal').classList.add('is-active');
}

function closeEditModal() {
    document.getElementById('editUserModal').classList.remove('is-active');
}

function updateUser() {
    const formData = new FormData(document.getElementById('editUserForm'));
    
    axios.post('./controller/updateUser.php', formData)
        .then(function(response) {
            if (response.data.status === 'success') {
                showNotification('success', 'User updated successfully!');
                loadUsers(); 
            } else {
                showNotification('error', 'Error: ' + response.data.message);
            }
        })
        .catch(function(error) {
            alert('Error updating user');
            console.error(error);
        });
}

function deleteUser(userId, userName) {
    if (confirm(`Are you sure you want to delete user "${userName}"?`)) {
        const formData = new FormData();
        formData.append('userId', userId);
        
        axios.post('./controller/deleteUser.php', formData)
            .then(function(response) {
                if (response.data.status === 'success') {
                    alert('User deleted successfully!');
                    loadUsers(); 
                } else {
                    alert('Error: ' + response.data.message);
                }
            })
            .catch(function(error) {
                alert('Error deleting user');
                console.error(error);
            });
    }
}

function resetPassword(userId, userName, userEmail) {
    if (confirm(`Are you sure you want to reset password for user "${userName}"?\nA new password will be sent to: ${userEmail}`)) {
        const formData = new FormData();
        formData.append('userId', userId);
        
        const resetButtons = document.querySelectorAll(`button[onclick*="resetPassword('${userId}"]`);
        resetButtons.forEach(btn => {
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
        });
        
        axios.post('./controller/resetPassword.php', formData)
            .then(function(response) {
                if (response.data.status === 'success') {
                    alert('Password reset successfully! New password has been sent to the user\'s email.');
                } else if (response.data.status === 'warning') {
                    alert(response.data.message);
                } else {
                    alert('Error: ' + response.data.message);
                }
            })
            .catch(function(error) {
                alert('Error resetting password');
                console.error(error);
            })
            .finally(function() {
                resetButtons.forEach(btn => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-key"></i>';
                });
            });
    }
}
</script>
<?php include_once('./includes/footer.php'); ?>