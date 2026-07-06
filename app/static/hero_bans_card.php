<?php
    include('../functions.php');

    $current_match_data = getStaticData('setcurrentmatch');

    if (!$current_match_data) {
        echo 'No current match set';
        die();
    }

    $teams = $current_match_data;

    uasort($teams, function ($a, $b) {
        $a_side = (int) ($a['side'] ?? 999);
        $b_side = (int) ($b['side'] ?? 999);

        return $a_side <=> $b_side;
    });

    $heroes_by_name = array();
    $heroes = getHeroData();

    foreach ($heroes as $hero) {
        if (!empty($hero['name'])) {
            $heroes_by_name[strtolower(trim($hero['name']))] = $hero;
        }
    }
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
    <?php
        $team_data = array();
        $counter = 0;
        foreach ($teams as $team) {
            $hero_lookup_key = strtolower(trim($team['ban'] ?? ''));
            $hero = $heroes_by_name[$hero_lookup_key] ?? null;

            $team_data[$counter] = array(
                'name' => $team['name'],
                'ban' => $hero['image'],
                'hero' => $team['ban']
            );

            $counter++;
        }
    ?>
    <div class="card_wrapper">
        <div class="card_content">
            <?php if ($team_data) : ?>
                <h1>Hero bans</h1>

                    <div class="card_team hero_bans">
                        <div class="card_team--logo">
                            <h2><?= $team_data[0]['name']; ?></h2>
                        </div>
                        <div class="hero_bans--hero">
                            <img src="/../assets/heroes/<?= $team_data[0]['ban']; ?>">
                            <h3><?= $team_data[0]['hero']; ?></h3>
                        </div>
                    </div>

                    <div class="card_team hero_bans">
                        <div class="card_team--logo">
                            <h2><?= $team_data[1]['name']; ?></h2>
                        </div>
                        <div class="hero_bans--hero">
                            <img src="/../assets/heroes/<?= $team_data[1]['ban']; ?>">
                            <h3><?= $team_data[1]['hero']; ?></h3>
                        </div>
                    </div>

                <?php endif; ?>
            <img class="card_logo" src="/../assets/cc_logo_v2.png" alt="Crown Cup Logo">
        </div>
    </div>
</body>
</html>