<?php
    include('../functions.php');

    // Use get request to define match id, and get data
    $match_data = array();

    if (isset($_GET['match_id'])) {
        $match_id = $_GET['match_id'];

        $match_data = getFaceitData('matches/'.$match_id);
    }

    $ban_arr = array();

    $hero_data = getHeroData();

    if (isset($_GET['ban_faction1']) && isset($_GET['ban_faction2'])) {
        $ban1 = $_GET['ban_faction1'];
        $ban2 = $_GET['ban_faction2'];

        if ($hero_data) {
            foreach ($hero_data as $hero) {
                if ($hero['name'] == $ban1) {
                    $ban_arr['faction1'] = $hero;
                }
                if ($hero['name'] == $ban2) {
                    $ban_arr['faction2'] = $hero;
                }
            }
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

    <div class="card_wrapper">
        <div class="card_content">
            <?php if ($match_data) : ?>
                <?php // $match_data['competition_name'] ?>
                <h1>Hero bans</h1>
                <?php
                    ksort($match_data['teams']);
                    foreach ($match_data['teams'] as $faction => $team) :
                ?>
                    <div class="card_team hero_bans">
                        <div class="card_team--logo">
                            <h2><?= $team['name']; ?></h2>
                        </div>
                        <div class="hero_bans--hero">
                            <?php if (isset($ban_arr[$faction])) : ?>
                                <img src="/../assets/heroes/<?= $ban_arr[$faction]['image'] ?>">
                                <h3><?= $ban_arr[$faction]['name'] ?></h3>
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