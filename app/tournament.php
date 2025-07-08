<?php
    include('functions.php');

    $faceit_ord_id = getFaceitOrgId();
    $exclude_list = getTournamentExcludeList();

    $data = getFaceitData('organizers/'.$faceit_ord_id.'/championships');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournaments</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>
    <?php include(__DIR__ .'/partials/menu.php'); ?>
    <div class="wrapper"> 
        <h1>Tournaments</h1>
        <?php /* <p><a href="/matches/list.php?tournament=4387fccf-feea-43b3-9683-d8abbb35bd6a">Test tournament</a></p> */ ?>
        <?php if ($data['items']) : ?>
            <?php foreach ($data['items'] as $tournament) : ?>
                <?php
                    $tournament_id = $tournament['id']; 

                    if (in_array($tournament_id, $exclude_list)) {
                        continue;
                    }
                ?>
                <p><a href="/matches/list.php?tournament=<?= $tournament_id; ?>"><?= $tournament['name'] ?></a></p>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No tournaments found</p>
        <?php endif; ?>
    </div>
    <?php include(__DIR__ .'/partials/footer.php'); ?>
</body>
</html>