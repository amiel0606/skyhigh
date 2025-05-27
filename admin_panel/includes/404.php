<?php
session_start();
http_response_code(404);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
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
            max-width: 600px;
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
        
        .search-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 2rem 0;
        }
        
        .search-box {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .search-input {
            flex: 1;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
        }
        
        .search-input:focus {
            border-color: #3273dc;
            outline: none;
        }
        
        .search-btn {
            padding: 0.75rem 1.5rem;
            background: #3273dc;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .search-btn:hover {
            background: #2366d1;
        }
        
        .suggestions {
            text-align: left;
        }
        
        .suggestions h4 {
            color: #363636;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .suggestions ul {
            list-style: none;
            padding: 0;
        }
        
        .suggestions li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .suggestions li:last-child {
            border-bottom: none;
        }
        
        .suggestions a {
            color: #3273dc;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .suggestions a:hover {
            color: #2366d1;
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
            
            .search-box {
                flex-direction: column;
            }
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
        <div class="error-icon">
            <i class="fas fa-search"></i>
        </div>
        <h1 class="error-code">404</h1>
        <h2 class="error-title">Page Not Found</h2>
        <p class="error-message">
            Oops! The page you're looking for seems to have vanished into thin air. 
            Don't worry, it happens to the best of us!
        </p>
        
        <div class="search-container">
            <div class="search-box">
                <input type="text" class="search-input" placeholder="Search for what you're looking for..." id="searchInput">
                <button class="search-btn" onclick="performSearch()">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            
            <div class="suggestions">
                <h4>Popular Pages:</h4>
                <ul>
                    <li><a href="./dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="./orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                    <li><a href="./appointments.php"><i class="fas fa-calendar-check"></i> Appointments</a></li>
                    <li><a href="./analytics.php"><i class="fas fa-chart-bar"></i> Analytics</a></li>
                    <li><a href="./settings.php"><i class="fas fa-cogs"></i> Settings</a></li>
                </ul>
            </div>
        </div>
        
        <div class="error-actions">
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Go Back
            </a>
            <a href="<?php echo isset($_SESSION['admin_id']) ? './dashboard.php' : './index.php'; ?>" class="btn btn-primary">
                <i class="fas fa-home"></i>
                <?php echo isset($_SESSION['admin_id']) ? 'Dashboard' : 'Home'; ?>
            </a>
        </div>
        
        <div style="margin-top: 2rem; font-size: 0.8rem; color: #999;">
            Error occurred at: <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>

    <script>
        function performSearch() {
            const query = document.getElementById('searchInput').value.trim();
            if (query) {
                // You can customize this to search within your site
                window.location.href = `./search.php?q=${encodeURIComponent(query)}`;
                // Or redirect to dashboard with search parameter
                // window.location.href = `./dashboard.php?search=${encodeURIComponent(query)}`;
            }
        }
        
        // Allow Enter key to search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
        
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Focus on search input
            document.getElementById('searchInput').focus();
            
            // Add click effects to buttons
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