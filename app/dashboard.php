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
                    <th>Description</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hero bans</td>
                    <td>Full screen with hero ban cards</td>
                    <td><a href="/static/hero_bans_card.php">Link</a></td>
                </tr>
                <tr>
                    <td>Hero bans overlay</td>
                    <td>Overlay with hero bans, bottom left corner</td>
                    <td><a href="/static/hero_bans_overlay.php">Link</a></td>
                </tr>
                <tr>
                    <td>Map picks</td>
                    <td>Map pick overview</td>
                    <td><a href="/static/map_bans.php">Link</a></td>
                </tr>
                <tr>
                    <td>Match card</td>
                    <td>Match card that compares two teams in a match</td>
                    <td><a href="/static/match_card.php">Link</a></td>
                </tr>
                <tr>
                    <td>Player compare card</td>
                    <td>Compares stats of two players in a match</td>
                    <td><a href="/static/player_card.php">Link</a></td>
                </tr>
                <tr>
                    <td>MVP card</td>
                    <td>MVP from a match</td>
                    <td><a href="/static/mvp_card.php">Link</a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php include(__DIR__ .'/partials/footer.php'); ?>
</body>
</html>