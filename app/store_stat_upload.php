<?php
    include('functions.php');

    if (!isLoggedIn()) {
        header('Location: login.php?error=true');
        exit;
    }

    $current_match_data = getStaticData('setcurrentmatch');

    if (!$current_match_data) {
        echo 'No current match set';
        die();
    }

    $teams = $current_match_data;

    uasort($teams, function ($a, $b) {
        $a_side = (int) ($a['side'] ?? 999);
        $b_side = (int) ($b['side'] ?? 999);

        return $a_side <=> $b_side;
    });

    $team_data = array();
    $counter = 0;
    foreach ($teams as $team) {
        $hero_lookup_key = strtolower(trim($team['ban'] ?? ''));
        $hero = $heroes_by_name[$hero_lookup_key] ?? null;

        $team_data[$counter] = $team;

        $counter++;
    }

    $storage_data = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $filename = $_POST['uploadfile'];
        $left_team_name = $_POST['team1'];
        $right_team_name = $_POST['team2'];

        $uploadDir = __DIR__ . '/../storage/statfiles/';

        // Read and process the file
        $filePath = $uploadDir .'originals/'. $filename;
        
        $handle = fopen($filePath, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                // Remove any leading/trailing whitespace
                $line = preg_replace('/\[\d{2}:\d{2}:\d{2}\]\s*/', '', $line);
                $line = trim($line);

                // Skip empty lines
                if (empty($line)) continue;

                // Split the line by commas to extract key-value pairs
                $fields = explode(",", $line);
                
                foreach ($fields as $field) {
                    list($key, $value) = explode("=", $field);
                    $data[$key] = htmlspecialchars(trim($value));
                }

                $storage_team_side = 0;

                if ($data['team'] == $right_team_name) {
                    $storage_team_side = 1;
                }

                $storage_data[$storage_team_side]['team_name'] = $team_data[$storage_team_side];
                $storage_data[$storage_team_side]['players'][] = $data;
            }
            fclose($handle);
        }
    }

    $form_data_json = json_encode($storage_data, JSON_THROW_ON_ERROR);

    $date_str = date('Y-m-d');

    $path = __DIR__ . '/../storage/statfiles/'. $date_str;

    if (!is_dir($path) && !mkdir($path, 0755, true)) {
        throw new RuntimeException('Failed to create directory');
    }

    $timestamp = (string) time();

    $json_file = $path.'/data_'.$timestamp.'.json';

    $fp = fopen($json_file, 'w');
    fwrite($fp, $form_data_json);
    fclose($fp);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crown Cup - Uploaded data</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>
    <?php include(__DIR__ .'/partials/menu.php'); ?>
        <div class="wrapper">
            <h1>Uploaded data</h1>
            <p><a href="/dashboard.php">Back to the dash</a></p>
            <?php foreach($storage_data as $stored_team_data) : ?>
                <pre>
                    <?php var_dump($stored_team_data); ?>
                </pre>
            <?php endforeach; ?>
        </div>
    <?php include(__DIR__ .'/partials/footer.php'); ?>
</body>
</html>