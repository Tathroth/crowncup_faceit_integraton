<?php
    include('../functions.php');

    // Use get request to define match id, and get data
    $match_data = array();

    if (isset($_GET['match_id'])) {
        $match_id = $_GET['match_id'];

        $match_data = getFaceitData('matches/'.$match_id);
        $hero_data = getHeroData();
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
    <title>Match hero bans</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>
    <?php include(__DIR__ .'/../partials/menu.php'); ?>
    <div class="wrapper bans"> 
        <?php if ($match_data) : ?>
            <h1>Hero ban selection</h1>
            <h1><?= $match_data['teams']['faction1']['name']; ?> vs <?= $match_data['teams']['faction2']['name']; ?></h1>
            <h2><?= $match_data['competition_name'] ?></h2>
            <p><a href="/matches/view.php?match_id=<?= $match_id; ?>">Back to match view</a></p>
            <?php if (isset($match_data['teams'])) : ?>
                <h2>Teams</h2>
                <form action="/cards/hero_bans.php" action="get">
                    <div class="teams">
                        <?php foreach ($match_data['teams'] as $faction => $team) : ?>
                            <div class="teams--team">
                                <h3><?= $team['name']; ?></h3>
                                <?php if ($hero_data) : ?>
                                    <h3>Heroes</h3>
                                    <div class="roster">
                                        <?php foreach ($hero_data as $hero) : ?>
                                            <div class="roster--item">
                                                <label>
                                                    <img src="/../assets/heroes/thumbnails/<?= $hero['image'] ?>">
                                                    <b><?= $hero['name']; ?></b>
                                                    <input type="radio" name="ban_<?= $faction; ?>" value="<?= $hero['name']; ?>">
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="match_id" value="<?= $match_id; ?>" />
                    <input type="submit" value="Create ban cards" />
                </form>
            <?php endif; ?>
        <?php else : ?>
            <pre>
                <?php var_dump($match_data); ?>
            </pre>
        <?php endif; ?>
    </div>
    <?php include(__DIR__ .'/../partials/menu.php'); ?>
</body>
</html>