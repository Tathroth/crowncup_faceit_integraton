<?php
    include('functions.php');

    if (!isLoggedIn()) {
        header('Location: login.php?error=true');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crown Cup - Upload stats</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>
    <?php include(__DIR__ .'/partials/menu.php'); ?>
    <div class="wrapper"> 
        <h1>Upload OW log file</h1>
        <p>Should be found in C:\Users\[userpath]\Documents\Overwatch\Workshop</p>
        <p>Must be created with the workshop code RBXRX</p>
        <p>Options->Gameplay->Enable Inspector Log File in your settings must be enabled to generate log file.</p>
        <form action="handle_stat_upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload">
            <br>
            <input type="submit" value="Upload log file" name="submit">
        </form>
    </div>
    <?php include(__DIR__ .'/partials/footer.php'); ?>
</body>
</html>