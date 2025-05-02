<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
    <section class="section">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-4">
                    <div class="box">
                        <h1 class="title is-4 has-text-centered">Admin Login</h1>
                        <?php if ($error): ?>
                            <div class="notification is-danger is-light">
                                <?= $error ?>
                            </div>
                        <?php endif; ?>
                        <form action="controller/login.php" method="POST">
                            <div class="field">
                                <label class="label">Username</label>
                                <div class="control">
                                    <input class="input" type="text" name="username" required autofocus>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Password</label>
                                <div class="control">
                                    <input class="input" type="password" name="password" required>
                                </div>
                            </div>
                            <div class="field mt-5">
                                <button class="button is-primary is-fullwidth" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
