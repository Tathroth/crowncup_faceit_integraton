<?php
    include('../functions.php');

    $map_data = getLastMapData();
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
            <h1>Map statistics</h1>
            <?php if ($map_data) : ?>
                <?php foreach ($map_data as $team) : ?>
                    <div class="card_team">
                        <div class="card_team--logo">
                            <img class="role_icon_compare_icon" src="<?= $team['team_name']['logo']; ?>"> 
                        </div>
                        <h2><?= $team['team_name']['name']; ?></h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Player</th>
                                    <th>Eliminations</th>
                                    <th>Final Blows</th>
                                    <th>Deaths</th>
                                    <th>Damage</th>
                                    <th>Healing</th>
                                    <th>Healing recived</th>
                                    <th>Ults used</th>
                                    <th>Emotes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($team['players'] as $player) : ?>
                                    <tr>
                                        <td><?= $player['name']; ?></td>
                                        <td><?= $player['eliminations']; ?></td>
                                        <td><?= $player['final_blows']; ?></td>
                                        <td><?= $player['deaths']; ?></td>
                                        <td><?= floor($player['damage']); ?></td>
                                        <td><?= floor($player['healing']); ?></td>
                                        <td><?= floor($player['healing_recieved']); ?></td>
                                        <td><?= $player['ultimates']; ?></td>
                                        <td><?= $player['emotes']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <img class="card_logo" src="/../assets/cc_logo_v2.png" alt="Crown Cup Logo">
        </div>
    </div>
    <style>
        .card_content h1 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .card_content {
            width: 115rem;
            text-align: left;
        }

        .card_team {
            width: calc(50% - 4rem);
            padding: 1rem 2rem;
        }

        .role_icon_compare_icon {
            height: 100%;
        }

        .card_team--logo {
            height: 5rem;
            width: 100%;
        }
    </style>
</body>
</html>