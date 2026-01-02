<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    $posted_data = $_POST;

    $timestamp = time();
    $path = __DIR__ . '/../storage/teams/' . $timestamp;

    if (!is_dir($path) && !mkdir($path, 0755, true)) {
        throw new RuntimeException('Failed to create directory');
    }

    // håndter logo eksplisitt
    if (!empty($_FILES['team_logo']['name'])) {
        $posted_data['team_logo'] = storeUploadedImages('team_logo', $path);
    }

    // håndter alle spiller-bilder
    foreach ($_FILES as $fieldName => $fileData) {

        if ($fieldName === 'team_logo') {
            continue;
        }

        $uploaded = storeUploadedImages($fieldName, $path);
        $posted_data[$fieldName] = $uploaded;
    }

    $form_data_json = json_encode($posted_data, JSON_THROW_ON_ERROR);

    storeTeamSignup($form_data_json, $timestamp);


    function storeUploadedImages(
        string $fieldName,
        string $targetDir,
        int $maxSizeBytes = 2_000_000
    ): array {
        if (!isset($_FILES[$fieldName])) {
            return [];
        }

        $file = $_FILES[$fieldName];

        // Normaliser single vs multiple
        $names = is_array($file['name']) ? $file['name'] : [$file['name']];
        $errors = is_array($file['error']) ? $file['error'] : [$file['error']];
        $sizes = is_array($file['size']) ? $file['size'] : [$file['size']];
        $tmpNames = is_array($file['tmp_name']) ? $file['tmp_name'] : [$file['tmp_name']];

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
        ];

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $savedFiles = [];

        if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true)) {
            throw new RuntimeException('Failed to create directory');
        }

        for ($i = 0; $i < count($names); $i++) {

            if ($errors[$i] === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            if ($errors[$i] !== UPLOAD_ERR_OK) {
                throw new RuntimeException('Upload error on file #' . $i);
            }

            if ($sizes[$i] > $maxSizeBytes) {
                throw new RuntimeException('File too large on file #' . $i);
            }

            $mime = $finfo->file($tmpNames[$i]);

            if (!isset($allowedTypes[$mime])) {
                throw new RuntimeException('Invalid file type on file #' . $i);
            }

            $filename = bin2hex(random_bytes(16)) . '.' . $allowedTypes[$mime];
            $destination = rtrim($targetDir, '/') . '/' . $filename;

            if (!move_uploaded_file($tmpNames[$i], $destination)) {
                throw new RuntimeException('Failed to save file #' . $i);
            }

            $savedFiles[] = $filename;
        }

        return $savedFiles;
    }

    function storeTeamSignup($data, $filename) {
        $path = __DIR__ . '/../storage/teams/'.$filename.'/data.json';

        $fp = fopen($path, 'w');
        fwrite($fp, $data);
        fclose($fp);
    }

