<?php
session_start();
http_response_code(405);

// Get the request method and allowed methods
$request_method = $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN';
$allowed_methods = 'GET, POST'; // Default allowed methods - can be customized
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>405 - Method Not Allowed</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
            animation: bounce 2s infinite;
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
        
        .method-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 2rem 0;
        }
        
        .method-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .method-detail {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            text-align: left;
        }
        
        .method-detail h4 {
            color: #363636;
            margin-bottom: 0.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .method-detail .method-value {
            font-family: 'Courier New', monospace;
            background: #f1f3f4;
            padding: 0.5rem;
            border-radius: 4px;
            color: #d73a49;
            font-weight: bold;
        }
        
        .method-detail .allowed-value {
            color: #28a745;
        }
        
        .methods-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 0.5rem;
            margin: 1rem 0;
        }
        
        .method-tag {
            background: #e9ecef;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            padding: 0.5rem;
            text-align: center;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .method-tag.allowed {
            background: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        .method-tag.not-allowed {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        .debug-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            text-align: left;
        }
        
        .debug-info h4 {
            color: #856404;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .debug-info code {
            background: #f8f9fa;
            padding: 0.2rem 0.4rem;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #d73a49;
        }
        
        .suggested-actions {
            background: #d1ecf1;
            border: 1px solid #b8daff;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            text-align: left;
        }
        
        .suggested-actions h4 {
            color: #0c5460;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .suggested-actions ul {
            margin: 0.5rem 0;
            padding-left: 1.5rem;
            color: #0c5460;
        }
        
        .suggested-actions li {
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
        
        .btn-info {
            background: #3298dc;
            color: white;
        }
        
        .btn-info:hover {
            background: #2793db;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(50, 152, 220, 0.3);
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
            
            .method-details {
                grid-template-columns: 1fr;
            }
            
            .methods-grid {
                grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            }
        }
        
        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0, 0, 0);
            }
            40%, 43% {
                transform: translate3d(0, -15px, 0);
            }
            70% {
                transform: translate3d(0, -7px, 0);
            }
            90% {
                transform: translate3d(0, -2px, 0);
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-hand-paper"></i>
        </div>
        <h1 class="error-code">405</h1>
        <h2 class="error-title">Method Not Allowed</h2>
        <p class="error-message">
            The HTTP method used for this request is not supported by the target resource.
        </p>
        
        <div class="method-info">
            <h3 style="color: #363636; margin-bottom: 1rem;">Method Information</h3>
            <div class="method-details">
                <div class="method-detail">
                    <h4><i class="fas fa-exclamation-circle" style="color: #ff3860;"></i> Request Method</h4>
                    <div class="method-value not-allowed"><?php echo htmlspecialchars($request_method); ?></div>
                </div>
                <div class="method-detail">
                    <h4><i class="fas fa-check-circle" style="color: #48c774;"></i> Allowed Methods</h4>
                    <div class="method-value allowed-value"><?php echo htmlspecialchars($allowed_methods); ?></div>
                </div>
            </div>
        </div>
        
        <div class="method-info">
            <h4 style="color: #363636; margin-bottom: 1rem;">Common HTTP Methods</h4>
            <div class="methods-grid">
                <?php
                $common_methods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'HEAD', 'OPTIONS'];
                $allowed_array = array_map('trim', explode(',', $allowed_methods));
                
                foreach ($common_methods as $method) {
                    $is_allowed = in_array($method, $allowed_array);
                    $class = $is_allowed ? 'allowed' : 'not-allowed';
                    echo "<div class='method-tag $class'>$method</div>";
                }
                ?>
            </div>
        </div>
        
        <div class="debug-info">
            <h4><i class="fas fa-bug"></i> Debug Information</h4>
            <p><strong>Requested URL:</strong> <code><?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? 'Unknown'); ?></code></p>
            <p><strong>Server:</strong> <code><?php echo htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'); ?></code></p>
            <p><strong>Timestamp:</strong> <code><?php echo date('Y-m-d H:i:s T'); ?></code></p>
            <?php if (isset($_SERVER['HTTP_USER_AGENT'])): ?>
            <p><strong>User Agent:</strong> <code><?php echo htmlspecialchars(substr($_SERVER['HTTP_USER_AGENT'], 0, 80)) . (strlen($_SERVER['HTTP_USER_AGENT']) > 80 ? '...' : ''); ?></code></p>
            <?php endif; ?>
        </div>
        
        <div class="suggested-actions">
            <h4><i class="fas fa-lightbulb"></i> Possible Solutions</h4>
            <ul>
                <li>Try using a <strong><?php echo explode(',', $allowed_methods)[0]; ?></strong> request instead</li>
                <li>Check your form's <code>method</code> attribute if submitting a form</li>
                <li>Verify the API endpoint accepts the method you're using</li>
                <li>Contact the website administrator if you believe this is an error</li>
                <li>Check the documentation for the correct HTTP method</li>
            </ul>
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
            
            <a href="#" onclick="refreshPage()" class="btn btn-info">
                <i class="fas fa-sync-alt"></i>
                Try Again
            </a>
        </div>
        
        <div style="margin-top: 2rem; font-size: 0.8rem; color: #999;">
            Error occurred at: <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>

    <script>
        function refreshPage() {
            // Try to refresh with GET method
            window.location.href = window.location.pathname + window.location.search;
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
            
            // Add hover effects to method tags
            const methodTags = document.querySelectorAll('.method-tag');
            methodTags.forEach(tag => {
                tag.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });
                
                tag.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
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