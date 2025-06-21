<?php
    /*
        TODO:
        Set up grabbing data from Crown Cup tournaments
        Login check
        Function to grab data based on endpoint
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

    function getAllMapData() {
        // Replace with the full path to your JSON file
        $filePath = __DIR__ . '/../maps.json';

        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);

            
            // Decode JSON into an associative array
            $data = json_decode($jsonContent, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                // Successfully decoded

                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function getStaticData($type) {
        // Replace with the full path to your JSON file
        $filePath = __DIR__ . '/../storage/'.$type.'.json';

        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);

            
            // Decode JSON into an associative array
            $data = json_decode($jsonContent, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                // Successfully decoded
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function getHeroData() {
        // Replace with the full path to your JSON file
        $filePath = __DIR__ . '/../heroes.json';

        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);

            
            // Decode JSON into an associative array
            $data = json_decode($jsonContent, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                // Successfully decoded
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function getConfigData() {
        // Replace with the full path to your JSON file
        $filePath = __DIR__ . '/../config.json';

        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);

            
            // Decode JSON into an associative array
            $data = json_decode($jsonContent, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                // Successfully decoded
                return $data;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
?>