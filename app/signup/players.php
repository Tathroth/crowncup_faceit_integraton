<?php
    if (!isset($_GET) || !$_GET) {
        header("Location: /signup/index.php");
        exit; // Stop further script execution
    }

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
        <h1>Crown Cup signup form - Step 2</h1>
        <p>Add your players</p>
        <form action="/team_form_store.php" enctype="multipart/form-data" method="post">
            <?php
                $step_1_array = $_GET;

                foreach ($step_1_array as $step_key => $step_item) :
            ?>
                <input type="hidden" name="<?= $step_key; ?>" value="<?= $step_item; ?>">
            <?php endforeach; ?>
            <div class="form_step_2">
                <label>
                    <h2>Team Logo (if you have one)</h2>
                    <input name="team_logo" type="file" />
                </label>           
                <?php
                    $player_setup = array(
                        array(
                            'type' => 'text',
                            'name' => 'player_discord',
                            'title' => 'Player discord',
                            'description' => 'Discord user name of the player'
                        ),
                        array(
                            'type' => 'text',
                            'name' => 'player_battlenet',
                            'title' => 'Player battlenet',
                            'description' => 'BattleNet user name of the player'
                        ),
                        array(
                            'type' => 'text',
                            'name' => 'player_faceit',
                            'title' => 'Player FaceIt Profile',
                            'description' => 'Link to the FaceIt profile of the player'
                        ),
                        array(
                            'type' => 'checkbox',
                            'name' => 'player_role',
                            'title' => 'Player Main Role',
                            'description' => 'If the player is a flex-player, please tick all roles the player will play',
                            'options' => array(
                                'Tank', 'DPS', 'Support', 'Flex'
                            )
                        ),
                        array(
                            'type' => 'file',
                            'name' => 'player_profile_screenshots',
                            'title' => 'Player Profile Screenshots',
                            'description' => 'Please Upload a screenshot of The Players current season + Last 2 seasons.  Screenshots MUST show players rank over last three seasons, along with name.'
                        )
                    );
                ?>
                <?php if (isset($_GET['players'])) : ?>
                    <?php
                        $player_count = intval($_GET['players']);
                        $counter = 1;
                        for ($i=0; $i < $player_count; $i++) :
                    ?>
                        <h2>Player <?= $counter; ?></h2>
                        <?php foreach ($player_setup as $player) : ?>
                            <h3><?= $player['title']; ?></h3>
                            <p><?= $player['description']; ?></p>
                            <?php if ($player['type'] == 'checkbox') : ?>
                                <?php foreach($player['options'] as $option) : ?>
                                    <label>
                                        <input type="<?= $player['type']; ?>" name="<?= $player['name']; ?>_<?= $counter; ?>[]" value="<?= $option ?>"> <?= $option ?><br>
                                    </label>
                                <?php endforeach; ?>
                            <?php elseif ($player['type'] == 'file') : ?>
                                <input type="<?= $player['type']; ?>" name="<?= $player['name']; ?>_<?= $counter; ?>[]" multiple required>
                            <?php else : ?>
                                <label>
                                    <input type="<?= $player['type']; ?>" name="<?= $player['name']; ?>_<?= $counter; ?>" required>
                                </label>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <hr>
                        <?php $counter++; ?>
                    <?php endfor; ?>
                <?php endif; ?>
                <br>
                <br>
                <br>
                <button type="submit">Sumbit your team</button>
                <br>
                <br>
            </div>
        </form>
    </div>
<?php include(__DIR__ .'/../partials/footer.php'); ?>
</body>
</html>