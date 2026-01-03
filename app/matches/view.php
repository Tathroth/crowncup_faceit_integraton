<?php
    include('../functions.php');

    // Use get request to define match id, and get data
    $match_data = array();
    $round_data = array();

    if (isset($_GET['match_id'])) {
        $match_id = $_GET['match_id'];

        $match_data = getFaceitData('matches/'.$match_id);
        $round_data = getFaceitData('matches/'.$match_id.'/stats');
    } else {
        echo 'No match id';
        die();
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match data</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>
    <?php include(__DIR__ .'/../partials/menu.php'); ?>
    <div class="wrapper"> 
        <?php if ($match_data) : ?>
            <h1><?= $match_data['teams']['faction1']['name']; ?> vs <?= $match_data['teams']['faction2']['name']; ?></h1>
            <h2><?= $match_data['competition_name'] ?></h2>
            <?php if (isset($match_data['results'])) : ?>
                <?= $match_data['results']['score']['faction1']; ?> - <?= $match_data['results']['score']['faction2']; ?><br>
                <?php if (isset($match_data['teams'][$match_data['results']['winner']]['name'])) : ?>
                    <b>Winner:</b> <?= $match_data['teams'][$match_data['results']['winner']]['name']; ?>
                <?php endif; ?>
                <p><a href="/cards/match_teams.php?match_id=<?= $match_id; ?>">Match card</a></p>
            <?php else : ?>
                <p>No results yet</p>
            <?php endif; ?>
            <?php if (isset($match_data['demo_url']) && $match_data['demo_url']) : ?>
                <h3>VOD Codes</h3>
                <ul>
                    <?php foreach ($match_data['demo_url'] as $vod_code) : ?>
                        <li><?= $vod_code; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <p><a href="/matches/hero_bans.php?match_id=<?= $match_id; ?>">Create hero ban cards</a></p>
            <?php if (isset($match_data['teams'])) : ?>
                <h2>Teams</h2>
                <form action="/cards/match_players.php" action="get">
                    <div class="teams">
                        <?php ksort($match_data['teams']); ?>
                        <?php foreach ($match_data['teams'] as $faction => $team) : ?>
                            <div class="teams--team">
                                <?php /* <img src="<?= $team['avatar'] ?>" alt=""> */ ?>
                                <h3><?= $team['name']; ?></h3>
                                <?php if (isset($team['roster'])) : ?>
                                    <h3>Roster</h3>
                                    <div class="roster">
                                        <?php foreach ($team['roster'] as $player) : ?>
                                            <div class="roster--item">
                                                <label>
                                                    <?php /*  <img src="<?= $player['avatar']; ?>" alt=""> */ ?>
                                                    <h4 class="player_name_title"><?= $player['nickname']; ?></h4>
                                                    <b>In game name <?= $player['game_player_name']; ?></b>
                                                    <input type="radio" name="player[<?= $faction; ?>]" value="<?= $player['player_id']; ?>">
                                                    <a
                                                        href="/cards/mvp_card.php?player=<?= $player['player_id']; ?>&match_id=<?= $match_id; ?>"
                                                        target="_blank"
                                                    >Player MVP card</a>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="match_id" value="<?= $match_id; ?>" />
                    <input type="submit" value="Compare players" />
                </form>
            <?php endif; ?>
        <?php else : ?>
            
            <pre>
                <?php var_dump($match_data); ?>
            </pre>
        <?php endif; ?>
        <?php if (isset($round_data['rounds'])) : ?>
            <h2>Match rounds</h2>
            <?php foreach ($round_data['rounds'] as $round) : ?>
                <h3>Round <?= $round['match_round']; ?></h3>
                <?php if (isset($round['round_stats']) && $round['round_stats']) : ?>
                    Map type: <?= $round['round_stats']['OW2 Mode']; ?><br>
                    <?php
                        $map_id = $round['round_stats']['Map'];

                        if (isset($match_data['voting']['map']['entities']) && $match_data['voting']['map']['entities']) :
                    ?>
                        <?php foreach ($match_data['voting']['map']['entities'] as $map) : ?>
                            <?php if ($map['game_map_id'] == $map_id) : ?>
                                Map: <?= $map['name']; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
                <h3>Stats</h3>
                <div class="stats">
                    <?php foreach ($round['teams'] as $team) : ?>
                        <div class="stats--team">
                            <h4><?= $team['team_stats']['Team'] ?></h4>
                            
                            <?php
                                ksort($team['team_stats']);
                                foreach ($team['team_stats'] as $stat_label => $team_stat) :
                            ?>
                                <?= $stat_label; ?>: <b><?= $team_stat; ?></b><br>
                            <?php endforeach; ?>
                            <div class="stats--team--player">
                                <?php
                                    usort($team['players'], function ($a, $b) {
                                        return $a['player_stats']['Role'] <=> $b['player_stats']['Role'];
                                    });
                                    foreach ($team['players'] as $player) :
                                ?>
                                    <h4><?= $player['nickname'] ?></h4>
                                    <p><?= $player['player_stats']['Role']; ?></p>
                                    <?php
                                        ksort($player['player_stats']);
                                        foreach ($player['player_stats'] as $stat_label =>  $player_stat) :
                                    ?>
                                        <?= $stat_label; ?>: <b><?= $player_stat; ?></b><br>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No FaceIT data for this match. It might've been streamed.</p>
        <?php endif; ?>
    </div>
    <?php include(__DIR__ .'/../partials/footer.php'); ?>
</body>
</html>