<?php
    include('../functions.php');

    // Use get request to define match id, and get data
    $match_data = array();
    $round_data = array();
    $store_data = array();

    if (isset($_GET['match_id'])) {
        $match_id = $_GET['match_id'];

        $match_data = getFaceitData('matches/'.$match_id);
        $round_data = getFaceitData('matches/'.$match_id.'/stats');
    }

    $team_stats = array();
    $rounds = 0;

    if (isset($match_data['teams'])) {
        $faction_1_id = $match_data['teams']['faction1']['faction_id'];
        $faction_2_id = $match_data['teams']['faction2']['faction_id'];

        if (isset($round_data['rounds'])) {
            foreach ($round_data['rounds'] as $key => $round) {
                $rounds++;

                foreach ($round['teams'] as $team) {
                    if ($team['team_id'] == $faction_1_id) {
                        $team_stats['faction1']['kills'][] = floatval($team['team_stats']['Total Team Final Blows']);
                        $team_stats['faction1']['deaths'][] = floatval($team['team_stats']['Team Total Deaths']);
                        $team_stats['faction1']['eliminations'][] = floatval($team['team_stats']['Team Avg Eliminations']);
                    } else {
                        $team_stats['faction2']['kills'][] = floatval($team['team_stats']['Total Team Final Blows']);
                        $team_stats['faction2']['deaths'][] = floatval($team['team_stats']['Team Total Deaths']);
                        $team_stats['faction2']['eliminations'][] = floatval($team['team_stats']['Team Avg Eliminations']);
                    }
                    foreach ($team['players'] as $player) {
                        if ($team['team_id'] == $faction_1_id) {
                            $team_stats['faction1']['player_stats']['damage'][] = floatval($player['player_stats']['Damage Dealt']);
                            $team_stats['faction1']['player_stats']['healing'][] = floatval($player['player_stats']['Healing Done']);
                        } else {
                            $team_stats['faction2']['player_stats']['damage'][] = floatval($player['player_stats']['Damage Dealt']);
                            $team_stats['faction2']['player_stats']['healing'][] = floatval($player['player_stats']['Healing Done']);
                        }
                    }
                }
            }
        }
    }

    $team_average_stats = array();

    if ($team_stats) {
        foreach ($team_stats as $faction => $team_stat) {
            $team_average_stats[$faction]['kills'] = array_sum($team_stat['kills']) / $rounds;
            $team_average_stats[$faction]['deaths'] = array_sum($team_stat['deaths']) / $rounds;
            $team_average_stats[$faction]['eliminations'] = array_sum($team_stat['eliminations']) / $rounds;
            $team_average_stats[$faction]['damage'] = (array_sum($team_stat['player_stats']['damage']) / 5) / $rounds;
            $team_average_stats[$faction]['healing'] = (array_sum($team_stat['player_stats']['healing']) / 5) / $rounds;
        }
    }
?>
<!DOCTYPE html>
<html lang="en" class="cards_html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team comparison card</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>

    <div class="card_wrapper">
        <div class="card_content">
            <?php if ($match_data) : ?>
                <h1><?= $match_data['competition_name'] ?></h1>
                <?php $store_data['competition_name'] = $match_data['competition_name']; ?>
                <?php
                    ksort($match_data['teams']);
                    foreach ($match_data['teams'] as $faction => $team) :
                ?>
                    <div class="card_team">
                        <div class="card_team--logo">
                            <h2><?= $team['name']; ?></h2>
                            <?php $store_data['team_name'][] = $team['name']; ?>
                        </div>
                        <div class="card_team--stats">
                            <?php if ($team_average_stats) : ?>
                                <?php
                                    $current_team = $team_average_stats[$faction];
                                    $store_data['stats'][] = $current_team;
                                ?>
                                <ul>
                                    <li>
                                        <img src="/../assets/eleminations.png" class="icon_elims" alt="">
                                        <span class="card_team--stats--label">Avg. eliminations</span>
                                        <span class="card_team--stats--stat"><?= number_format($current_team['eliminations'], 2); ?></span>
                                    </li>
                                    <li>
                                        <img src="/../assets/final_blows.png" alt="">
                                        <span class="card_team--stats--label">Avg. final blows</span>
                                        <span class="card_team--stats--stat"><?= number_format($current_team['kills'], 2); ?></span>
                                    </li>
                                    <li>
                                        <img src="/../assets/deaths.png" alt="">
                                        <span class="card_team--stats--label">Avg. deaths</span>
                                        <span class="card_team--stats--stat"><?= number_format($current_team['deaths'], 2); ?></span>
                                    </li>
                                    <li>
                                        <img src="/../assets/damage.png" alt="">
                                        <span class="card_team--stats--label">Avg. damage</span>
                                        <span class="card_team--stats--stat"><?= number_format($current_team['damage'], 2); ?></span>
                                    </li>
                                    <li>
                                        <img src="/../assets/healing.png" alt="">
                                        <span class="card_team--stats--label">Avg. healing</span>
                                        <span class="card_team--stats--stat"><?= number_format($current_team['healing'], 2); ?></span>
                                    </li>
                                </ul>
                            <?php else : ?>
                                <p>Match data not available</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="card_content--stats">
                    <?= $match_data['results']['score']['faction1']; ?> - <?= $match_data['results']['score']['faction2']; ?>
                    <?php $store_data['score'] = $match_data['results']['score']['faction1'].' - '.$match_data['results']['score']['faction2']; ?>
                    <?php // <br> <b>Winner:</b> <?= $match_data['teams'][$match_data['results']['winner']]['name']; ?>
                </div>
            <?php else : ?>
                <h1>404 - No match data</h1>
            <?php endif; ?>
            <img class="card_logo" src="/../assets/cc_logo_v2.png" alt="Crown Cup Logo">
        </div>
        <?php if (isLoggedIn() && $store_data) : ?>
            <div class="card_store_button">
                <form action="/staticstore.php" method="post">
                    <input type="hidden" name="type" value="teamscompare">
                    <input type="hidden" name="data" value='<?= htmlspecialchars(json_encode($store_data), ENT_QUOTES, 'UTF-8') ?>'>
                    <button type="submit">Store to static team compare card</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>