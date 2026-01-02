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
        <h1>Thanks for signing up!</h1>
        <h2>Signup code: <?= $_GET['signup_code']; ?></h2>
        <p>Review your data. Contact us on discord if you notice any errors!</p>
        <hr>
        <?php
            $type = 'teams/'.$_GET['signup_code'].'/data';
            $data_arr = getStaticData($type);
        ?>

        <h2><?= $data_arr['team_name']; ?></h2>
        <p>Division: <?= $data_arr['division']; ?></p>
        <p>Manager discord: <?= $data_arr['manager_discord']; ?></p>
        <p>Manager bnet: <?= $data_arr['manager_bnet']; ?></p>
        <p>Manager faceit: <?= $data_arr['manager_faceit']; ?></p>
        <p>Coach discord: <?= $data_arr['coach_discord']; ?></p>
        <p>Number of players: <?= $data_arr['players']; ?></p>
        <p>Team logo: <?php if (isset($data_arr['team_logo'][0])) : ?>
            <a
                href="/download.php?file=teams/<?= $_GET['signup_code']; ?>/<?= $data_arr['team_logo'][0]; ?>"
                target="_blank"
            ><?= $data_arr['team_logo'][0]; ?></a>
            <?php else : ?>
                No logo
            <?php endif; ?>
        </p>
        
        <div class="matches">
            <?php
                $number_of_players = intval($data_arr['players']);
                $counter = 1;
                for ($i=0; $i < $number_of_players; $i++) :
            ?>
                <div class="matches--match">
                    <h3>Player <?= $counter; ?></h3>
                    <p>Discord: <?= $data_arr['player_discord_'.$counter]; ?></p>
                    <p>Battlenet: <?= $data_arr['player_battlenet_'.$counter]; ?></p>
                    <p>Faceit: <?= $data_arr['player_faceit_'.$counter]; ?></p>
                    <p>Roles:
                        <ul>
                            <?php foreach ($data_arr['player_role_'.$counter] as $role) : ?>
                                <li><?= $role; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </p>
                    <p>Screenshots:
                        <ul>
                            <?php foreach ($data_arr['player_profile_screenshots_'.$counter] as $screenshot) : ?>
                                <li><a
                                    href="/download.php?file=teams/<?= $_GET['signup_code']; ?>/<?= $screenshot; ?>"
                                    target="_blank"
                                ><?= $screenshot; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </p>
                    <?php $counter++; ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>
<?php include(__DIR__ .'/../partials/footer.php'); ?>
</body>
</html>