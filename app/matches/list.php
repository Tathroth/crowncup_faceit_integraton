<?php
    require_once('../functions.php');

    $tournament = '4387fccf-feea-43b3-9683-d8abbb35bd6a';

    if (isset($_GET['tournament'])) {
        $tournament = $_GET['tournament'];
    }

    $data = getFaceitData('championships/'.$tournament.'/matches');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match list</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>
    <?php include(__DIR__ .'/../partials/menu.php'); ?>
    <div class="wrapper"> 
        <?php if (isset($data['items']) && $data['items']) : ?>
            <h1><?= $data['items'][0]['competition_name'] ?></h1>
            <div class="matches">
                <?php foreach ($data['items'] as $match) : ?>
                    <a href="/matches/view.php?match_id=<?= $match['match_id']; ?>" class="matches--match">
                        <?php if (isset($match['started_at'])) : ?>
                            <?= date('d.m.Y, H.i:s', $match['started_at']); ?>
                        <?php else : ?>
                            Match not started
                        <?php endif; ?>
                        <div class="match_teams">
                            <?php ksort($match['teams']); ?>
                            <?php foreach ($match['teams'] as $team) : ?>
                                <div class="match_teams--team">
                                    <h4><?= $team['name'] ?></h4>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (isset($match['results'])) : ?>
                            Score: <?= $match['results']['score']['faction1']; ?> - <?= $match['results']['score']['faction2']; ?><br>
                            <?php if (isset($match['teams'][$match['results']['winner']]['name'])) : ?>
                                Winner: <?= $match['teams'][$match['results']['winner']]['name']; ?><br>
                            <?php endif; ?>
                            <?= $match['status']; ?>
                        <?php else : ?>
                            No match data
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <h1>Match list</h1>
            <p>Could not load data</p>
        <?php endif; ?>
    </div>
    <?php include(__DIR__ .'/../partials/footer.php'); ?>
</body>
</html>