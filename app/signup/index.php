<?php
    include('../functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crown Cup - Team signup</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>
    <?php include(__DIR__ .'/../partials/menu.php'); ?>
    <div class="wrapper">
        <h1>Crown Cup signup form</h1>
        <p>Welcome to the Crown Cup, where champions are crowned!</p>
        <p>This form is for signing up to the Crown Cup. Please read the rules before applying.</p>
        <form action="players.php">
            <div class="form_step_1">
                <label>
                    <h2>Team Name</h2>
                    <p>Required</p>
                    <input name="team_name" type="text" required />
                </label>
                <h2>Division</h2>
                <p>Required. The division your team belongs to.</p>
                <label>
                    <input type="radio" name="division" value="challenger" required /> Challenger (B5-D1)<br>
                </label>
                <label>
                    <input type="radio" name="division" value="champion" required /> Champion (M5 - GM4)
                </label>
                <label>
                    <h2>Manager discord</h2>
                    <p>Required. Discord user name of the team manager</p>
                    <input type="text" name="manager_discord" required />
                </label>
                <label>
                    <h2>Manager BattleNet</h2>
                    <p>Required. BattleNet user name of the team manager</p>
                    <input type="text" name="manager_bnet" required />
                </label>
                <label>
                    <h2>Manager FaceIt tag</h2>
                    <p>Required. FaceIt tag of the team manager</p>
                    <input type="text" name="manager_faceit" required />
                </label>
                <label>
                    <h2>Coach Discord</h2>
                    <p>Discord user name of the team coach. If there are several, add them seperated by a comma.</p>
                    <input type="text" name="coach_discord" />
                </label>
                <label>
                    <h2>Coach BattleNet</h2>
                    <p>BattleNet user name of the team coach. If there are several, add them seperated by a comma.</p>
                    <input type="text" name="coach_discord" />
                </label>
                <label>
                    <h2>How many players do you want to register?</h2>
                    <input type="number" name="players" value="5" required />
                </label>
                <br>
                <br>
                <br>
                <button type="Submit">Next step</button>
                <br>
                <br>
            </div>
        </form>
    </div>
<?php include(__DIR__ .'/../partials/footer.php'); ?>
</body>
</html>