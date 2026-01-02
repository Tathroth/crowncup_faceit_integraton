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
        <h1>Signups</h1>
        <p>Teams that have signed up</p>
        <div class="matches">
            <?php
                $basePath = __DIR__ . '/../storage/teams';

                foreach (new DirectoryIterator($basePath) as $dir) :
            ?>
            
                <?php

                    if ($dir->isDot()) {
                        continue;
                    }

                    if (!$dir->isDir()) {
                        continue;
                    }

                    $folderName = $dir->getFilename();
                    $fullPath   = $dir->getPathname();

                    if (file_exists($fullPath)) {
                        $jsonContent = file_get_contents($fullPath.'/data.json');

                        // Decode JSON into an associative array
                        $data = json_decode($jsonContent, true);
                        $team_name = '';
                        $team_division = '';

                        if (json_last_error() === JSON_ERROR_NONE) {
                            // Successfully decoded
                            if (isset($data['team_name'])) {
                                $team_name = $data['team_name'];
                            }
                            if (isset($data['division'])) {
                                $team_division = $data['division'];
                            }
                        } else {
                            return '';
                        }
                    } else {
                        return '';
                    }
                ?>
                <a class="matches--match" href="/signup/thanks.php?signup_code=<?= $folderName ?>">
                    <h2><?= $team_name; ?></h2>
                    <p>Division: <?= $team_division; ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include(__DIR__ .'/partials/footer.php'); ?>
</body>
</html>