<?php
    include('functions.php');

    if (!isLoggedIn()) {
        header('Location: login.php?error=true');
        exit;
    }
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
        <h1>Static production links</h1>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Description and steps</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hero bans</td>
                    <td><p>Full screen with hero ban cards.</p><p>You can pick the match to save bans for by going to the correct tournament in <a href="/tournament.php">tournaments</a>, picking the match in question and clicking "Create hero bans cards".</p><p>After loading the card, click "Save".</p></td>
                    <td><a href="/static/hero_bans_card.php">Load static card</a></td>
                </tr>
                <tr>
                    <td>Hero bans overlay</td>
                    <td><p>Overlay with hero bans, bottom left corner. Se "Hero bans" for how to save it.</p></td>
                    <td><a href="/static/hero_bans_overlay.php">Load static overlay</a></td>
                </tr>
                <tr>
                    <td>Map picks</td>
                    <td><p><a href="/maps/current_map.php">Click here to select map picks</a>.</p><p>The picked maps are stacked, so this will need to be reset after each match.</p></td>
                    <td><a href="/static/map_picks.php">Load static map picks</a></td>
                </tr>
                <tr>
                    <td>Current map pick</td>
                    <td><p>Displays the newest map pick from "Map picks".</p></td>
                    <td><a href="/static/map_pick.php">Load static map pick</a></td>
                </tr>
                <tr>
                    <td>Map pool</td>
                    <td><p><a href="/maps/create_pool.php">Set map pool</a>.</p><p>Should probably only be needed to do for each stage of the tournament.</p></td>
                    <td><a href="/static/map_pool.php">Load static map pool</a></td>
                </tr>
                <tr>
                    <td>Match card</td>
                    <td><p>Match card that compares two teams in a match.</p><p>You can pick the match to compare teams for by going to the correct tournament in <a href="/tournament.php">tournaments</a>, picking the match in question and clicking "Match card".</p><p>After loading the card, click "Save".</p></td>
                    <td><a href="/static/match_card.php">Load static card</a></td>
                </tr>
                <tr>
                    <td>Player compare card</td>
                    <td><p>Compares stats of two players in a match.</p><p>You can pick the players by going to the correct tournament in <a href="/tournament.php">tournaments</a>, pick the match in question, and pick two players to compare.</p><p>After loading the card, click "Save".</p></td>
                    <td><a href="/static/player_card.php">Load static card</a></td>
                </tr>
                <tr>
                    <td>MVP card</td>
                    <td><p>Pick a match MVP to store to static by going to the correct tournament in <a href="/tournament.php">tournaments</a>, pick the match in question, and pick a player as MVP.</p><p>After loading the card, click "Save".</p></td>
                    <td><a href="/static/mvp_card.php">Load static card</a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php include(__DIR__ .'/partials/footer.php'); ?>
</body>
</html>