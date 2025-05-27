<?php
session_start();

// Get error code from URL parameter or session, default to 404
$error_code = isset($_GET['code']) ? (int)$_GET['code'] : (isset($_SESSION['error_code']) ? $_SESSION['error_code'] : 404);
$error_message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : (isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '');

// Clear session error data after retrieving
if (isset($_SESSION['error_code'])) {
    unset($_SESSION['error_code']);
}
if (isset($_SESSION['error_message'])) {
    unset($_SESSION['error_message']);
}

// Define error messages and titles
$errors = [
    400 => [
        'title' => 'Bad Request',
        'message' => 'The request could not be understood by the server.',
        'icon' => '⚠️'
    ],
    401 => [
        'title' => 'Unauthorized',
        'message' => 'You are not authorized to access this resource.',
        'icon' => '🔒'
    ],
    403 => [
        'title' => 'Forbidden',
        'message' => 'You don\'t have permission to access this resource.',
        'icon' => '🚫'
    ],
    404 => [
        'title' => 'Page Not Found',
        'message' => 'The page you are looking for could not be found.',
        'icon' => '🔍'
    ],
    405 => [
        'title' => 'Method Not Allowed',
        'message' => 'The request method is not allowed for this resource.',
        'icon' => '❌'
    ],
    500 => [
        'title' => 'Internal Server Error',
        'message' => 'Something went wrong on our end. Please try again later.',
        'icon' => '⚡'
    ],
    502 => [
        'title' => 'Bad Gateway',
        'message' => 'The server received an invalid response from the upstream server.',
        'icon' => '🌐'
    ],
    503 => [
        'title' => 'Service Unavailable',
        'message' => 'The service is temporarily unavailable. Please try again later.',
        'icon' => '🔧'
    ]
];

// Get error details or use default
$error = isset($errors[$error_code]) ? $errors[$error_code] : $errors[404];

// Use custom message if provided
if (!empty($error_message)) {
    $error['message'] = $error_message;
}

// Set appropriate HTTP status code
http_response_code($error_code);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error <?php echo $error_code; ?> - <?php echo $error['title']; ?></title>
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
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            text-align: center;
            max-width: 500px;
            width: 90%;
            margin: 2rem;
        }
        
        .error-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: #ff3860;
            margin: 0;
            line-height: 1;
        }
        
        .error-title {
            font-size: 2rem;
            color: #363636;
            margin: 1rem 0;
            font-weight: 600;
        }
        
        .error-message {
            color: #7a7a7a;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            line-height: 1.5;
        }
        
        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
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
        
        .error-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin: 1.5rem 0;
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        @media (max-width: 768px) {
            .error-container {
                padding: 2rem 1.5rem;
            }
            
            .error-code {
                font-size: 4rem;
            }
            
            .error-title {
                font-size: 1.5rem;
            }
            
            .error-actions {
                flex-direction: column;
            }
        }
        
        .animate-bounce {
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon animate-bounce"><?php echo $error['icon']; ?></div>
        <h1 class="error-code"><?php echo $error_code; ?></h1>
        <h2 class="error-title"><?php echo $error['title']; ?></h2>
        <p class="error-message"><?php echo $error['message']; ?></p>
        
        <?php if (isset($_GET['details']) && !empty($_GET['details'])): ?>
        <div class="error-details">
            <strong>Details:</strong> <?php echo htmlspecialchars($_GET['details']); ?>
        </div>
        <?php endif; ?>
        
        <div class="error-actions">
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Go Back
            </a>
            <a href="<?php echo isset($_SESSION['admin_id']) ? './dashboard.php' : './index.php'; ?>" class="btn btn-primary">
                <i class="fas fa-home"></i>
                <?php echo isset($_SESSION['admin_id']) ? 'Dashboard' : 'Home'; ?>
            </a>
            <?php if ($error_code >= 500): ?>
            <a href="mailto:support@skyhigh.com?subject=Error <?php echo $error_code; ?> Report" class="btn btn-secondary">
                <i class="fas fa-envelope"></i>
                Report Issue
            </a>
            <?php endif; ?>
        </div>
        
        <div style="margin-top: 2rem; font-size: 0.8rem; color: #999;">
            Error occurred at: <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>

    <script>
        // Auto-redirect for certain errors after a delay
        <?php if (in_array($error_code, [401, 403])): ?>
        setTimeout(function() {
            if (confirm('You will be redirected to the login page. Click OK to continue or Cancel to stay.')) {
                window.location.href = './login.php';
            }
        }, 5000);
        <?php endif; ?>
        
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Add click effect to buttons
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