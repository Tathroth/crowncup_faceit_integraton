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

    $player_name = '';
    $player_role = '';

    if (isset($match_data['teams'])) {
        $team_name_1 = $match_data['teams']['faction1']['name'];
        $team_name_2 = $match_data['teams']['faction2']['name'];

        if (isset($round_data['rounds'])) {
            foreach ($round_data['rounds'] as $key => $round) {
                $rounds++;

                foreach ($round['teams'] as $team) {
                    $player_id = $_GET['player'];
                    foreach ($team['players'] as $player) {
                        if ($player['player_id'] == $player_id) {
                            $player_name = $player['nickname'];
                            $player_role = $player['player_stats']['Role'];
                            $team_stats['kills'][] = floatval($player['player_stats']['Final Blows/10m']);
                            $team_stats['deaths'][] = floatval($player['player_stats']['Deaths/10m']);
                            $team_stats['eliminations'][] = floatval($player['player_stats']['Eliminations']);
                            $team_stats['player_stats']['damage'][] = floatval($player['player_stats']['Damage Dealt/10m']);
                            $team_stats['player_stats']['healing'][] = floatval($player['player_stats']['Healing Done/10m']);
                            break;
                        } else {
                            continue;
                        }
                    }
                }
            }
        }
    }

    $team_average_stats = array();

    if ($team_stats) {
        $team_stat = $team_stats;
        $team_average_stats['kills'] = array_sum($team_stat['kills']) / $rounds;
        $team_average_stats['deaths'] = array_sum($team_stat['deaths']) / $rounds;
        $team_average_stats['eliminations'] = array_sum($team_stat['eliminations']);
        $team_average_stats['damage'] = array_sum($team_stat['player_stats']['damage']) / $rounds;
        $team_average_stats['healing'] = array_sum($team_stat['player_stats']['healing']) / $rounds;
    }
?>
<!DOCTYPE html>
<html lang="en" class="cards_html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVP card</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>
    <div class="card_wrapper">
        <div class="card_content">
            <?php if ($match_data && isset($match_data['teams'])) : ?>
                <h1>Match MVP</h1>
                <h2><?= $match_data['competition_name'] ?></h2>
                <?php $store_data['competition_name'] = $match_data['competition_name']; ?>
                <h3><?= $team_name_1; ?> vs <?= $team_name_2; ?></h3>
                <?php $store_data['teams'] = $team_name_1.' vs '.$team_name_2; ?>
                <div class="card_team role_icon_card">
                    <div class="card_team--stats">
                        <?php
                            $role_icon_src = 'support.png';
                            if ($player_role == 'Damage') {
                                $role_icon_src = 'damage.png';
                            } elseif ($player_role == 'Tank') {
                                $role_icon_src = 'tank.png';
                            }
                            $store_data['role']['name'] = $player_role;
                            $store_data['role']['icon'] = $role_icon_src;
                        ?>
                        <img class="role_icon_image" src="/../assets/icons/<?= $role_icon_src; ?>">
                        <h2 class="player_name_title"><?= $player_name; ?></h2>
                        <?php $store_data['player_name'] = $player_name; ?>
                    </div>
                </div>
                <div class="card_team">
                    <div class="card_team--stats">
                        <?php if ($team_average_stats) : ?>
                            <?php
                                $current_team = $team_average_stats;
                                $store_data['stats'] = $current_team;
                            ?>
                            <ul>
                                <li>
                                    <img src="/../assets/eleminations.png" class="icon_elims" alt="">
                                    <span class="card_team--stats--label">Eliminations</span>
                                    <span class="card_team--stats--stat"><?= number_format($current_team['eliminations']); ?></span>
                                </li>
                                <li>
                                    <img src="/../assets/final_blows.png" alt="">
                                    <span class="card_team--stats--label">Final Blows/10m</span>
                                    <span class="card_team--stats--stat"><?= number_format($current_team['kills'], 2); ?></span>
                                </li>
                                <li>
                                    <img src="/../assets/deaths.png" alt="">
                                    <span class="card_team--stats--label">Deaths/10m</span>
                                    <span class="card_team--stats--stat"><?= number_format($current_team['deaths'], 2); ?></span>
                                </li>
                                <li>
                                    <img src="/../assets/damage.png" alt="">
                                    <span class="card_team--stats--label">Damage Dealt/10m</span>
                                    <span class="card_team--stats--stat"><?= number_format($current_team['damage'], 2); ?></span>
                                </li>
                                <li>
                                    <img src="/../assets/healing.png" alt="">
                                    <span class="card_team--stats--label">Healing Done/10m</span>
                                    <span class="card_team--stats--stat"><?= number_format($current_team['healing'], 2); ?></span>
                                </li>
                            </ul>
                        <?php else : ?>
                            <p>Match data not available</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else : ?>
                <h1>404 - No match data</h1>
            <?php endif; ?>
            <img class="card_logo" src="/../assets/cc_logo_v2.png" alt="Crown Cup Logo">
        </div>
        <?php if (isLoggedIn() && $store_data) : ?>
            <div class="card_store_button">
                <form action="/staticstore.php" method="post">
                    <input type="hidden" name="type" value="mvpcard">
                    <input type="hidden" name="data" value='<?= htmlspecialchars(json_encode($store_data), ENT_QUOTES, 'UTF-8') ?>'>
                    <button type="submit">Store to static mvp card</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>