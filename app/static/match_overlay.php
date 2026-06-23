<?php
    include('../functions.php');

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

    $heroes_by_name = array();
    $heroes = getHeroData();

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
    <title>Match Overlay</title>
</head>
<body>
    <?php
        $team_data = array();
        $counter = 0;
        foreach ($teams as $team) {
            $hero_lookup_key = strtolower(trim($team['ban'] ?? ''));
            $hero = $heroes_by_name[$hero_lookup_key] ?? null;

            $team_data[$counter] = array(
                'name' => $team['name'],
                'score' => $team['score'],
                'ban' => $hero['image']
            );

            $counter++;
        }
    ?>
    <div class="match-hud">
        <div class="match-hud__top-corners">
            <div class="match-hud__corner match-hud__corner--left"></div>
            <div class="match-hud__corner match-hud__corner--right"></div>
        </div>

        <div class="match-hud__top">
            <!-- LEFT TEAM -->
            <div class="team-score team-score--left">
                <div class="team-score__ban team-score__ban--left">
                    <div class="team-score__ban-box">
                        <img src="/../assets/heroes/thumbnails/<?= $team_data[0]['ban']; ?>" alt="">
                    </div>
                    <div class="team-score__ban-text">
                        <span>B</span>
                        <span>A</span>
                        <span>N</span>
                    </div>
                </div>

                <div class="team-score__bar">
                    <div class="team-score__name"><?= $team_data[0]['name']; ?></div>
                    <div class="team-score__score left">
                        <div class="score_number"><?= $team_data[0]['score']; ?></div>
                    </div>
                </div>
            </div>

            <!-- CENTER EVENT -->
            <div class="match-hud__center">
                <svg class="match-hud__center-shape" viewBox="0 0 530 70" preserveAspectRatio="none" aria-hidden="true">
                    <!-- base fill -->
                    <polygon
                        class="match-hud__center-fill"
                        points="0,0 530,0 477,70 53,70"
                    />

                    <!-- 1px yellow line: left slope + bottom + right slope -->
                    <polyline
                        class="match-hud__center-line-yellow"
                        points="16,3 59,60 471,60 514,3"
                    />
                </svg>

                <div class="match-hud__center-inner">
                    <div class="match-hud__brand">CROWN<br>CUP</div>
                    <div class="match-hud__logo"><img src="/../assets/cc_icon.png" alt=""></div>
                    <div class="match-hud__season">SEASON<br>FIVE</div>
                </div>
            </div>

            <!-- RIGHT TEAM -->
            <div class="team-score team-score--right">
                <div class="team-score__bar">
                    <div class="team-score__score right">
                        <div class="score_number"><?= $team_data[1]['score']; ?></div>
                    </div>
                    <div class="team-score__name"><?= $team_data[1]['name']; ?></div>
                </div>

                <div class="team-score__ban team-score__ban--right">
                    <div class="team-score__ban-text">
                        <span>B</span>
                        <span>A</span>
                        <span>N</span>
                    </div>
                    <div class="team-score__ban-box">
                        <img src="/../assets/heroes/thumbnails/<?= $team_data[1]['ban']; ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        :root {
            --hud-bg: #efefef;
            --hud-dark: #1d181c;
            --hud-yellow: #e3cd27;
            --hud-white: #ffffff;
            --hud-black: #000000;
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
            background: #111;
            font-family: Kizard;
        }

        .match-hud {
            position: relative;
            width: 100vw;
            height: 100vh;
            margin: 0 auto;
            background: var(--hud-bg);
            overflow: hidden;
        }

        /* Top angled corners */
        .match-hud__top-corners {
            position: absolute;
            inset: 0 0 auto 0;
            height: 52px;
            pointer-events: none;
        }

        .match-hud__corner {
            position: absolute;
            top: 0;
            width: 52px;
            height: 52px;
            background: var(--hud-dark);
        }

        .match-hud__corner--left {
            left: 0;
            clip-path: polygon(0 0, 100% 0, 0 100%);
        }

        .match-hud__corner--right {
            right: 0;
            clip-path: polygon(0 0, 100% 0, 100% 100%);
        }

        /* Main top layout */
        .match-hud__top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 0 34px;
            padding-top: 0;
        }

        /* =========================================
        CENTER BLOCK
        ========================================= */
        .match-hud__center {
            position: absolute;
            left: 50%;
            top: 0;
            transform: translateX(-50%);
            width: 530px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: visible;
        }

        .match-hud__center-shape {
            position: absolute;
            inset: 0;
            display: block;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .match-hud__center-fill {
            fill: var(--hud-dark);
        }

        .match-hud__center-line-yellow {
            fill: none;
            stroke: var(--hud-yellow);
            stroke-width: 2;
            stroke-linecap: square;
            stroke-linejoin: miter;
        }

        .match-hud__center-inner {
            position: relative;
            z-index: 1;
            width: 85%;
            height: 100%;
            padding: 10px 44px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: var(--hud-white);
            text-align: center;
            text-transform: uppercase;
            margin-top: -5px;
        }

        .match-hud__brand,
        .match-hud__season {
            font-size: 18px;
            line-height: 0.95;
        }

        .match-hud__logo {
            height: 100%;
        }

        .match-hud__logo img {
            height: 90%;
            margin-top: -3px;
            width: auto;
        }

        /* =========================================
        TEAM PANELS
        ========================================= */
        .team-score {
            margin-top: 50px;
            display: flex;
            align-items: center;
            gap: 8px;
            width: 560px;
        }

        .team-score--right {
            justify-content: flex-end;
        }

        /* Ban block */
        .team-score__ban {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .team-score__ban-box {
            width: 54px;
            height: 54px;
            background: var(--hud-dark);
            border: 2px solid var(--hud-yellow);
        }

        .team-score__ban-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .team-score__ban-text {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--hud-dark);
            font-size: 17px;
            line-height: 0.85;
            text-transform: uppercase;
        }

        /* Main score bar */
        .team-score__bar {
            height: 56px;
            min-width: 0;
            display: flex;
            align-items: stretch;
            background: var(--hud-dark);
            color: var(--hud-white);
            flex: 1;
        }

        .team-score__name {
            flex: 1;
            min-width: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 15px;
            font-size: 27px; /* starting size */
            line-height: 1;
            text-transform: uppercase;
            white-space: nowrap;
            overflow: hidden;
            font-family: sans-serif;
            font-weight: 800;
        }

        /* Score block */
        .team-score__score {
            width: 78px;
            flex: 0 0 78px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--hud-yellow);
            color: var(--hud-white);
            font-size: 26px;
            line-height: 1;
            position: relative;
            overflow: hidden;
        }

        .score_number {
            transform: skewX(-35deg);
        }

        .team-score__score.left {
            transform: skewX(35deg);
            left: 20px;
        }

        .team-score__score.right {
            transform: skewX(-35deg);
            right: 20px;
        }

        .team-score__score.right .score_number {
           transform: skewX(35deg); 
        }

        /* Left layout: name then score */
        .team-score--left .team-score__bar {
            flex-direction: row;
        }

        /* Right layout: score then name */
        .team-score--right .team-score__bar {
            flex-direction: row;
            padding-right: 0;
        }

        .team-score--right .team-score__name {
            justify-content: center;
            padding-left: 0;
        }

        /* Optional page guide area */
        .match-hud::after {
            content: "";
            position: absolute;
            top: 110px;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
        }
    </style>
    <script>
        function fitTeamNames() {
            const names = document.querySelectorAll('.team-score__name');

            names.forEach(el => {
                const maxFont = 27;
                const minFont = 12;

                // reset first, so recalculation works on resize too
                el.style.fontSize = maxFont + 'px';

                while (el.scrollWidth > el.clientWidth && parseFloat(getComputedStyle(el).fontSize) > minFont) {
                    const current = parseFloat(getComputedStyle(el).fontSize);
                    el.style.fontSize = (current - 1) + 'px';
                }
            });
        }

        window.addEventListener('load', fitTeamNames);
        window.addEventListener('resize', fitTeamNames);
    </script>
</body>
</html>