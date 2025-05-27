<?php
session_start();
http_response_code(500);

// Error logging function (customize as needed)
function logError($error_details) {
    $log_file = __DIR__ . '/logs/error.log';
    $log_dir = dirname($log_file);
    
    // Create logs directory if it doesn't exist
    if (!is_dir($log_dir)) {
        @mkdir($log_dir, 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] Internal Server Error: " . json_encode($error_details) . PHP_EOL;
    
    @file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
}

// Collect error information (safely)
$error_info = [
    'timestamp' => date('Y-m-d H:i:s'),
    'url' => $_SERVER['REQUEST_URI'] ?? 'Unknown',
    'method' => $_SERVER['REQUEST_METHOD'] ?? 'Unknown',
    'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? substr($_SERVER['HTTP_USER_AGENT'], 0, 200) : 'Unknown',
    'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
    'referer' => $_SERVER['HTTP_REFERER'] ?? 'None'
];

// Log the error
logError($error_info);

// Generate error ID for reference
$error_id = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Internal Server Error</title>
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
            color: #ff3860;
            animation: pulse 2s infinite;
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: bold;
            color: #ff3860;
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
        
        .error-id-container {
            background: #f8f9fa;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 1rem;
            margin: 1.5rem 0;
            position: relative;
        }
        
        .error-id {
            font-family: 'Courier New', monospace;
            font-size: 1.2rem;
            font-weight: bold;
            color: #d73a49;
            margin: 0.5rem 0;
        }
        
        .copy-button {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: #3273dc;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 0.25rem 0.5rem;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }
        
        .copy-button:hover {
            background: #2366d1;
        }
        
        .copy-button.copied {
            background: #48c774;
        }
        
        .troubleshooting {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            text-align: left;
        }
        
        .troubleshooting h4 {
            color: #856404;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .troubleshooting ul {
            margin: 0.5rem 0;
            padding-left: 1.5rem;
            color: #856404;
        }
        
        .troubleshooting li {
            margin: 0.5rem 0;
        }
        
        .admin-info {
            background: #d1ecf1;
            border: 1px solid #b8daff;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            text-align: left;
            display: none;
        }
        
        .admin-info.show {
            display: block;
        }
        
        .admin-info h4 {
            color: #0c5460;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .admin-info code {
            background: #f8f9fa;
            padding: 0.2rem 0.4rem;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #d73a49;
            font-size: 0.9rem;
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
        
        .btn-info {
            background: #3298dc;
            color: white;
        }
        
        .btn-info:hover {
            background: #2793db;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(50, 152, 220, 0.3);
        }
        
        .toggle-link {
            color: #3273dc;
            cursor: pointer;
            text-decoration: underline;
            font-size: 0.9rem;
            margin: 1rem 0;
            display: inline-block;
        }
        
        .toggle-link:hover {
            color: #2366d1;
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
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h1 class="error-code">500</h1>
        <h2 class="error-title">Internal Server Error</h2>
        <p class="error-message">
            Oops! Something went wrong on our end. We're working to fix this issue as quickly as possible.
        </p>
        
        <div class="error-id-container">
            <h4 style="color: #363636; margin-bottom: 0.5rem;">Error Reference ID</h4>
            <div class="error-id" id="errorId"><?php echo $error_id; ?></div>
            <button class="copy-button" onclick="copyErrorId()">
                <i class="fas fa-copy"></i> Copy
            </button>
            <p style="font-size: 0.9rem; color: #7a7a7a; margin-top: 0.5rem;">
                Please provide this ID when contacting support.
            </p>
        </div>
        
        <div class="troubleshooting">
            <h4><i class="fas fa-tools"></i> Quick Troubleshooting</h4>
            <ul>
                <li><strong>Refresh the page</strong> - This might be a temporary issue</li>
                <li><strong>Clear your browser cache</strong> and try again</li>
                <li><strong>Try again in a few minutes</strong> - We might be performing maintenance</li>
                <li><strong>Check your internet connection</strong> and try again</li>
                <li><strong>Try using a different browser</strong> or device</li>
            </ul>
        </div>
        
        <a href="#" class="toggle-link" onclick="toggleAdminInfo()">
            <i class="fas fa-chevron-down"></i> Show Technical Details
        </a>
        
        <div class="admin-info" id="adminInfo">
            <h4><i class="fas fa-info-circle"></i> Technical Information</h4>
            <p><strong>Error ID:</strong> <code><?php echo $error_id; ?></code></p>
            <p><strong>Timestamp:</strong> <code><?php echo $error_info['timestamp']; ?></code></p>
            <p><strong>Request URL:</strong> <code><?php echo htmlspecialchars($error_info['url']); ?></code></p>
            <p><strong>Request Method:</strong> <code><?php echo htmlspecialchars($error_info['method']); ?></code></p>
            <p><strong>Server:</strong> <code><?php echo htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'); ?></code></p>
            <p><strong>PHP Version:</strong> <code><?php echo PHP_VERSION; ?></code></p>
            <?php if ($error_info['referer'] !== 'None'): ?>
            <p><strong>Referrer:</strong> <code><?php echo htmlspecialchars($error_info['referer']); ?></code></p>
            <?php endif; ?>
        </div>
        
        <div class="contact-info">
            <h4><i class="fas fa-life-ring"></i> Need Help?</h4>
            <p><strong>If this error persists:</strong></p>
            <p>• Contact the website administrator</p>
            <p>• Include the Error Reference ID: <strong><?php echo $error_id; ?></strong></p>
            <p>• Describe what you were trying to do when the error occurred</p>
        </div>
        
        <div class="error-actions">
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Go Back
            </a>
            
            <a href="<?php echo isset($_SESSION['admin_id']) ? './dashboard.php' : (isset($_SESSION['user_id']) ? '../index.php' : './login.php'); ?>" class="btn btn-primary">
                <i class="fas fa-home"></i>
                <?php 
                if (isset($_SESSION['admin_id'])) {
                    echo 'Dashboard';
                } elseif (isset($_SESSION['user_id'])) {
                    echo 'Home';
                } else {
                    echo 'Login';
                }
                ?>
            </a>
            
            <a href="#" onclick="location.reload()" class="btn btn-info">
                <i class="fas fa-sync-alt"></i>
                Refresh Page
            </a>
            
            <a href="#" onclick="reportError()" class="btn btn-warning">
                <i class="fas fa-bug"></i>
                Report Issue
            </a>
        </div>
        
        <div style="margin-top: 2rem; font-size: 0.8rem; color: #999;">
            Error logged at: <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>

    <script>
        function copyErrorId() {
            const errorId = document.getElementById('errorId').textContent;
            navigator.clipboard.writeText(errorId).then(function() {
                const button = document.querySelector('.copy-button');
                const originalText = button.innerHTML;
                
                button.innerHTML = '<i class="fas fa-check"></i> Copied!';
                button.classList.add('copied');
                
                setTimeout(function() {
                    button.innerHTML = originalText;
                    button.classList.remove('copied');
                }, 2000);
            }).catch(function() {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = errorId;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                alert('Error ID copied to clipboard: ' + errorId);
            });
        }
        
        function toggleAdminInfo() {
            const adminInfo = document.getElementById('adminInfo');
            const toggleLink = document.querySelector('.toggle-link');
            
            if (adminInfo.classList.contains('show')) {
                adminInfo.classList.remove('show');
                toggleLink.innerHTML = '<i class="fas fa-chevron-down"></i> Show Technical Details';
            } else {
                adminInfo.classList.add('show');
                toggleLink.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Technical Details';
            }
        }
        
        function reportError() {
            const errorId = document.getElementById('errorId').textContent;
            const subject = encodeURIComponent('Error Report - ID: ' + errorId);
            const body = encodeURIComponent(
                'Error ID: ' + errorId + '\n' +
                'URL: ' + window.location.href + '\n' +
                'Time: ' + new Date().toISOString() + '\n' +
                'Description: [Please describe what you were doing when the error occurred]\n'
            );
            
            // You can customize this email address
            window.location.href = 'mailto:support@example.com?subject=' + subject + '&body=' + body;
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
        
        // Auto-refresh after 30 seconds (can be customized or removed)
        setTimeout(function() {
            if (confirm('Would you like to try refreshing the page? This might resolve the issue.')) {
                location.reload();
            }
        }, 30000);
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