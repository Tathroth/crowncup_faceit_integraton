<?php
    include('../functions.php');

    if (!isLoggedIn()) {
        header('Location: login.php?error=true');
        exit;
    }

    $current_match_data = getStaticData('setcurrentmatch');
    $current_match_id = getStaticData('setcurrentmatchid');

    if (!$current_match_data) {
        echo 'No current match set';
        die();
    }

    $heroes = getHeroData();

    $match_id = $current_match_id['match_id'];
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
    <?php include(__DIR__ .'/../partials/menu.php'); ?>
    <div class="wrapper">
        
        <h1>Current match</h1>
        <p><a href="/matches/hero_bans.php?match_id=<?= $match_id; ?>">Jump to match hero ban creation</a></p>
        <form action="/staticstore.php" method="post">
            <input type="hidden" name="type" value="setcurrentmatch">

            <?php
                $default_team = array(
                    'name' => '',
                    'score' => 0,
                    'side' => 0,
                    'coach' => '',
                    'roster' => array()
                );

                $teams = array(
                    1 => isset($current_match_data['team1']) ? array_replace_recursive($default_team, $current_match_data['team1']) : $default_team,
                    2 => isset($current_match_data['team2']) ? array_replace_recursive($default_team, $current_match_data['team2']) : $default_team
                );

                if (empty($teams[1]['name'])) $teams[1]['name'] = 'Team 1 name';
                if (empty($teams[2]['name'])) $teams[2]['name'] = 'Team 2 name';

                if (!isset($teams[1]['side'])) $teams[1]['side'] = 0;
                if (!isset($teams[2]['side'])) $teams[2]['side'] = 1;

                if (empty($teams[1]['ban'])) $teams[1]['ban'] = '';
                if (empty($teams[2]['ban'])) $teams[2]['ban'] = '';

                if (empty($teams[1]['logo'])) $teams[1]['logo'] = '';
                if (empty($teams[2]['logo'])) $teams[2]['logo'] = '';
            ?>

            <div class="teams">
                <?php for ($team_num = 1; $team_num <= 2; $team_num++): ?>
                    <?php
                        $team = $teams[$team_num];
                        $team_key = 'team' . $team_num;
                    ?>

                    <div class="teams--team">
                        <h2><?= htmlspecialchars($team['name']); ?></h2>

                        <p><label>
                            Team name
                            <input
                                type="text"
                                name="<?= $team_key; ?>[name]"
                                value="<?= htmlspecialchars($team['name']); ?>"
                            >
                        </label></p>

                        <p><label>
                            Score
                            <input
                                type="number"
                                name="<?= $team_key; ?>[score]"
                                value="<?= (int)$team['score']; ?>"
                            >
                        </label></p>

                        <p><label>
                            Side (0 = left, 1 = right)
                            <input
                                type="number"
                                name="<?= $team_key; ?>[side]"
                                min="0"
                                max="1"
                                value="<?= (int)$team['side']; ?>"
                            >
                        </label></p>

                        <p><label>
                            Coach
                            <input
                                type="text"
                                name="<?= $team_key; ?>[coach]"
                                value="<?= htmlspecialchars($team['coach']); ?>"
                            >
                        </label></p>

                        <p><label>
                            Logo
                            <input
                                type="text"
                                name="<?= $team_key; ?>[logo]"
                                value="<?= htmlspecialchars($team['logo']); ?>"
                            >
                        </label></p>

                        <p><label>
                            Current ban
                            <input
                                type="text"
                                name="<?= $team_key; ?>[ban]"
                                list="hero-list"
                                class="hero-input"
                                value="<?= htmlspecialchars($team['ban']); ?>"
                            >
                        </label></p>

                        <h3>Roster</h3>

                        <?php for ($player_num = 1; $player_num <= 5; $player_num++): ?>
                            <?php
                                $player_key = 'player' . $player_num;
                                $player = isset($team['roster'][$player_key]) ? $team['roster'][$player_key] : array(
                                    'name' => '',
                                    'hero' => '',
                                    'role' => ''
                                );
                            ?>

                            <div class="player">
                                <h4>Player <?= $player_num; ?></h4>

                                <label>
                                    Name
                                    <input
                                        type="text"
                                        name="<?= $team_key; ?>[roster][<?= $player_key; ?>][name]"
                                        value="<?= htmlspecialchars($player['name']); ?>"
                                    >
                                </label>

                                <label>
                                    Hero
                                    <input
                                        type="text"
                                        list="hero-list"
                                        class="hero-input"
                                        data-role-target="<?= $team_key; ?>_<?= $player_key; ?>_role"
                                        name="<?= $team_key; ?>[roster][<?= $player_key; ?>][hero]"
                                        value="<?= htmlspecialchars($player['hero']); ?>"
                                    >
                                </label>

                                <label>
                                    Role
                                    <input
                                        type="text"
                                        id="<?= $team_key; ?>_<?= $player_key; ?>_role"
                                        name="<?= $team_key; ?>[roster][<?= $player_key; ?>][role]"
                                        value="<?= htmlspecialchars($player['role']); ?>"
                                        readonly
                                    >
                                </label>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endfor; ?>
            </div>

            <button type="submit">Save current match</button>

            <hr>
            <form action="/staticstore.php" method="post">
                <input type="hidden" name="type" value="setcurrentmatch">
                <button type="submit">Reset current match</button>
            </form>
        </form>
        
    </div>

    <datalist id="hero-list">
        <?php foreach ($heroes as $hero): ?>
            <?php if (!empty($hero['name'])): ?>
                <option value="<?= htmlspecialchars($hero['name']); ?>">
            <?php endif; ?>
        <?php endforeach; ?>
    </datalist>

    <script>
        window.heroData = <?= json_encode($heroes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const heroes = Array.isArray(window.heroData) ? window.heroData : [];
            const heroRoleMap = {};

            heroes.forEach(hero => {
                if (hero.name && hero.role) {
                    heroRoleMap[hero.name.trim().toLowerCase()] = hero.role;
                }
            });

            document.querySelectorAll('.hero-input').forEach(input => {
                function updateRoleFromHero() {
                    const heroName = input.value.trim().toLowerCase();
                    const roleFieldId = input.dataset.roleTarget;
                    const roleField = document.getElementById(roleFieldId);

                    if (!roleField) return;

                    if (heroRoleMap[heroName]) {
                        roleField.value = heroRoleMap[heroName];
                    }
                }

                input.addEventListener('change', updateRoleFromHero);
                input.addEventListener('blur', updateRoleFromHero);

                // Run once on page load too
                updateRoleFromHero();
            });
        });
    </script>

    
    <?php include(__DIR__ .'/../partials/footer.php'); ?>
</body>
</html>