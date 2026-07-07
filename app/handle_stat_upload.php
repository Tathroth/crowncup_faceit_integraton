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

        $team_data[$counter] = array(
            'name' => $team['name']
        );

        $counter++;
    }

    $team_names = array();
    $upload_filename = '';
    $output_message = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if file was uploaded successfully
        if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
            $uploadDir = __DIR__ . '/../storage/statfiles/';

            // Ensure the uploads directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = basename($_FILES["fileToUpload"]["name"]);
            $filePath = $uploadDir .'originals/'. $fileName;
            $upload_filename = $fileName;

            // Move the uploaded file to a directory
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $filePath)) {
                echo "File uploaded successfully.<br>";

                // Read and process the file
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

                        $team_names[] = $data['team'];
                    }
                    fclose($handle);
                } else {
                    $output_message = "Error reading the file.";
                }
            } else {
                $output_message = "Error moving uploaded file.";
            }
        } else {
            $output_message = "File upload error: " . $_FILES["fileToUpload"]["error"];
        }
    }
    $team_names = array_unique($team_names);
    $team_names = array_values($team_names);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crown Cup - Connect team names</title>
    <link rel="stylesheet" href="<?= appURL(); ?>/assets/style.css">
</head>
<body>
    <?php include(__DIR__ .'/partials/menu.php'); ?>
        <div class="wrapper">
            <?= $output_message; ?>
            <h1>Connect team names with lobby teams</h1>
            <form action="store_stat_upload.php" method="post">
                <h2>Uploaded name for <?= $team_data[0]['name']; ?></h2>
                <select name="team1">
                    <option value="<?= $team_names[0]; ?>"><?= $team_names[0]; ?></option>
                    <option value="<?= $team_names[1]; ?>"><?= $team_names[1]; ?></option>
                </select>
                <h2>Uploaded name for <?= $team_data[1]['name']; ?></h2>
                <select name="team2">
                    <option value="<?= $team_names[1]; ?>"><?= $team_names[1]; ?></option>
                    <option value="<?= $team_names[0]; ?>"><?= $team_names[0]; ?></option>
                </select>
                <input type="hidden" name="uploadfile" value="<?= $upload_filename; ?>">

                <input type="submit" value="Upload File" name="submit">
            </form>
        </div>
    <?php include(__DIR__ .'/partials/footer.php'); ?>
</body>
</html>