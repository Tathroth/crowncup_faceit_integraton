<?php
    include('../functions.php');

    $match_data = getStaticData('playercompare');
?>
<!DOCTYPE html>
<html lang="en" class="cards_html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Players comparison card</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>

    <div class="card_wrapper">
        <div class="card_content">
            <?php if ($match_data) : ?>
                <h1><?= $match_data['competition_name']; ?></h1>
                <?php foreach ($match_data['stats'] as $key => $stats) : ?>
                    <div class="card_team">
                        <div class="card_team--logo">
                            <h2 class="player_name_title">
                                <img class="role_icon_compare_icon" src="/../assets/icons/<?= $match_data['role'][$key]['icon']; ?>">
                                <?= $match_data['player_name'][$key]; ?>
                            </h2>
                            <h3><?= $match_data['team_name'][$key]; ?></h3>
                        </div>
                        <div class="card_team--stats">
                            <?php if ($stats) : ?>
                                <ul>
                                    <li>
                                        <img src="/../assets/eleminations.png" class="icon_elims" alt="">
                                        <span class="card_team--stats--label">Eliminations</span>
                                        <span class="card_team--stats--stat"><?= number_format($stats['eliminations']); ?></span>
                                    </li>
                                    <li>
                                        <img src="/../assets/final_blows.png" alt="">
                                        <span class="card_team--stats--label">Final Blows/10m</span>
                                        <span class="card_team--stats--stat"><?= number_format($stats['kills'], 2); ?></span>
                                    </li>
                                    <li>
                                        <img src="/../assets/deaths.png" alt="">
                                        <span class="card_team--stats--label">Deaths/10m</span>
                                        <span class="card_team--stats--stat"><?= number_format($stats['deaths'], 2); ?></span>
                                    </li>
                                    <li>
                                        <img src="/../assets/damage.png" alt="">
                                        <span class="card_team--stats--label">Damage Dealt/10m</span>
                                        <span class="card_team--stats--stat"><?= number_format($stats['damage'], 2); ?></span>
                                    </li>
                                    <li>
                                        <img src="/../assets/healing.png" alt="">
                                        <span class="card_team--stats--label">Healing Done/10m</span>
                                        <span class="card_team--stats--stat"><?= number_format($stats['healing'], 2); ?></span>
                                    </li>
                                </ul>
                            <?php else : ?>
                                <p>Match data not available</p>
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