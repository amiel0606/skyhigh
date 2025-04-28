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
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
        <span id="notification-badge">3</span>
    </div>
    <div id="notification-panel">
        <strong>Notifications</strong>
        <ul style="margin:10px 0 0 0; padding:0; list-style:none;">
            <li>You have a new message.</li>
            <li>Reminder: Meeting at 3PM.</li>
            <li>System update available.</li>
        </ul>
    </div>
</div>

<script>
const container = document.getElementById('notification-container');
const icon = document.getElementById('notification-icon');
const panel = document.getElementById('notification-panel');

const positions = [
    {top: '20px', right: '20px', bottom: '', left: ''}, // top-right
    {top: '20px', left: '20px', bottom: '', right: ''}, // top-left
    {bottom: '20px', right: '20px', top: '', left: ''}, // bottom-right
    {bottom: '20px', left: '20px', top: '', right: ''}  // bottom-left
];
let currentPosition = 0;

icon.addEventListener('click', function(e) {
    // Toggle panel
    container.classList.toggle('active');
    // Change position
    if (container.classList.contains('active')) {
        currentPosition = (currentPosition + 1) % positions.length;
        Object.assign(container.style, positions[currentPosition]);
    }
});

document.addEventListener('click', function(e) {
    if (!container.contains(e.target)) {
        container.classList.remove('active');
    }
});
</script> 