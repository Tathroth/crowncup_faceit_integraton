<?php
    include('../functions.php');

    if (!isLoggedIn()) {
        header('Location: login.php?error=true');
        exit;
    }

    $data = getStoredMapPool();
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
        <h1>Select current map</h1>
        <p>Select current map. It will update the map picks static card too.</p>
        <hr>
        <form action="/staticstore.php" method="post">
            <p>Reset the map picks for next match</p>
            <input type="hidden" name="type" value="resetmappicks">
            <button type="submit">Reset map picks</button>
        </form>
        <hr>
        <form action="/staticstore.php" method="post">
            <h2>Select map</h2>
            <input type="hidden" name="type" value="mappick">
            <?php if ($data) : ?>
                <?php foreach ($data as $category => $maps) : ?>
                    <h2><?= $category; ?></h2>
                    <ul class="no_list_style">
                        <?php foreach ($maps as $map) : ?>
                            <li>
                                <label>
                                    <input type="radio" name="map" value="<?= $map['id']; ?>"><?= $map['name']; ?>
                                </label>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            <?php endif; ?>
            <button type="submit">Store current map pick</button>
        </form>
        
    </div>
    <?php include(__DIR__ .'/../partials/footer.php'); ?>
</body>
</html>