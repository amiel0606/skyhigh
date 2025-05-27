<?php
session_start();
http_response_code(503);

// Check for maintenance mode or specific service issues
$maintenance_mode = isset($_GET['maintenance']) && $_GET['maintenance'] === 'true';
$database_error = isset($_GET['db']) && $_GET['db'] === 'error';
$overload_error = isset($_GET['overload']) && $_GET['overload'] === 'true';

// Estimate maintenance duration (can be customized)
$estimated_duration = "30 minutes";
$estimated_completion = date('H:i', strtotime('+30 minutes'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Service Unavailable</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .error-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            padding: 3rem;
            text-align: center;
            max-width: 700px;
            width: 90%;
            margin: 2rem;
        }
        
        .error-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
            color: #ff9800;
            animation: spin 3s linear infinite;
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: bold;
            color: #ff9800;
            margin: 0;
            line-height: 1;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .error-title {
            font-size: 2.5rem;
            color: #363636;
            margin: 1rem 0;
            font-weight: 600;
        }
        
        .error-message {
            color: #7a7a7a;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .status-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 2rem 0;
        }
        
        .status-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .status-indicator i {
            font-size: 2.5rem;
        }
        
        .status-indicator.maintenance {
            color: #ff9800;
        }
        
        .status-indicator.database {
            color: #f44336;
        }
        
        .status-indicator.overload {
            color: #9c27b0;
        }
        
        .status-indicator.default {
            color: #607d8b;
        }
        
        .service-status {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }
        
        .service-item {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            border-left: 4px solid #e0e0e0;
        }
        
        .service-item.online {
            border-left-color: #4caf50;
        }
        
        .service-item.offline {
            border-left-color: #f44336;
        }
        
        .service-item.maintenance {
            border-left-color: #ff9800;
        }
        
        .service-item i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .service-item.online i {
            color: #4caf50;
        }
        
        .service-item.offline i {
            color: #f44336;
        }
        
        .service-item.maintenance i {
            color: #ff9800;
        }
        
        .service-item h4 {
            color: #363636;
            margin-bottom: 0.25rem;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .service-item .status {
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
        }
        
        .service-item.online .status {
            color: #4caf50;
        }
        
        .service-item.offline .status {
            color: #f44336;
        }
        
        .service-item.maintenance .status {
            color: #ff9800;
        }
        
        .eta-container {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 1rem;
            margin: 1.5rem 0;
        }
        
        .eta-container h4 {
            color: #856404;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .eta-time {
            font-size: 1.2rem;
            font-weight: bold;
            color: #856404;
            margin: 0.5rem 0;
        }
        
        .progress-bar {
            background: #e9ecef;
            border-radius: 4px;
            height: 8px;
            margin: 1rem 0;
            overflow: hidden;
        }
        
        .progress-fill {
            background: linear-gradient(90deg, #ff9800, #ffc107);
            height: 100%;
            width: 0%;
            animation: progress 30s linear infinite;
        }
        
        .updates-section {
            background: #d1ecf1;
            border: 1px solid #b8daff;
            border-radius: 8px;
            padding: 1rem;
            margin: 1.5rem 0;
            text-align: left;
        }
        
        .updates-section h4 {
            color: #0c5460;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .update-item {
            padding: 0.5rem 0;
            border-bottom: 1px solid #bee5eb;
            color: #0c5460;
        }
        
        .update-item:last-child {
            border-bottom: none;
        }
        
        .update-time {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: 500;
        }
        
        .contact-info {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            text-align: left;
        }
        
        .contact-info h4 {
            color: #721c24;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .contact-info p {
            color: #721c24;
            margin: 0.25rem 0;
        }
        
        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: #3273dc;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2366d1;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(50, 115, 220, 0.3);
        }
        
        .btn-secondary {
            background: #f5f5f5;
            color: #363636;
        }
        
        .btn-secondary:hover {
            background: #eeeeee;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-warning {
            background: #ffdd57;
            color: #363636;
        }
        
        .btn-warning:hover {
            background: #ffd83d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 221, 87, 0.3);
        }
        
        .countdown {
            color: #7a7a7a;
            font-size: 0.9rem;
            margin-top: 1rem;
        }
        
        @media (max-width: 768px) {
            .error-container {
                padding: 2rem 1.5rem;
            }
            
            .error-code {
                font-size: 5rem;
            }
            
            .error-title {
                font-size: 2rem;
            }
            
            .error-actions {
                flex-direction: column;
            }
            
            .service-status {
                grid-template-columns: 1fr;
            }
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes progress {
            from { width: 0%; }
            to { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-cog"></i>
        </div>
        <h1 class="error-code">503</h1>
        <h2 class="error-title">Service Unavailable</h2>
        <p class="error-message">
            We're temporarily unable to serve your request. Our team is working to restore service as quickly as possible.
        </p>
        
        <div class="status-container">
            <?php if ($maintenance_mode): ?>
            <div class="status-indicator maintenance">
                <i class="fas fa-tools"></i>
                <span><strong>Scheduled Maintenance:</strong> System upgrades in progress</span>
            </div>
            <?php elseif ($database_error): ?>
            <div class="status-indicator database">
                <i class="fas fa-database"></i>
                <span><strong>Database Issue:</strong> Temporary connectivity problems</span>
            </div>
            <?php elseif ($overload_error): ?>
            <div class="status-indicator overload">
                <i class="fas fa-tachometer-alt"></i>
                <span><strong>High Traffic:</strong> Server experiencing heavy load</span>
            </div>
            <?php else: ?>
            <div class="status-indicator default">
                <i class="fas fa-exclamation-triangle"></i>
                <span><strong>Service Disruption:</strong> Temporary service interruption</span>
            </div>
            <?php endif; ?>
            
            <div class="service-status">
                <div class="service-item <?php echo $database_error ? 'offline' : ($maintenance_mode ? 'maintenance' : 'online'); ?>">
                    <i class="fas fa-database"></i>
                    <h4>Database</h4>
                    <div class="status"><?php echo $database_error ? 'Offline' : ($maintenance_mode ? 'Maintenance' : 'Online'); ?></div>
                </div>
                
                <div class="service-item <?php echo $maintenance_mode ? 'maintenance' : 'online'; ?>">
                    <i class="fas fa-server"></i>
                    <h4>Web Server</h4>
                    <div class="status"><?php echo $maintenance_mode ? 'Maintenance' : 'Online'; ?></div>
                </div>
                
                <div class="service-item <?php echo $overload_error ? 'offline' : ($maintenance_mode ? 'maintenance' : 'online'); ?>">
                    <i class="fas fa-cloud"></i>
                    <h4>API Services</h4>
                    <div class="status"><?php echo $overload_error ? 'Overloaded' : ($maintenance_mode ? 'Maintenance' : 'Online'); ?></div>
                </div>
                
                <div class="service-item online">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Security</h4>
                    <div class="status">Online</div>
                </div>
            </div>
        </div>
        
        <?php if ($maintenance_mode): ?>
        <div class="eta-container">
            <h4><i class="fas fa-clock"></i> Estimated Completion Time</h4>
            <div class="eta-time"><?php echo $estimated_completion; ?> (<?php echo $estimated_duration; ?>)</div>
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
            <p style="color: #856404; font-size: 0.9rem; margin: 0;">
                We appreciate your patience during this maintenance window.
            </p>
        </div>
        <?php endif; ?>
        
        <div class="updates-section">
            <h4><i class="fas fa-info-circle"></i> Recent Updates</h4>
            
            <?php if ($maintenance_mode): ?>
            <div class="update-item">
                <div class="update-time"><?php echo date('H:i'); ?></div>
                <div>Scheduled maintenance started - System upgrades in progress</div>
            </div>
            <div class="update-item">
                <div class="update-time"><?php echo date('H:i', strtotime('-5 minutes')); ?></div>
                <div>Maintenance notification sent to all users</div>
            </div>
            <?php elseif ($database_error): ?>
            <div class="update-item">
                <div class="update-time"><?php echo date('H:i'); ?></div>
                <div>Database connectivity issues detected - Team investigating</div>
            </div>
            <div class="update-item">
                <div class="update-time"><?php echo date('H:i', strtotime('-2 minutes')); ?></div>
                <div>Attempting to restore database connections</div>
            </div>
            <?php elseif ($overload_error): ?>
            <div class="update-item">
                <div class="update-time"><?php echo date('H:i'); ?></div>
                <div>High traffic detected - Scaling additional resources</div>
            </div>
            <div class="update-item">
                <div class="update-time"><?php echo date('H:i', strtotime('-1 minute')); ?></div>
                <div>Load balancing adjustments in progress</div>
            </div>
            <?php else: ?>
            <div class="update-item">
                <div class="update-time"><?php echo date('H:i'); ?></div>
                <div>Service disruption detected - Investigating root cause</div>
            </div>
            <div class="update-item">
                <div class="update-time"><?php echo date('H:i', strtotime('-3 minutes')); ?></div>
                <div>Technical team has been notified</div>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="contact-info">
            <h4><i class="fas fa-headset"></i> Need Immediate Assistance?</h4>
            <p><strong>For urgent matters:</strong></p>
            <p>• Check our status page for real-time updates</p>
            <p>• Contact support if you have critical business needs</p>
            <p>• Follow us on social media for announcements</p>
            <p>• Email: support@example.com for non-urgent inquiries</p>
        </div>
        
        <div class="error-actions">
            <a href="javascript:location.reload()" class="btn btn-primary">
                <i class="fas fa-sync-alt"></i>
                Refresh Page
            </a>
            
            <a href="#" onclick="checkStatus()" class="btn btn-warning">
                <i class="fas fa-heartbeat"></i>
                Check Status
            </a>
            
            <a href="mailto:support@example.com" class="btn btn-secondary">
                <i class="fas fa-envelope"></i>
                Contact Support
            </a>
        </div>
        
        <div class="countdown" id="countdown"></div>
        
        <div style="margin-top: 2rem; font-size: 0.8rem; color: #999;">
            Service unavailable since: <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>

    <script>
        // Auto-refresh page every 60 seconds
        let countdown = 60;
        const countdownElement = document.getElementById('countdown');
        
        function updateCountdown() {
            if (countdown > 0) {
                countdownElement.textContent = `Automatically refreshing in ${countdown} seconds...`;
                countdown--;
                setTimeout(updateCountdown, 1000);
            } else {
                location.reload();
            }
        }
        
        // Start countdown
        updateCountdown();
        
        // Cancel countdown if user interacts with the page
        document.addEventListener('click', function() {
            countdown = 0;
            countdownElement.textContent = 'Auto-refresh cancelled.';
        });
        
        function checkStatus() {
            // Simulate status check
            const status = Math.random() > 0.5 ? 'online' : 'offline';
            if (status === 'online') {
                if (confirm('Service appears to be restored! Would you like to reload the page?')) {
                    location.reload();
                }
            } else {
                alert('Service is still unavailable. Please try again in a few minutes.');
            }
        }
        
        // Add click effects
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Create ripple effect
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.style.position = 'absolute';
                    ripple.style.borderRadius = '50%';
                    ripple.style.background = 'rgba(255, 255, 255, 0.5)';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.animation = 'ripple 0.6s linear';
                    ripple.style.pointerEvents = 'none';
                    
                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
        
        // Page visibility API to pause/resume countdown when tab is not visible
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Pause countdown when tab is hidden
                countdown = Math.max(countdown, 10); // Keep at least 10 seconds
            }
        });
    </script>
    
    <style>
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
</body>
</html> 