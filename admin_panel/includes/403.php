<?php
session_start();
http_response_code(403);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Forbidden</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
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
            max-width: 600px;
            width: 90%;
            margin: 2rem;
        }
        
        .error-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
            color: #ff3860;
            animation: shake 1s infinite;
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
        
        .auth-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 2rem 0;
        }
        
        .auth-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .auth-option {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .auth-option:hover {
            border-color: #3273dc;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .auth-option i {
            font-size: 2rem;
            color: #3273dc;
            margin-bottom: 0.5rem;
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
        
        .security-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            color: #856404;
        }
        
        .security-info i {
            color: #f39c12;
            margin-right: 0.5rem;
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
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-ban"></i>
        </div>
        <h1 class="error-code">403</h1>
        <h2 class="error-title">Access Forbidden</h2>
        <p class="error-message">
            You don't have permission to access this resource. This could be due to insufficient privileges or you may need to log in.
        </p>
        
        <?php if (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id'])): ?>
        <div class="auth-container">
            <h3 style="color: #363636; margin-bottom: 1rem;">Authentication Required</h3>
            <div class="auth-options">
                <div class="auth-option" onclick="window.location.href='./login.php'">
                    <i class="fas fa-user-shield"></i>
                    <h4>Admin Login</h4>
                    <p>Access admin panel features</p>
                </div>
                <div class="auth-option" onclick="window.location.href='../login.php'">
                    <i class="fas fa-user"></i>
                    <h4>User Login</h4>
                    <p>Access user features</p>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['admin_id']) || isset($_SESSION['user_id'])): ?>
        <div class="security-info">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Insufficient Privileges:</strong> Your account doesn't have permission to access this resource. Contact an administrator if you believe this is an error.
        </div>
        <?php endif; ?>
        
        <div class="error-actions">
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Go Back
            </a>
            
            <?php if (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id'])): ?>
            <a href="./login.php" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </a>
            <?php else: ?>
            <a href="<?php echo isset($_SESSION['admin_id']) ? './dashboard.php' : '../index.php'; ?>" class="btn btn-primary">
                <i class="fas fa-home"></i>
                <?php echo isset($_SESSION['admin_id']) ? 'Dashboard' : 'Home'; ?>
            </a>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['admin_id']) || isset($_SESSION['user_id'])): ?>
            <a href="./logout.php" class="btn btn-danger">
                <i class="fas fa-sign-out-alt"></i>
                Logout & Login as Different User
            </a>
            <?php endif; ?>
        </div>
        
        <div style="margin-top: 2rem; font-size: 0.8rem; color: #999;">
            Access denied at: <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>

    <script>
        // Auto-redirect to login page after 10 seconds if not logged in
        <?php if (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id'])): ?>
        let countdown = 10;
        const countdownElement = document.createElement('div');
        countdownElement.style.cssText = 'margin-top: 1rem; color: #7a7a7a; font-size: 0.9rem;';
        countdownElement.innerHTML = `Redirecting to login in <span id="countdown">${countdown}</span> seconds...`;
        document.querySelector('.error-container').appendChild(countdownElement);
        
        const timer = setInterval(() => {
            countdown--;
            document.getElementById('countdown').textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = './login.php';
            }
        }, 1000);
        
        // Allow user to cancel redirect by interacting with the page
        document.addEventListener('click', () => {
            clearInterval(timer);
            countdownElement.remove();
        });
        <?php endif; ?>
        
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