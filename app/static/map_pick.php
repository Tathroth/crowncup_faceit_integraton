<?php
    include('../functions.php');

    $data = getStoredMapPool();
    $current = getStaticData('mappick');
    $newest_map = end($current);
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
    <div class="current_map_wrapper">
        <div class="current_map">
            <?php if ($data) : ?>
                <?php foreach ($data as $category => $maps) : ?>
                    <?php foreach ($maps as $map) : ?>
                        <?php if ($map['id'] == $newest_map['id']) : ?>
                            <div class="current_map--content">
                                <h2><?= $map['name'] ?></h2>
                                <h3><?= $category ?></h3>
                            </div>
                            <img src="/assets/maps/<?= $map['image'] ?>" alt="<?= $map['name'] ?>">
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <h1>No map selected yet</h1>
            <?php endif; ?>
        </div>
        <div class="current_map_wrapper--tagline">
            <h2>Current map</h2>
        </div>
        <img class="current_map_wrapper--logo" src="/../assets/cc_logo_v2.png" alt="Crown Cup Logo">
    </div>  
</body>
</html>