<?php
    /*
        TODO:
        Make static JSON fetch from configs into a single
        function with an argument for which file
        in stead of having a function per file
    */

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    function isLoggedIn() {
        if (isset($_SESSION['username'])) {
            $config = getConfigData();
            if ($_SESSION['username'] == $config['user']) {
                return true;
            }
        }
        return false;
    }

    function appURL() {
        $config_data = getConfigData();

        if ($config_data) {
            return $config_data['app_url'];
        }
    }

    function getFaceitData($endpoint) {
        $base_url = 'https://open.faceit.com/data/v4/';
        $base_url = $base_url.''.$endpoint;

        $key = getFaceitKey();

        if ($key == '') {
            echo 'Key error';
            die();
        }
        // Initialize cURL session
        $ch = curl_init();

        // Set headers and other options
        curl_setopt_array($ch, [
            CURLOPT_URL => $base_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $key",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            $data = json_decode($response, true);

            return $data;
        }

        curl_close($ch);
    }

    function getFaceitKey() {
        $config_data = getConfigData();

        if ($config_data) {
            return $config_data['faceit_app_key'];
        }
    }

    function getFaceitOrgId() {
        $config_data = getConfigData();

        if ($config_data) {
            return $config_data['faceit_org_id'];
        }
    }

    function storeStaticData($data, $type) {
        $json_data = json_encode($data);

        $path = __DIR__ . '/../storage/'.$type.'.json';

        $fp = fopen($path, 'w');
        fwrite($fp, $json_data);
        fclose($fp);
    }

    function getStoredMapPool() {
        $maps = getStaticData('mappool');
        $output = array();
        $all_maps = getAllMapData();

        if ($maps) {
            foreach ($maps as $map_id) {
                foreach ($all_maps as $map_category => $maps_data) {
                    foreach ($maps_data as $map_data) {
                        if ($map_id == $map_data['id']) {
                            $output[$map_category][] = $map_data;
                        }
                        continue;
                    }
                }
            }
        }
    
        return $output;
    }

    function getTournamentExcludeList() {
        $filePath = __DIR__ . '/../tournament_exclude.json';

        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $data = json_decode($jsonContent, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function getAllMapData() {
        $filePath = __DIR__ . '/../maps.json';

        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $data = json_decode($jsonContent, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function getStaticData($type) {
        $filePath = __DIR__ . '/../storage/'.$type.'.json';

        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $data = json_decode($jsonContent, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function getLastMapData() {
        $parentFolder = __DIR__ . '/../storage/statfiles';

        if (!is_dir($parentFolder)) {
            die("Directory does not exist.");
        }

        $items = scandir($parentFolder);
        $folders = array_filter($items, function ($item) use ($parentFolder) {
            return is_dir($parentFolder . '/' . $item);
        });

        if (empty($folders)) {
            echo "No folders found.";
            exit;
        }

        $newestFolder = '';
        $latestTime = 0;

        foreach ($folders as $folder) {
            $folderPath = $parentFolder . '/' . $folder;
            $modificationTime = filemtime($folderPath);

            if ($modificationTime > $latestTime) {
                $latestTime = $modificationTime;
                $newestFolder = $folder;
            }
        }

        $newestFolder = $parentFolder.'/'.$newestFolder;
        $file_items = scandir($newestFolder);
        $files = array_filter($file_items, function ($file_item) use ($newestFolder) {
            return is_file($newestFolder . '/' . $file_item);
        });

        if (empty($files)) {
            echo "No files found.";
            exit;
        }

        $newestFile = '';
        $latestTime = 0;

        foreach ($files as $file) {
            $filePath = $newestFolder . '/' . $file;
            $modificationTime = filemtime($filePath);

            if ($modificationTime > $latestTime) {
                $latestTime = $modificationTime;
                $newestFile = $file;
            }
        }

        $newestFile = $newestFolder.'/'.$newestFile;

        if (file_exists($newestFile)) {
            $jsonContent = file_get_contents($newestFile);
            $data = json_decode($jsonContent, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }  
    }

    function getHeroData() {
        $filePath = __DIR__ . '/../heroes.json';

        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $data = json_decode($jsonContent, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function getConfigData() {
        $filePath = __DIR__ . '/../config.json';

        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $data = json_decode($jsonContent, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
?>