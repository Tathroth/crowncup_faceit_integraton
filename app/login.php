<?php
    include('functions.php');

    if (isLoggedIn()) {
        header('Location: dashboard.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crown Cup</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>
    <?php include(__DIR__ .'/partials/menu.php'); ?>
    <div class="wrapper">
        <form class="login" action="authenticate.php" method="get">
            <h1>Production login</h1>
            Username: <input type="text" name="username" required><br>
            Password: <input type="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>
        <?php if (isset($_GET['error'])): ?>
            <p style="color:red;">Invalid login credentials.</p>
        <?php endif; ?>
    </div>
    <?php include(__DIR__ .'/partials/footer.php'); ?>
</body>
</html>