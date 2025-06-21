<?php
    include('../functions.php');

    $data = getStoredMapPool();
?>
<!DOCTYPE html>
<html lang="en" class="cards_html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crown Cup</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>
    <div class="pool_wrapper">
        <div class="pool_content">
            <?php if ($data) : ?>
                <?php foreach ($data as $category => $maps) : ?>
                    <div class="pool_content--type">
                        <h2><?= $category ?></h2>
                        <?php foreach ($maps as $map) : ?>
                            <div class="pool_content--type--item">
                                <img src="/assets/maps/<?= $map['image'] ?>" alt="<?= $map['name'] ?>">
                                <div class="pool_content--type--item--content">
                                    <h3><?= $map['name'] ?></h3>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <h1>No map pool stored</h1>
            <?php endif; ?>
        </div>
        <div class="pool_wrapper--tagline">
            <h2>Map pool</h2>
        </div>
        <img class="pool_wrapper--logo" src="/../assets/cc_logo_v2.png" alt="Crown Cup Logo">
    </div>  
</body>
</html>