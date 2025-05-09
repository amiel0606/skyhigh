<?php include_once('./includes/header.php'); ?>
<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: ./login.php');
    exit();
}
?>
<section class="section">
    <div class="container is-fluid">
        <div class="columns is-centered is-gapless is-fullheight">
            <div class="column is-3 user-list">
                <h3 class="title is-6 has-text-white m-3">Users</h3>
                <div class="menu">
                    <ul class="menu-list" id="userList">
                        <!-- User list will be populated dynamically -->
                    </ul>
                </div>
            </div>

            <div class="column is-7 box chat-container">
                <h3 class="title is-5 has-text-black m-3" id="selectedUser">Select a user to chat</h3>
                <div class="chat-messages" id="chatMessages">
                    <!-- Messages will be populated dynamically -->
                </div>
                <div class="field has-addons mt-4" id="messageInputContainer" style="display: none;">
                    <div class="control is-expanded">
                        <input class="input" type="text" id="messageInput" placeholder="Type a message...">
                    </div>
                    <!-- Trigger button -->
                    <button id="imageButton" type="button" class="button is-primary">Send Image</button>

                    <!-- Hidden file input -->
                    <div class="control" style="display: none;">
                        <input type="file" id="imageInput" accept="image/*">
                    </div>
                    <div class="control">
                        <button class="button is-primary" id="sendButton">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .is-fullheight {
        height: 90vh;
    }

    .user-list {
        height: 600px;
        overflow-y: auto;
        padding: 10px;
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 5px;
        margin-right: 10px;
    }

    .menu-item {
        background-color: transparent !important;
        transition: background-color 0.3s ease;
    }

    .menu-item:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
    }

    .chat-container {
        height: 600px;
        display: flex;
        flex-direction: column;
        padding: 10px;
    }

    .chat-messages {
        flex-grow: 1;
        overflow-y: auto;
        background: white;
        padding: 10px;
        border-radius: 5px;
        height: 600px;
    }

    .message-container {
        display: flex;
        margin: 10px 0;
    }

    .contact-message {
        background-color: #333;
        color: white;
        padding: 10px 15px;
        border-radius: 20px;
        max-width: 80%;
        align-self: flex-start;
    }

    .my-message {
        color: white;
        padding: 10px 15px;
        border-radius: 20px;
        max-width: 80%;
        margin-left: auto;
    }

    .container.is-fluid {
        max-width: 100px;
        width: 100%;
        padding: 0 20px;
        margin-left: 100px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');
        const chatMessages = document.getElementById('chatMessages');
        const userList = document.getElementById('userList');
        const selectedUserTitle = document.getElementById('selectedUser');
        const messageInputContainer = document.getElementById('messageInputContainer');
        const imageButton = document.getElementById('imageButton');
        const imageInput = document.getElementById('imageInput');

        if (!imageButton || !imageInput) {
            console.error('Missing #imageButton or #imageInput in the DOM.');
            return;
        }

        imageButton.addEventListener('click', () => {
            imageInput.click();
        });

        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('user_id', selectedUserId); // Replace with actual user ID
            formData.append('image', file);

            axios.post('./controller/adminMessaging.php', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
                .then(response => {
                    if (response.data.status === 'success') {
                        const chatMessages = document.querySelector('.chat-messages');
                        const messageContainer = document.createElement('div');
                        messageContainer.className = 'message-container';
                        messageContainer.innerHTML = `
                    <p class="my-message has-background-primary">
                        <strong>You:</strong><br>
                        <img src="${response.data.imageUrl}" style="max-width: 200px; border-radius: 10px;">
                        <br><small class="has-text-grey-lighter">${formatTimestamp(new Date())}</small>
                    </p>`;
                        chatMessages.appendChild(messageContainer);
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                        showNotification('Image sent successfully', 'success');
                    } else {
                        showNotification(response.data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error(error);
                    showNotification('Failed to send image.', 'error');
                });

            this.value = ''; // reset file input
        });

        let selectedUserId = null;

        function fetchUsers() {
            axios.get('./controller/getUsers.php')
                .then(function (response) {
                    if (response.data.status === 'success') {
                        userList.innerHTML = '';

                        response.data.users.forEach(function (user) {
                            const li = document.createElement('li');
                            li.className = 'menu-item mb-2';
                            li.innerHTML = `<a class="has-text-white user-item" data-user-id="${user.uID}">${user.name}</a>`;

                            li.querySelector('.user-item').addEventListener('click', function () {
                                selectedUserId = this.getAttribute('data-user-id');
                                selectedUserTitle.textContent = this.textContent;

                                messageInputContainer.style.display = 'flex';

                                document.querySelectorAll('.user-item').forEach(item => {
                                    item.classList.remove('has-background-white');
                                });
                                this.classList.add('has-background-white');
                                this.classList.add('has-text-black');
                                fetchMessages(selectedUserId);
                            });

                            userList.appendChild(li);
                        });
                    }
                })
                .catch(function (error) {
                    console.error('Error fetching users:', error);
                });
        }

        function fetchMessages(userId) {
            if (!userId) return;

            axios.get(`./controller/getAdminMessages.php?user_id=${userId}`)
                .then(function (response) {
                    if (response.data.status === 'success') {
                        chatMessages.innerHTML = '';

                        response.data.messages.forEach(function (msg) {
                            const messageContainer = document.createElement('div');
                            messageContainer.className = 'message-container';
                            messageContainer.setAttribute('data-message-id', msg.msg_id);

                            const isImage = msg.type === 'image';
                            const messageContent = isImage
                                ? `<img src="${msg.message}" style="max-width: 200px; border-radius: 10px;">`
                                : msg.message;

                            if (msg.isFromAdmin) {
                                messageContainer.innerHTML = `
                                <p class="my-message is-primary">
                                    <strong class="has-text-white">Admin:</strong> ${messageContent}
                                    <small class="has-text-grey-lighter">${formatTimestamp(msg.timestamp)}</small>
                                </p>`;
                            } else {
                                messageContainer.innerHTML = `
                                <p class="contact-message">
                                    <strong class="has-text-white">User:</strong> ${messageContent}
                                    <small class="has-text-grey">${formatTimestamp(msg.timestamp)}</small>
                                </p>`;
                            }

                            chatMessages.appendChild(messageContainer);
                        });

                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }
                })
                .catch(function (error) {
                    console.error('Error fetching messages:', error);
                });
        }

        function sendMessage() {
            if (!selectedUserId) {
                showNotification('Please select a user first', 'error');
                return;
            }

            const message = messageInput.value.trim();
            const imageFile = document.getElementById('imageInput').files[0];
            if (message === '' && !imageFile) return;

            const formData = new FormData();
            formData.append('user_id', selectedUserId);
            if (message) formData.append('message', message);
            if (imageFile) formData.append('image', imageFile);

            axios.post('./controller/adminMessaging.php', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(function (response) {
                    if (response.data.status === 'error') {
                        showNotification(response.data.message, 'error');
                    } else {
                        showNotification('Message sent successfully', 'success');
                        messageInput.value = '';
                        document.getElementById('imageInput').value = '';
                        fetchMessages(selectedUserId); // Refresh after send
                    }
                })
                .catch(function (error) {
                    console.error('Error:', error);
                    showNotification('Failed to send message. Please try again.', 'error');
                });
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification is-${type === 'error' ? 'danger' : 'success'} is-light`;
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.zIndex = '1000';

            notification.innerHTML = `
                <button class="delete"></button>
                ${message}
            `;

            document.body.appendChild(notification);

            const deleteButton = notification.querySelector('.delete');
            deleteButton.addEventListener('click', function () {
                notification.remove();
            });

            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }

        function formatTimestamp(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }

        sendButton.addEventListener('click', sendMessage);

        messageInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        fetchUsers();

        // setInterval(function () {
        //     if (selectedUserId) {
        //         fetchMessages(selectedUserId);
        //     }
        // }, 5000);

        const urlParams = new URLSearchParams(window.location.search);
        const preselectUserId = urlParams.get('user_id');
        if (preselectUserId) {
            // Wait for users to load, then select
            const interval = setInterval(() => {
                const userItem = document.querySelector(`.user-item[data-user-id="${preselectUserId}"]`);
                if (userItem) {
                    userItem.click();
                    clearInterval(interval);
                }
            }, 100);
        }
    });
</script>

<?php include_once('./includes/footer.php'); ?>