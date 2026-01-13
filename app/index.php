<?php
    include('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crown Cup</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>
    <?php include(__DIR__ .'/partials/menu.php'); ?>
    <div class="wrapper"> 
        <h1>Crown Cup - Where champions are crowned!</h1>
        <h2>Information</h2>
        <div class="matches">
            <a class="matches--match" href="https://drive.google.com/file/d/1KKgCbSTyYOEQlJ2Z_grRk7nonIeccDaK/view" target="_blank">
                <h3>Rulebook</h3>
                <p>Season 4 rules (pdf)</p>
            </a>
            <a class="matches--match" href="/signup/index.php">
                <h3>Season 4 signup</h3>
                <p>Signups are open!</p>
            </a>
            <a href="/maplist.php" class="matches--match">
                <h3>Map list</h3>
                <p>Competative Overwatch maps</p>
            </a>
            <a href="/mappool.php" class="matches--match">
                <h3>Map pool</h3>
                <p>Current tournament map pool</p>
            </a>
            <a class="matches--match" href="/herolist.php">
                <h3>Hero list</h3>
                <p>List over all available heroes</p>
            </a>
            <a class="matches--match" href="/tournament.php">
                <h3>Crown Cup tournaments and match stats</h3>
                <p>List over all current and former tournaments and match statistics</p>
            </a>  
            <a class="matches--match" href="https://www.twitch.tv/CrownCup_Esports" target="_blank">
                <h3>Twitch</h3>
                <p>Watch matches live!</p>
            </a>
            <a class="matches--match" href="https://www.youtube.com/@CrownCup" target="_blank">
                <h3>YouTube</h3>
                <p>VODs of previous matches</p>
            </a>
            <a class="matches--match" href="https://www.faceit.com/en/organizers/ab6769ce-1903-41cc-9197-9253997d43d4/Crown%20Cup" target="_blank">
                <h3>FaceIT</h3>
                <p>Match and tournament information</p>
            </a>
        </div>
        <h2>Join the discord!</h2>
        <iframe src="https://discord.com/widget?id=1273247580775514153&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
    </div>
    <?php include(__DIR__ .'/partials/footer.php'); ?>
</body>
</html>