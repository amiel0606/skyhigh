<?php
session_start();
http_response_code(401);

// Check if there was a failed login attempt
$failed_login = isset($_GET['login']) && $_GET['login'] === 'failed';
$session_expired = isset($_GET['reason']) && $_GET['reason'] === 'expired';
$insufficient_auth = isset($_GET['reason']) && $_GET['reason'] === 'insufficient';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 - Unauthorized</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
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
            max-width: 650px;
            width: 90%;
            margin: 2rem;
        }
        
        .error-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
            color: #ff3860;
            animation: lockShake 1.5s ease-in-out infinite;
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
        
        .auth-status {
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
            margin-bottom: 1rem;
        }
        
        .status-indicator i {
            font-size: 2rem;
        }
        
        .status-indicator.failed {
            color: #ff3860;
        }
        
        .status-indicator.expired {
            color: #ff9800;
        }
        
        .status-indicator.insufficient {
            color: #2196F3;
        }
        
        .status-indicator.default {
            color: #6c757d;
        }
        
        .auth-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .auth-option {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }
        
        .auth-option:hover {
            border-color: #3273dc;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            text-decoration: none;
            color: inherit;
        }
        
        .auth-option i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .auth-option.admin i {
            color: #ff3860;
        }
        
        .auth-option.user i {
            color: #3273dc;
        }
        
        .auth-option h4 {
            color: #363636;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .auth-option p {
            color: #7a7a7a;
            font-size: 0.9rem;
            margin: 0;
        }
        
        .security-notice {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 1rem;
            margin: 1.5rem 0;
            text-align: left;
        }
        
        .security-notice h4 {
            color: #856404;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .security-notice ul {
            margin: 0.5rem 0;
            padding-left: 1.5rem;
            color: #856404;
        }
        
        .security-notice li {
            margin: 0.25rem 0;
        }
        
        .help-section {
            background: #d1ecf1;
            border: 1px solid #b8daff;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            text-align: left;
        }
        
        .help-section h4 {
            color: #0c5460;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .help-section p {
            color: #0c5460;
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
        
        .btn-danger {
            background: #ff3860;
            color: white;
        }
        
        .btn-danger:hover {
            background: #ff1f43;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 56, 96, 0.3);
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
            
            .auth-options {
                grid-template-columns: 1fr;
            }
        }
        
        @keyframes lockShake {
            0%, 100% { transform: rotate(0deg); }
            10%, 30%, 50%, 70%, 90% { transform: rotate(-3deg); }
            20%, 40%, 60%, 80% { transform: rotate(3deg); }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-lock"></i>
        </div>
        <h1 class="error-code">401</h1>
        <h2 class="error-title">Unauthorized</h2>
        <p class="error-message">
            Access to this resource requires authentication. Please log in to continue.
        </p>
        
        <div class="auth-status">
            <?php if ($failed_login): ?>
            <div class="status-indicator failed">
                <i class="fas fa-times-circle"></i>
                <span><strong>Login Failed:</strong> Invalid credentials provided</span>
            </div>
            <?php elseif ($session_expired): ?>
            <div class="status-indicator expired">
                <i class="fas fa-clock"></i>
                <span><strong>Session Expired:</strong> Please log in again</span>
            </div>
            <?php elseif ($insufficient_auth): ?>
            <div class="status-indicator insufficient">
                <i class="fas fa-user-times"></i>
                <span><strong>Insufficient Authentication:</strong> Additional verification required</span>
            </div>
            <?php else: ?>
            <div class="status-indicator default">
                <i class="fas fa-key"></i>
                <span><strong>Authentication Required:</strong> Please choose your login type</span>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="auth-options">
            <a href="./login.php" class="auth-option admin">
                <i class="fas fa-user-shield"></i>
                <h4>Admin Login</h4>
                <p>Access administrative functions and management tools</p>
            </a>
            
            <a href="../login.php" class="auth-option user">
                <i class="fas fa-user"></i>
                <h4>User Login</h4>
                <p>Access your account and user features</p>
            </a>
        </div>
        
        <div class="security-notice">
            <h4><i class="fas fa-shield-alt"></i> Security Information</h4>
            <ul>
                <li>Ensure you're using the correct username and password</li>
                <li>Check that Caps Lock is not enabled</li>
                <li>Account may be temporarily locked after multiple failed attempts</li>
                <li>Contact support if you've forgotten your credentials</li>
            </ul>
        </div>
        
        <?php if ($failed_login): ?>
        <div class="help-section">
            <h4><i class="fas fa-question-circle"></i> Troubleshooting Login Issues</h4>
            <p><strong>Common solutions:</strong></p>
            <p>• Double-check your username and password</p>
            <p>• Try resetting your password if available</p>
            <p>• Clear your browser cache and cookies</p>
            <p>• Disable browser extensions that might interfere</p>
            <p>• Contact support if the problem persists</p>
        </div>
        <?php endif; ?>
        
        <div class="error-actions">
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Go Back
            </a>
            
            <a href="./login.php" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i>
                Admin Login
            </a>
            
            <a href="../login.php" class="btn btn-danger">
                <i class="fas fa-user"></i>
                User Login
            </a>
        </div>
        
        <div class="countdown" id="countdown"></div>
        
        <div style="margin-top: 2rem; font-size: 0.8rem; color: #999;">
            Authentication required at: <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>

    <script>
        // Auto-redirect to appropriate login page after 15 seconds
        let countdown = 15;
        const countdownElement = document.getElementById('countdown');
        
        function updateCountdown() {
            if (countdown > 0) {
                countdownElement.textContent = `Redirecting to login page in ${countdown} seconds...`;
                countdown--;
                setTimeout(updateCountdown, 1000);
            } else {
                // Redirect to admin login by default, or user login if appropriate
                window.location.href = './login.php';
            }
        }
        
        // Start countdown
        updateCountdown();
        
        // Cancel countdown if user interacts with the page
        document.addEventListener('click', function() {
            countdown = 0;
            countdownElement.textContent = '';
        });
        
        document.addEventListener('keypress', function() {
            countdown = 0;
            countdownElement.textContent = '';
        });
        
        // Add click effects
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn, .auth-option');
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
        
        // Handle different authentication scenarios
        <?php if ($failed_login): ?>
        // Focus on login form when redirected from failed login
        setTimeout(() => {
            if (confirm('Login failed. Would you like to try again immediately?')) {
                window.location.href = './login.php?retry=1';
            }
        }, 2000);
        <?php endif; ?>
        
        <?php if ($session_expired): ?>
        // Show session expiry message
        setTimeout(() => {
            alert('Your session has expired for security reasons. Please log in again.');
        }, 1000);
        <?php endif; ?>
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