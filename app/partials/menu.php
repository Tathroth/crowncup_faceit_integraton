<div class="header_menu">
    <div class="header_menu__branding">
        <a href="/index.php"><img src="/assets/cc_logo_v2.png" alt="Crown Cup Logo"></a>
    </div>
    <div class="header_menu__menu">
        <ul>
            <li><a href="/index.php">Front page</a></li>
            <li><a href="/tournament.php">Tournaments</a></li>
            <?php if (isLoggedIn()) : ?>
                <li><a href="/dashboard.php">Dashboard</a></li>
                <li><a href="/logout.php">Log out</a></li>
            <?php else : ?>
                <li><a href="/login.php">Log in</a></li>
            <?php endif; ?>
            <li><a href="https://drive.google.com/file/d/1fQ3_0jSb8GTL_cNFwV0KO9pvkl63vdP3/view" target="_blank">Rules</a></li>
        </ul>
    </div>
</div>