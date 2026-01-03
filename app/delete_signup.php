<?php
    include('functions.php');

    if (!isLoggedIn()) {
        header('Location: /login.php?error=true');
        exit;
    }

    if (!isset($_GET['entry'])) {
        header('Location: /signups.php');
        exit; 
    }

    $signup_to_delete = $_GET['entry'];

    $path = __DIR__ . '/../storage/teams/' . $signup_to_delete;

    moveFolderToDeleted($path);

    header('Location: /signups.php');
    exit;

    function moveFolderToDeleted(string $folderPath): bool {
        if (!is_dir($folderPath)) {
            return false;
        }

        $deletedDir = __DIR__ . '/../storage/deleted';
        $folderName = basename($folderPath);
        $targetPath = $deletedDir . '/' . $folderName;

        // Ensure deleted folder exists
        if (!is_dir($deletedDir)) {
            mkdir($deletedDir, 0755, true);
        }

        // Remove existing target if it exists
        if (is_dir($targetPath)) {
            deleteFolderRecursive($targetPath);
        }

        // Move folder
        return rename($folderPath, $targetPath);
    }

    function deleteFolderRecursive(string $dir): void {
        $files = array_diff(scandir($dir), ['.', '..']);

        foreach ($files as $file) {
            $path = "$dir/$file";
            is_dir($path)
                ? deleteFolderRecursive($path)
                : unlink($path);
        }

        rmdir($dir);
    }

