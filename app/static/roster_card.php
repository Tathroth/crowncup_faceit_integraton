<?php
    include('../functions.php');

    $current_match_data = getStaticData('setcurrentmatch');

    if (!$current_match_data) {
        echo 'No current match set';
        die();
    }

    $team_data = $current_match_data['team1'];

    if (isset($_GET['team'])) {
        $team_data = $current_match_data[$_GET['team']];
    }

    $heroes = getHeroData();

    $heroes_by_name = array();

    foreach ($heroes as $hero) {
        if (!empty($hero['name'])) {
            $heroes_by_name[strtolower(trim($hero['name']))] = $hero;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Static team roster</title>
</head>
<body>
    <div class="team-showcase">
    <div class="team-showcase__header">
        <div class="team-showcase__team">
            <div class="team-showcase__team-logo">
                <img src="<?= $team_data['logo']; ?>" alt="<?= $team_data['name']; ?> logo">
            </div>

            <h1 class="team-showcase__team-name"><?= $team_data['name']; ?></h1>
        </div>

        <div class="team-showcase__event-logo">
            <img src="/../assets/cc_logo_v2.png" alt="Crown Cup Logo">
        </div>
    </div>

    <?php
        $role_order = [
            'tank' => 0,
            'dps' => 1,
            'support' => 2,
        ];

        $roster = $team_data['roster'] ?? array();

        uasort($roster, function ($a, $b) use ($role_order) {
            $a_role = strtolower(trim($a['role'] ?? ''));
            $b_role = strtolower(trim($b['role'] ?? ''));

            $a_sort = $role_order[$a_role] ?? 999;
            $b_sort = $role_order[$b_role] ?? 999;

            return $a_sort <=> $b_sort;
        });
    ?>

    <div class="team-showcase__players">
        <?php foreach ($roster as $player) : ?>
            <article class="player-card">
                <div class="player-card__image">
                    <?php
                        $hero_lookup_key = strtolower(trim($player['hero'] ?? ''));
                        $hero = $heroes_by_name[$hero_lookup_key] ?? null;

                        $hero_image = $hero['image'] ?? '';
                    ?>
                    <img src="/../assets/heroes/rosters/<?= $hero_image; ?>" alt="">
                </div>

                <div class="player-card__meta">
                    <div class="player-card__role">
                        <img src="/../assets/icons/<?= $player['role']; ?>.png" alt="">
                        <img src="role-dps.png" alt="">
                    </div>

                    <div class="player-card__name"><?= $player['name']; ?></div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>
<script>
function fitPlayerNames() {
    const names = document.querySelectorAll('.player-card__name');

    names.forEach(nameEl => {
        const maxFontSize = 24;
        const minFontSize = 12;

        // reset before measuring
        let fontSize = maxFontSize;
        nameEl.style.fontSize = fontSize + 'px';

        while (nameEl.scrollWidth > nameEl.clientWidth && fontSize > minFontSize) {
            fontSize--;
            nameEl.style.fontSize = fontSize + 'px';
        }
    });
}

document.addEventListener('DOMContentLoaded', fitPlayerNames);
window.addEventListener('resize', fitPlayerNames);
</script>
<style>
    :root {
    --bg: #000000;
    --card-bg: #e9e9e9;
    --accent: #e2cc24;
    --white: #ffffff;
    --black: #000000;
    --border: #d7d7d7;
}

@font-face {
    font-family: "Kizard";
    src:
    local("Kizard"),
    url("../assets/kizard.otf") format("opentype")
}

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    background: transparent;
    font-family: Kizard;
}

.team-showcase {
    width: 100%;
    max-width: 1440px;
    min-height: 100vh;
    margin: 0 auto;
    padding: 32px 40px 48px;
    background: transparent;
    color: var(--white);
}

.team-showcase__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 32px;
    margin-bottom: 28px;
}

.team-showcase__team {
    display: flex;
    align-items: center;
    gap: 24px;
    min-width: 0;
}

.team-showcase__team-logo {
    width: 110px;
    height: 110px;
    flex: 0 0 110px;
}

.team-showcase__team-logo img,
.team-showcase__event-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
}

.team-showcase__team-name {
    margin: 0;
    font-size: 64px;
    line-height: 0.95;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.02em;
}

.team-showcase__event-logo {
    width: 220px;
    flex: 0 0 220px;
}

.team-showcase__players {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 10px;
    align-items: stretch;
}

.player-card {
    display: flex;
    flex-direction: column;
    background: var(--card-bg);
    border: 3px solid var(--border);
    min-height: 640px;
    overflow: hidden;
}

.player-card__image {
    position: relative;
    background: #000;
    height: 360px;
    overflow: hidden;
}

.player-card__image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    object-position: top;
}

.player-card__meta {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    flex: 1;
    padding: 32px 20px 24px;
    text-align: center;
    position: relative;
}

.player-card__meta::after {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 18px;
    background: var(--accent);
}

.player-card__role {
    width: 110px;
    height: 110px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.player-card__role img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    display: block;
}

.player-card__name {
    color: var(--black);
    font-size: 24px;
    line-height: 1;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.01em;
    margin-bottom: 45px;

    white-space: nowrap;
    overflow: hidden;
    width: 100%;
    text-align: center;
}

@media (max-width: 1300px) {
    .team-showcase__team-name {
        font-size: 48px;
    }

    .team-showcase__players {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media (max-width: 900px) {
    .team-showcase {
        padding: 24px;
    }

    .team-showcase__header {
        flex-direction: column;
        align-items: flex-start;
    }

    .team-showcase__team {
        align-items: flex-start;
    }

    .team-showcase__team-name {
        font-size: 38px;
    }

    .team-showcase__players {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .player-card {
        min-height: 560px;
    }

    .player-card__image {
        height: 300px;
    }
}

@media (max-width: 560px) {
    .team-showcase__players {
        grid-template-columns: 1fr;
    }

    .team-showcase__team {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .team-showcase__team-name {
        font-size: 30px;
    }
}
</style>
</body>
</html>