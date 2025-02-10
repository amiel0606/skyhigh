<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login</title>
</head>
<?php
$error = "";
?>

<body>
    <center>
        <div class="container">
            <table style="margin: 0;padding: 0;width: 60%;">
                <tr>
                    <td>
                        <p class="header-text">Welcome Back!</p>
                    </td>
                </tr>
                <div class="form-body">
                    <tr>
                        <td>
                            <p class="sub-text">Login with your details to continue</p>
                        </td>
                    </tr>

                    <form id="formz" action="./controllers/login.php" method="POST">
                        <td class="label-td">
                            <label for="username" class="form-label">Email: </label>
                        </td>

                        <tr>
                            <td class="label-td">
                                <input type="email" name="username" class="input-text" placeholder="Email Address"
                                    required>
                            </td>
                        </tr>

                        <tr>
                            <td class="label-td">
                                <label for="password" class="form-label">Password: </label>
                            </td>
                        </tr>

                        <tr>
                            <td class="label-td">
                                <input type="Password" name="password" class="input-text" placeholder="Password"
                                    required>
                            </td>
                        </tr>

                        <tr>
                            <td><br>
                                <?php echo $error ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="submit" value="Login" class="login-btn btn-primary btn" name="Login">
                            </td>
                        </tr>
                    </form>
                </div>
                <tr>
                    <td>
                        <br>
                        <label for="" class="sub-text" style="font-weight: 280;">Don't have an account&#63; </label>
                        <a href="signup.php" class="hover-link1 non-style-link">Sign Up</a>
                        <br><br><br>
                    </td>
                </tr>

            </table>
        </div>
    </center>
</body>

</html>