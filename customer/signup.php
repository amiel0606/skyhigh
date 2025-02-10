<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/signup.css">

    <title>Sign Up</title>

</head>

<body>
    <center>
        <div class="container">
            <table border="0">
                <tr>
                    <td colspan="2">
                        <p class="header-text">Let's Get Started</p>
                        <p class="sub-text">Add Your Personal Details to Continue</p>
                    </td>
                </tr>
                <form action="./controllers/register.php" method="POST">
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="Fname" class="form-label">Name: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td">
                            <input type="text" name="Fname" class="input-text" placeholder="First Name" required>
                        </td>
                        <td class="label-td">
                            <input type="text" name="Lname" class="input-text" placeholder="Last Name" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="address" class="form-label">Address: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="text" name="address" class="input-text" placeholder="Address" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="UserName" class="form-label">Email: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="email" name="UserName" class="input-text" placeholder="Email Address" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="contact" class="form-label">Contact No:</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="tel" name="contact" class="input-text" placeholder="Contact No." required
                                pattern="09[0-9]{9}" maxlength="11"
                                title="Please enter an 11-digit number starting with '09'">
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="user_pass" class="form-label">Create New Password: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="password" name="user_pass" class="input-text" placeholder="New Password"
                                required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="ConfPassword" class="form-label">Confirm Password: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="password" name="ConfPassword" class="input-text" placeholder="Confirm Password"
                                required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="birthday" class="form-label">Date of Birth: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="date" name="birthday" class="input-text" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2"></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="reset" value="Clear" class="login-btn btn-primary-soft btn">
                        </td>
                        <td>
                            <input type="submit" name="submit" value="Next" class="login-btn btn-primary btn">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br>
                            <label class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                            <a href="login.php" class="hover-link1 non-style-link">Login</a>
                            <br><br><br>
                        </td>
                    </tr>
                </form>
            </table>
        </div>

    </center>
</body>

</html>