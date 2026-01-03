<?php
    include(__DIR__.'/functions.php');

    $heroes = getHeroData();

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
        <h1>Hero list</h1>
        <?php if ($heroes) : ?>
            <div class="matches">
                <?php foreach ($heroes as $hero) : ?>
                    <div class="matches--match matches--match__small">
                        <img src="/assets/heroes/<?= $hero['image']; ?>" alt="">
                        <h2><?= $hero['name']; ?></h2>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php include(__DIR__ .'/partials/footer.php'); ?>
</body>
</html>