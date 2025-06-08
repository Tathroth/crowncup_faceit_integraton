<?php
    include('../functions.php');

    $match_data = getStaticData('herobans');
?>
<!DOCTYPE html>
<html lang="en" class="cards_html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hero ban card</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>
    <div class="card_wrapper">
        <div class="card_content">
            <?php if ($match_data) : ?>
                <h1>Hero bans</h1>
                <?php foreach ($match_data['heroes'] as $key => $hero) : ?>
                    <div class="card_team hero_bans">
                        <div class="card_team--logo">
                            <h2><?= $match_data['teams'][$key]; ?></h2>
                        </div>
                        <div class="hero_bans--hero">
                            <?php if (isset($hero)) : ?>
                                <img src="/../assets/heroes/<?= $hero['img'] ?>">
                                <h3><?= $hero['name']; ?></h3>
                            <?php else : ?>
                                No ban
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <h1>404 - No match data</h1>
            <?php endif; ?>
            <img class="card_logo" src="/../assets/cc_logo_v2.png" alt="Crown Cup Logo">
        </div>
    </div>
</body>
</html>