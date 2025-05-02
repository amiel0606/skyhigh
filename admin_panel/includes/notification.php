<!-- Notification Component -->
<style>
#notification-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    transition: all 0.3s ease;
}
#notification-icon {
    position: relative;
    width: 60px;
    height: 60px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}
#notification-badge {
    position: absolute;
    top: 2px;
    right: 2px;
    background: #e74c3c;
    color: #fff;
    border-radius: 50%;
    padding: 2px 7px;
    font-size: 12px;
    font-weight: bold;
}
#notification-panel {
    display: none;
    position: absolute;
    top: 50px;
    right: 0;
    width: 250px;
    max-height: 300px;
    overflow-y: auto;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    padding: 15px;
}
#notification-container.active #notification-panel {
    display: block;
}
</style>

<div id="notification-container">
    <div id="notification-icon">
        <!-- Bell SVG Icon -->
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
        <span id="notification-badge">3</span>
    </div>
    <div id="notification-panel">
        <strong>Notifications</strong>
        <ul style="margin:10px 0 0 0; padding:0; list-style:none;"></ul>
    </div>
</div>

<script>
const container = document.getElementById('notification-container');
const icon = document.getElementById('notification-icon');
const panel = document.getElementById('notification-panel');
const notificationList = panel.querySelector('ul');
const badge = document.getElementById('notification-badge');

const positions = [
    {top: '20px', right: '20px', bottom: '', left: ''}, // top-right
    {top: '20px', left: '20px', bottom: '', right: ''}, // top-left
    {bottom: '20px', right: '20px', top: '', left: ''}, // bottom-right
    {bottom: '20px', left: '20px', top: '', right: ''}  // bottom-left
];
let currentPosition = 0;

icon.addEventListener('click', function(e) {
    container.classList.toggle('active');
});

document.addEventListener('click', function(e) {
    if (!container.contains(e.target)) {
        container.classList.remove('active');
    }
});

function fetchNotifications() {
    fetch('./controller/getUnreadNotifications.php')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                badge.textContent = data.count;
                notificationList.innerHTML = '';
                if (data.notifications.length === 0) {
                    notificationList.innerHTML = '<li style="padding:10px;">No new notifications.</li>';
                } else {
                    data.notifications.forEach(n => {
                        const li = document.createElement('li');
                        li.style = "background: #f5f5f5; padding: 10px; margin-bottom: 8px; border-radius: 6px; cursor: pointer; transition: background 0.2s";
                        li.textContent = `${n.name}: ${n.message}`;
                        li.onclick = function() {
                            fetch('./controller/markNotificationsSeen.php', {
                                method: 'POST',
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                body: `user_id=${n.sender}`
                            }).then(() => {
                                window.location.href = `message.php?user_id=${n.sender}`;
                            });
                        };
                        notificationList.appendChild(li);
                    });
                }
            }
        });
}

// Fetch notifications on load and every 10 seconds
fetchNotifications();
setInterval(fetchNotifications, 3000);
</script> 