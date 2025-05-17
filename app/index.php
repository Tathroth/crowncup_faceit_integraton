<?php
    include('functions.php');
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
        <h1>Crown Cup</h1>
        <p>This site is made to get match stats and data for Crown Cup tournaments run through FaceIT</p>
        <p>
            <a href="/tournament.php">Crown Cup tournaments</a>  
        </p>
    </div>
    <?php include(__DIR__ .'/partials/footer.php'); ?>
</body>
</html>