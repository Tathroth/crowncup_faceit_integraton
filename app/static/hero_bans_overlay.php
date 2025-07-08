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
    <div class="bans_overlay_wrap">
        <div class="bans_overlay_wrap__content">
            <?php if ($match_data) : ?>
                <?php foreach ($match_data['heroes'] as $key => $hero) : ?>
                    <div class="bans_overlay_wrap__content--team">
                        <div class="bans_overlay_wrap__content--team--name">
                                <h2><?= $match_data['teams'][$key]; ?></h2>
                        </div>
                        <div class="bans_overlay_wrap__content--team--hero">
                            <img src="/../assets/heroes/thumbnails/<?= $hero['img'] ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <h1>404 - No match data</h1>
            <?php endif; ?>
            <div class="bans_overlay_wrap__content--footer">
                <img class="bans_overlay_wrap__content--footer--logo" src="/../assets/cc_logo_v2.png" alt="Crown Cup Logo">
                <h2>Hero bans</h2>
            </div>
        </div>
    </div>
</body>
</html>