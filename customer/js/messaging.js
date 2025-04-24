document.addEventListener('DOMContentLoaded', function() {
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    const chatMessages = document.querySelector('.chat-messages');
    
    function sendMessage() {
        const message = messageInput.value.trim();
        if (message === '') return;
        
        const messageContainer = document.createElement('div');
        messageContainer.className = 'message-container';
        messageContainer.innerHTML = `<p class="my-message has-background-primary"><strong>You:</strong> ${message}</p>`;
        chatMessages.appendChild(messageContainer);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        messageInput.value = '';
        
        axios.post('./controllers/messaging.php', {
            message: message
        })
        .then(function(response) {
            if (response.data.status === 'error') {
                console.error('Error sending message:', response.data.message);
                showNotification(response.data.message, 'error');
            } else {
                showNotification('Message sent successfully', 'success');
            }
        })
        .catch(function(error) {
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
        
        const deleteButton = document.createElement('button');
        deleteButton.className = 'delete';
        deleteButton.addEventListener('click', function() {
            notification.remove();
        });
        
        notification.innerHTML = `
            <button class="delete"></button>
            ${message}
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }
    
    sendButton.addEventListener('click', sendMessage);
    
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
    
    messageInput.focus();
}); 