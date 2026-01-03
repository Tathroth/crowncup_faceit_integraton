<?php
    include(__DIR__.'/functions.php');

    $all_maps = getAllMapData();
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
    <div class="pool_wrapper list_version">
        <div class="pool_content">
            <?php if ($all_maps) : ?>
                <?php foreach ($all_maps as $category => $maps) : ?>
                    <?php
                        if ($category == 'Clash') {
                            continue;
                        }
                    ?>
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
                <h1>No map list stored</h1>
            <?php endif; ?>
        </div>
        <img class="pool_wrapper--logo" src="/../assets/cc_logo_v2.png" alt="Crown Cup Logo">
    </div>  
</body>
</html>