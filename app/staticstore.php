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

        case 'setcurrentmatchid':

            $match_id = $_POST['match_id'];

            $current_match_id = array(
                'match_id' => $match_id
            );

            storeStaticData($current_match_id, 'setcurrentmatchid');

            header('Location: dashboard.php?success="Current match ID set"');
            exit;
        break;

        case 'setcurrentmatch':
            $current_match = array();

            for ($team_num = 1; $team_num <= 2; $team_num++) {
                $team_key = 'team' . $team_num;
                $posted_team = isset($_POST[$team_key]) && is_array($_POST[$team_key]) ? $_POST[$team_key] : array();

                $current_match[$team_key] = array(
                    'name' => isset($posted_team['name']) ? trim($posted_team['name']) : '',
                    'score' => isset($posted_team['score']) ? (int)$posted_team['score'] : 0,
                    'side' => isset($posted_team['side']) ? (int)$posted_team['side'] : ($team_num === 1 ? 0 : 1),
                    'coach' => isset($posted_team['coach']) ? trim($posted_team['coach']) : '',
                    'ban' => isset($posted_team['ban']) ? trim($posted_team['ban']) : '',
                    'logo' => isset($posted_team['logo']) ? trim($posted_team['logo']) : '',
                    'roster' => array()
                );

                $posted_roster = isset($posted_team['roster']) && is_array($posted_team['roster'])
                    ? $posted_team['roster']
                    : array();

                for ($player_num = 1; $player_num <= 5; $player_num++) {
                    $player_key = 'player' . $player_num;
                    $posted_player = isset($posted_roster[$player_key]) && is_array($posted_roster[$player_key])
                        ? $posted_roster[$player_key]
                        : array();

                    $current_match[$team_key]['roster'][$player_key] = array(
                        'name' => isset($posted_player['name']) ? trim($posted_player['name']) : '',
                        'hero' => isset($posted_player['hero']) ? trim($posted_player['hero']) : '',
                        'role' => isset($posted_player['role']) ? trim($posted_player['role']) : ''
                    );
                }
            }

            storeStaticData($current_match, 'setcurrentmatch');

            header('Location: current/current_match.php?success="Current match set"');
            exit;
        break;
        
        default:
            header('Location: dashboard.php?error="Missing type"');
            exit;
        break;
    }