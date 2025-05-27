<?php
session_start();
http_response_code(400);

// Collect request information for debugging
$request_info = [
    'method' => $_SERVER['REQUEST_METHOD'] ?? 'Unknown',
    'url' => $_SERVER['REQUEST_URI'] ?? 'Unknown',
    'query_string' => $_SERVER['QUERY_STRING'] ?? '',
    'content_type' => $_SERVER['CONTENT_TYPE'] ?? 'Unknown',
    'content_length' => $_SERVER['CONTENT_LENGTH'] ?? 'Unknown',
    'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? substr($_SERVER['HTTP_USER_AGENT'], 0, 100) : 'Unknown'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>400 - Bad Request</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 50%, #fecfef 100%);
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
            animation: wiggle 1s ease-in-out infinite;
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
        
        .request-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 2rem 0;
            text-align: left;
        }
        
        .request-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .request-detail {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            border-left: 4px solid #ff3860;
        }
        
        .request-detail h4 {
            color: #363636;
            margin-bottom: 0.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .request-detail .value {
            font-family: 'Courier New', monospace;
            background: #f1f3f4;
            padding: 0.5rem;
            border-radius: 4px;
            color: #d73a49;
            font-weight: bold;
            word-break: break-all;
        }
        
        .common-causes {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            text-align: left;
        }
        
        .common-causes h4 {
            color: #856404;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .common-causes ul {
            margin: 0.5rem 0;
            padding-left: 1.5rem;
            color: #856404;
        }
        
        .common-causes li {
            margin: 0.5rem 0;
        }
        
        .troubleshooting {
            background: #d1ecf1;
            border: 1px solid #b8daff;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            text-align: left;
        }
        
        .troubleshooting h4 {
            color: #0c5460;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .troubleshooting ul {
            margin: 0.5rem 0;
            padding-left: 1.5rem;
            color: #0c5460;
        }
        
        .troubleshooting li {
            margin: 0.5rem 0;
        }
        
        .format-examples {
            background: #e2e3e5;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            text-align: left;
        }
        
        .format-examples h5 {
            color: #495057;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .format-examples code {
            background: #f8f9fa;
            padding: 0.2rem 0.4rem;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #d73a49;
            display: block;
            margin: 0.25rem 0;
            white-space: pre-wrap;
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
        
        .btn-warning {
            background: #ffdd57;
            color: #363636;
        }
        
        .btn-warning:hover {
            background: #ffd83d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 221, 87, 0.3);
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
            
            .request-details {
                grid-template-columns: 1fr;
            }
        }
        
        @keyframes wiggle {
            0%, 7% { transform: rotateZ(0); }
            15% { transform: rotateZ(-15deg); }
            20% { transform: rotateZ(10deg); }
            25% { transform: rotateZ(-10deg); }
            30% { transform: rotateZ(6deg); }
            35% { transform: rotateZ(-4deg); }
            40%, 100% { transform: rotateZ(0); }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <h1 class="error-code">400</h1>
        <h2 class="error-title">Bad Request</h2>
        <p class="error-message">
            Your request cannot be processed due to malformed syntax or invalid parameters. Please check your request format and try again.
        </p>
        
        <div class="request-info">
            <h3 style="color: #363636; margin-bottom: 1rem;">Request Information</h3>
            <div class="request-details">
                <div class="request-detail">
                    <h4><i class="fas fa-globe"></i> Request Method</h4>
                    <div class="value"><?php echo htmlspecialchars($request_info['method']); ?></div>
                </div>
                <div class="request-detail">
                    <h4><i class="fas fa-link"></i> Request URL</h4>
                    <div class="value"><?php echo htmlspecialchars($request_info['url']); ?></div>
                </div>
                <div class="request-detail">
                    <h4><i class="fas fa-file-alt"></i> Content Type</h4>
                    <div class="value"><?php echo htmlspecialchars($request_info['content_type']); ?></div>
                </div>
                <div class="request-detail">
                    <h4><i class="fas fa-ruler"></i> Content Length</h4>
                    <div class="value"><?php echo htmlspecialchars($request_info['content_length']); ?></div>
                </div>
            </div>
        </div>
        
        <div class="common-causes">
            <h4><i class="fas fa-search"></i> Common Causes</h4>
            <ul>
                <li><strong>Invalid JSON format</strong> - Check for missing quotes, commas, or brackets</li>
                <li><strong>Missing required parameters</strong> - Ensure all mandatory fields are included</li>
                <li><strong>Incorrect data types</strong> - Verify numbers, strings, and boolean values</li>
                <li><strong>Special characters</strong> - URL encode special characters properly</li>
                <li><strong>Request size too large</strong> - Reduce the amount of data being sent</li>
                <li><strong>Invalid URL format</strong> - Check for proper encoding and structure</li>
            </ul>
        </div>
        
        <div class="troubleshooting">
            <h4><i class="fas fa-tools"></i> Troubleshooting Steps</h4>
            <ul>
                <li><strong>Validate your data format</strong> - Use JSON validators for API requests</li>
                <li><strong>Check parameter names</strong> - Ensure they match the expected format</li>
                <li><strong>Review request headers</strong> - Set appropriate Content-Type headers</li>
                <li><strong>Test with minimal data</strong> - Start with basic requests and add complexity</li>
                <li><strong>Check for encoding issues</strong> - Ensure proper UTF-8 encoding</li>
                <li><strong>Verify file uploads</strong> - Check file size and format restrictions</li>
            </ul>
            
            <div class="format-examples">
                <h5>Example: Correct JSON Format</h5>
                <code>{
    "name": "John Doe",
    "email": "john@example.com",
    "age": 30,
    "active": true
}</code>
                
                <h5>Example: Correct URL Parameters</h5>
                <code>?name=John%20Doe&email=john%40example.com&age=30</code>
            </div>
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
            
            <a href="#" onclick="validateRequest()" class="btn btn-info">
                <i class="fas fa-check-circle"></i>
                Validate Request
            </a>
            
            <a href="#" onclick="showHelp()" class="btn btn-warning">
                <i class="fas fa-question-circle"></i>
                Get Help
            </a>
        </div>
        
        <div style="margin-top: 2rem; font-size: 0.8rem; color: #999;">
            Request failed at: <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>

    <script>
        function validateRequest() {
            alert('Request Validation Tips:\n\n' +
                  '1. Check JSON syntax with a validator\n' +
                  '2. Ensure all required fields are present\n' +
                  '3. Verify data types match expectations\n' +
                  '4. URL encode special characters\n' +
                  '5. Check Content-Type headers');
        }
        
        function showHelp() {
            const helpContent = `
                <div style="text-align: left; max-width: 500px;">
                    <h3>Request Format Help</h3>
                    <p><strong>For Form Submissions:</strong></p>
                    <ul>
                        <li>Use proper field names</li>
                        <li>Include required fields</li>
                        <li>Check file upload limits</li>
                    </ul>
                    <p><strong>For API Requests:</strong></p>
                    <ul>
                        <li>Set Content-Type: application/json</li>
                        <li>Use valid JSON format</li>
                        <li>Include authentication headers</li>
                    </ul>
                </div>
            `;
            
            // Create modal or alert with help content
            if (confirm('Would you like to see detailed help documentation?')) {
                window.open('https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/400', '_blank');
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