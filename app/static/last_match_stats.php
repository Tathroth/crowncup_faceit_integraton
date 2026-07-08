<?php
    include('../functions.php');

    $map_data = getLastMapData();

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
    <title>Team comparison card</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>

    <div class="card_wrapper">
        <div class="card_content">
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
                                    <th>Heroes played</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($team['players'] as $player) : ?>
                                    <?php
                                        $hero_array = explode(';', $player['heroes']);
                                    ?>
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
                                        <td>
                                            <?php foreach ($hero_array as $hero) :?>
                                                <?php
                                                    $hero_lookup_key = strtolower(trim($hero ?? ''));

                                                    $hero_lookup_key = transliterator_transliterate(
                                                        'Any-Latin; Latin-ASCII',
                                                        $hero_lookup_key
                                                    );

                                                    $hero_str = $heroes_by_name[$hero_lookup_key] ?? null;
                                                 ?>
                                                <img class="hero_icon" src="/../assets/heroes/thumbnails/<?= $hero_str['image']; ?>" alt="">
                                            <?php endforeach; ?>
                                        </td>
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
        .card_content {
            width: 115rem;
            text-align: left;
            padding: 1rem 2rem 5rem 2rem;
        }

        .card_content h2 {
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .card_team {
            width: 100%;
            padding: 0.5rem 0rem
        }

        .card_team th {
            font-size: 1rem;
        }

        .card_team td {
            font-size: 0.9rem;
        }

        .role_icon_compare_icon {
            height: 100%;
        }

        .card_team--logo {
            height: 5rem;
            width: 100%;
        }

        .hero_icon {
            height: 2rem;
            width: 2rem;
        }
    </style>
</body>
</html>