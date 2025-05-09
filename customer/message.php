<?php
include_once './includes/header.php';
?>
<section class="section">
    <div class="container">
        <div class="columns is-gapless is-fullheight">
            <div class="column is-four-fifths box chat-container">
                <h3 class="title is-5 has-text-white m-3">Admin</h3>
                <div class="chat-messages">
                    <div class="message-container">
                        <p class="contact-message"><strong>User 1:</strong> Hello!</p>
                    </div>
                    <div class="message-container">
                        <p class="my-message has-background-primary"><strong>You:</strong> Hi, how are you?</p>
                    </div>
                    <div class="message-container">
                        <p class="contact-message"><strong>User 2:</strong> I'm good, what about you?</p>
                    </div>
                    <div class="message-container">
                        <p class="my-message has-background-primary"><strong>You:</strong> Just chilling.</p>
                    </div>
                    <div class="message-container">
                        <p class="contact-message"><strong>User 3:</strong> That's cool!</p>
                    </div>
                </div>
                <div class="field has-addons mt-4">
                    <div class="control is-expanded">
                        <input class="input" type="text" id="messageInput" placeholder="Type a message...">
                    </div>
                    <div class="control">
                        <input type="file" id="imageInput" accept="image/*" style="display: none;">
                        <button class="button is-info" id="imageButton">📷</button>
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
        width: 300px !important;
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 5px;
    }

    .menu-item:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
    }

    .chat-container {
        height: 600px;
        display: flex;
        flex-direction: column;
        padding: 10px;
        width: 1200px !important;
    }

    .chat-messages {
        flex-grow: 1;
        overflow-y: auto;
        background: white;
        padding: 10px;
        border-radius: 5px;
        height: 600px;
        display: flex;
        flex-direction: column;
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

    .container {
        max-width: 100px;
        margin-left: -300px;
        margin-top: -50px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');
        const chatMessages = document.querySelector('.chat-messages');

        function sendMessage() {
            const message = messageInput.value.trim();
            if (message === '') return;

            const messageContainer = document.createElement('div');
            messageContainer.className = 'message-container';
            messageContainer.innerHTML = `<p class="my-message has-background-primary"><strong>You:</strong> ${message} <small class="has-text-grey-lighter">${formatTimestamp(new Date())}</small></p>`;
            chatMessages.appendChild(messageContainer);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            messageInput.value = '';

            axios.post('./controllers/messaging.php', {
                message: message
            })
                .then(function (response) {
                    if (response.data.status === 'error') {
                        console.error('Error sending message:', response.data.message);
                        showNotification(response.data.message, 'error');
                    } else {
                        showNotification('Message sent successfully', 'success');
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

            notification.innerHTML = `                <button class="delete"></button>
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

        function scrollToBottom() {
            requestAnimationFrame(() => {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            });
        }

        function fetchNewMessages() {
            axios.get('./controllers/getMessages.php')
                .then(function (response) {
                    if (response.data.status === 'success') {
                        chatMessages.innerHTML = '';

                        let imagesToLoad = 0;
                        let imagesLoaded = 0;

                        response.data.messages.forEach(function (msg) {
                            const messageContainer = document.createElement('div');
                            messageContainer.className = 'message-container';
                            messageContainer.setAttribute('data-message-id', msg.msg_id);

                            const isImage = msg.type === 'image';
                            let messageContent = msg.message;

                            if (isImage) {
                                messageContent = `<img src="${msg.message}" style="max-width: 200px; border-radius: 10px;">`;
                                imagesToLoad++;
                            }

                            if (msg.isFromAdmin) {
                                messageContainer.innerHTML = `
                            <p class="contact-message">
                                <strong>Admin:</strong> ${messageContent}
                                <small class="has-text-grey">${formatTimestamp(msg.timestamp)}</small>
                            </p>`;
                            } else {
                                messageContainer.innerHTML = `
                            <p class="my-message has-background-primary">
                                <strong>You:</strong> ${messageContent}
                                <small class="has-text-grey-lighter">${formatTimestamp(msg.timestamp)}</small>
                            </p>`;
                            }

                            chatMessages.appendChild(messageContainer);
                        });

                        if (imagesToLoad === 0) {
                            scrollToBottom();
                        } else {
                            // Wait for all images to load before scrolling
                            const imgs = chatMessages.querySelectorAll('img');
                            imgs.forEach(img => {
                                img.onload = () => {
                                    imagesLoaded++;
                                    if (imagesLoaded === imagesToLoad) {
                                        scrollToBottom();
                                    }
                                };
                            });
                        }
                    }
                })
                .catch(function (error) {
                    console.error('Error fetching messages:', error);
                });
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

        messageInput.focus();

        fetchNewMessages();
        setInterval(fetchNewMessages, 5000);

        document.getElementById('imageButton').addEventListener('click', () => {
            document.getElementById('imageInput').click();
        });

        document.getElementById('imageInput').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('image', file);

            axios.post('./controllers/messaging.php', formData, {
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

    });
</script>
<script src="./js/changeWindows.js"></script>

<?php
include_once './includes/footer.php';
?>