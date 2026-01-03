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
        <p><a href="/export_signups.php" target="_blank">Export signups to CSV</a></p>
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
                <div class="matches--match">
                    <h2>
                        <a href="/signup/thanks.php?signup_code=<?= $folderName ?>"><?= $team_name; ?></a>
                    </h2>
                    <p>Division: <?= $team_division; ?></p>
                    <p><a href="/delete_signup.php?entry=<?= $folderName ?>" class="confirm-link">Delete entry</a></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        document.querySelectorAll('.confirm-link').forEach(link => {
            link.addEventListener('click', e => {
                if (!confirm('Are you sure you want to continue?')) {
                e.preventDefault();
                }
            });
        });
    </script>
    <?php include(__DIR__ .'/partials/footer.php'); ?>
</body>
</html>