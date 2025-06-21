<?php
    include('../functions.php');

    if (!isLoggedIn()) {
        header('Location: login.php?error=true');
        exit;
    }

    $data = getAllMapData();
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
    <?php include(__DIR__ .'/../partials/menu.php'); ?>
    <div class="wrapper"> 
        <h1>Store map pool</h1>
        <p>Select maps to store as a static map pool used for map picks.</p>
        <form action="/staticstore.php" method="post" >
            <input type="hidden" name="type" value="mappool">
            <?php if ($data) : ?>
                <?php foreach ($data as $category => $maps) : ?>
                    <h2><?= $category; ?></h2>
                    <ul class="no_list_style">
                        <?php foreach ($maps as $map) : ?>
                            <li><label><input type="checkbox" name="map[]" value="<?= $map['id']; ?>"><?= $map['name']; ?></label></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            <?php endif; ?>
            <button type="submit">Store map pool</button>
        </form>
        
    </div>
    <?php include(__DIR__ .'/../partials/footer.php'); ?>
</body>
</html>