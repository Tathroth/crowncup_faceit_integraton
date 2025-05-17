<?php
    include('../functions.php');

    // Use get request to define match id, and get data
    $match_data = array();
    $round_data = array();

    if (isset($_GET['match_id'])) {
        $match_id = $_GET['match_id'];

        $match_data = getFaceitData('matches/'.$match_id);
        $round_data = getFaceitData('matches/'.$match_id.'/stats');
    }

    $team_stats = array();
    $rounds = 0;

    $player_names = array();
    $player_roles = array();

    if (isset($match_data['teams'])) {
        $faction_1_id = $match_data['teams']['faction1']['faction_id'];
        $faction_2_id = $match_data['teams']['faction2']['faction_id'];

        if (isset($round_data['rounds'])) {
            foreach ($round_data['rounds'] as $key => $round) {
                $rounds++;

                foreach ($round['teams'] as $team) {
                    if ($team['team_id'] == $faction_1_id) {
                        $player_id = $_GET['player']['faction1'];
                    } else {
                        $player_id = $_GET['player']['faction2'];
                    }
                    foreach ($team['players'] as $player) {
                        if ($player['player_id'] == $player_id) {
                            if ($team['team_id'] == $faction_1_id) {
                                $player_names['faction1'] = $player['nickname'];
                                $player_roles['faction1'] = $player['player_stats']['Role'];
                                $team_stats['faction1']['kills'][] = floatval($player['player_stats']['Final Blows/10m']);
                                $team_stats['faction1']['deaths'][] = floatval($player['player_stats']['Deaths/10m']);
                                $team_stats['faction1']['eliminations'][] = floatval($player['player_stats']['Eliminations']);
                                $team_stats['faction1']['player_stats']['damage'][] = floatval($player['player_stats']['Damage Dealt/10m']);
                                $team_stats['faction1']['player_stats']['healing'][] = floatval($player['player_stats']['Healing Done/10m']);
                            } else {
                                $player_names['faction2'] = $player['nickname'];
                                $player_roles['faction2'] = $player['player_stats']['Role'];
                                $team_stats['faction2']['kills'][] = floatval($player['player_stats']['Final Blows/10m']);
                                $team_stats['faction2']['deaths'][] = floatval($player['player_stats']['Deaths/10m']);
                                $team_stats['faction2']['eliminations'][] = floatval($player['player_stats']['Eliminations']);
                                $team_stats['faction2']['player_stats']['damage'][] = floatval($player['player_stats']['Damage Dealt/10m']);
                                $team_stats['faction2']['player_stats']['healing'][] = floatval($player['player_stats']['Healing Done/10m']);
                            }
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
        foreach ($team_stats as $faction => $team_stat) {
            $team_average_stats[$faction]['kills'] = array_sum($team_stat['kills']) / $rounds;
            $team_average_stats[$faction]['deaths'] = array_sum($team_stat['deaths']) / $rounds;
            $team_average_stats[$faction]['eliminations'] = array_sum($team_stat['eliminations']);
            $team_average_stats[$faction]['damage'] = array_sum($team_stat['player_stats']['damage']) / $rounds;
            $team_average_stats[$faction]['healing'] = array_sum($team_stat['player_stats']['healing']) / $rounds;
        }
    }
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
                <h1><?= $match_data['competition_name'] ?></h1>
                <?php
                    ksort($match_data['teams']);
                    foreach ($match_data['teams'] as $faction => $team) :
                ?>
                    <div class="card_team">
                        <div class="card_team--logo">
                            <?php
                                $player_role = '';
                                if ($player_roles) {
                                    $player_role = $player_roles['faction2'];
                                }

                                $role_icon_src = '';

                                if ($player_role != '') {
                                    $role_icon_src = 'support.png';
                                    if ($player_role == 'Damage') {
                                        $role_icon_src = 'damage.png';
                                    } elseif ($player_role == 'Tank') {
                                        $role_icon_src = 'tank.png';
                                    }
                                }
                            ?>
                            <h2 class="player_name_title">
                                <?php if ($role_icon_src != '') : ?>
                                    <img class="role_icon_compare_icon" src="/../assets/icons/<?= $role_icon_src; ?>">
                                <?php endif; ?>
                                <?= $player_names[$faction]; ?>
                            </h2>
                            <h3><?= $team['name']; ?></h3>
                        </div>
                        <div class="card_team--stats">
                            <?php if ($team_average_stats) : ?>
                                <?php $current_team = $team_average_stats[$faction]; ?>
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
                <?php endforeach; ?>
            <?php else : ?>
                <h1>404 - No match data</h1>
            <?php endif; ?>
            <img class="card_logo" src="/../assets/cc_logo_v2.png" alt="Crown Cup Logo">
        </div>
    </div>
</body>
</html>