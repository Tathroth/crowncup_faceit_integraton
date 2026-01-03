<?php
    include('functions.php');

    if (!isLoggedIn()) {
        header('Location: login.php?error=true');
        exit;
    }

    $basePath = __DIR__ . '/../storage/teams';

    $json_paths = array();

    foreach (new DirectoryIterator($basePath) as $dir) {
        if ($dir->isDot()) {
            continue;
        }

        if (!$dir->isDir()) {
            continue;
        }

        $folderName = $dir->getFilename();
        $fullPath   = $dir->getPathname();

        if (file_exists($fullPath)) {
            $json_paths[$folderName] = $fullPath.'/data.json';
        }
    }

    downloadCsvFromJsonFiles($json_paths, 'teams_export.csv');

    function downloadCsvFromJsonFiles(
        array $jsonFiles,
        string $filename = 'export.csv',
        string $separator = ';'
    ): void {
        $rows = [];
        $headers = [];

        // First pass: read files & collect headers
        foreach ($jsonFiles as $timestamp => $file) {
            if (!is_file($file)) continue;

            $data = json_decode(file_get_contents($file), true);
            if (!is_array($data)) continue;

            // Flatten arrays to strings
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $line_data = '';

                    if (str_contains($key, 'player_role_')) {
                        $line_data = implode(',', $value);
                    }
                    elseif ($key == 'team_logo') {
                        $download_path = 'https://crowncup.eu/download.php?file=teams/'.$timestamp.'/'.$value[0];
                        $line_data = $download_path;
                    }
                    elseif (str_contains($key, 'player_profile_screenshots_')) {
                        $download_path = 'https://crowncup.eu/download.php?file=teams/'.$timestamp.'/';
                        foreach ($value as $screenshot) {
                            $line_data .= $download_path.$screenshot.', ';
                        }
                    } else {
                        $line_data = json_encode($value, JSON_UNESCAPED_SLASHES);
                    }

                    $data[$key] = $line_data;
                }
            }

            $headers = array_unique(array_merge($headers, array_keys($data)));
            $rows[] = $data;
        }

        if (empty($rows)) {
            http_response_code(400);
            exit('No valid JSON files found');
        }

        // CSV headers
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $out = fopen('php://output', 'w');

        // Header row
        fputcsv($out, $headers, $separator);

        // Data rows
        foreach ($rows as $row) {
            $line = [];
            foreach ($headers as $header) {
                $line[] = $row[$header] ?? '';
            }
            fputcsv($out, $line, $separator);
        }

        fclose($out);
        exit;
    }

