<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKYHIGH MOTORCYCLE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #262E36;
            position: relative;
            overflow: hidden;
            background-image: url('../img/background-home.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            
        }

        .logo-text {
            background: linear-gradient(90deg, #ff7e5f, #feb47b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin: auto;
        }

        .logo-text-skyhigh {
            font-size: 60pt;
            font-weight: 900;
        }

        .logo-text-motorcycle {
            font-size: 35pt;
            font-weight: 900;
        }

        .middle-text {
            font-size: 20pt;
            color: white;
            margin-left: 20px;
            font-weight: 900;
        }

        .logo-img {
            height: 75px;
        }

        .navbar {
            background-color: #212529;
        }

        .navbar-nav .nav-item {
            margin-right: 50px;
        }

        .navbar-nav .nav-link {
            font-size: 18pt;
            font-weight: 600;
            color: white;
        }

        .bg-secondary {
            background-color: #262E36 !important;
        }

        .background-container {
            position: relative;
            height: 400px;
            overflow: hidden;
        }

        .background-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('path/to/your/image.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.35;
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            color: white;
            padding: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="../img/logo.png" alt="Logo" class="me-2 logo-img">
                <div class="logo-container">
                    <span class="logo-text logo-text-skyhigh">SKYHIGH</span>
                    <span class="logo-text logo-text-motorcycle">MOTORCYCLE</span>
                </div>
                <span class="middle-text">Parts/Trading</span>
            </div>
            <div class="d-flex ms-auto">
                <button class="btn btn-outline-light me-2" type="button">Sign Up</button>
                <button class="btn btn-light" type="button">Log In</button>
            </div>
        </div>
    </nav>
    <nav class="navbar navbar-expand-lg bg-secondary">
        <div class="container-fluid">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">Parts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Inquire</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="background-container">
        <div class="content">
            <h1>Welcome to SKYHIGH MOTORCYCLE</h1>
            <p>Your one-stop shop for all motorcycle parts and services.</p>
            <p>Explore our wide range of products and services tailored for motorcycle enthusiasts.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>