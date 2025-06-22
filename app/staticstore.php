<?php
    include('functions.php');

    if (!isLoggedIn()) {
        header('Location: login.php?error=true');
        exit;
    }

    if (!isset($_POST['type'])) {
        echo 'Type missing';
        die;
    }

    $type = $_POST['type'];

    switch ($type) {
        case 'herobans':
            $data = array(
                'heroes' => array(
                    array(
                        'name' => $_POST['hero1'],
                        'img' => $_POST['image1']
                    ),
                    array(
                        'name' => $_POST['hero2'],
                        'img' => $_POST['image2']
                    )
                ),
                'teams' => array(
                    $_POST['team1'],
                    $_POST['team2']
                )
            );
            storeStaticData($data, $type);

            header('Location: dashboard.php?success="Hero ban card stored"');
            exit;

        break;
        case 'playercompare':
            $data = json_decode($_POST['data'], true);
            storeStaticData($data, $type);

            header('Location: dashboard.php?success="Player compare card stored"');
            exit;

        break;
        case 'teamscompare':
            $data = json_decode($_POST['data'], true);
            storeStaticData($data, $type);

            header('Location: dashboard.php?success="Team compare card stored"');
            exit;

        break;
        case 'mvpcard':
            $data = json_decode($_POST['data'], true);
            storeStaticData($data, $type);

            header('Location: dashboard.php?success="Team compare card stored"');
            exit;
        break;

        case 'mappool':
            storeStaticData($_POST['map'], $type);

            header('Location: dashboard.php?success="Map pool is stored"');
            exit;
        break;
        case 'mappick':
            $current = getStaticData('mappick');

            $pool = getStoredMapPool();
            $map_id = $_POST['map'];

            $post_data = array();

            foreach ($pool as $cat => $maps) {
                foreach ($maps as $map) {
                    if ($map_id == $map['id']) {
                        $post_data = array(
                            'id' => $map_id,
                            'category' => $cat
                        );
                    }
                }
            } 

            if ($current) {
                $current[] = $post_data;
            } else {
                $current = array($post_data);
            }  

            storeStaticData($current, $type);

            header('Location: dashboard.php?success="Map pick is stored"');
            exit;
        break;
        case 'resetmappicks':
            $current = array();

            storeStaticData($current, 'mappick');

            header('Location: maps/current_map.php?success="Map picks are reset"');
            exit;
        break;
        
        default:
            header('Location: dashboard.php?error="Missing type"');
            exit;
        break;
    }