<div class="header_menu">
    <div class="header_menu__branding">
        <a href="/index.php"><img src="/assets/cc_logo.png" alt="Crown Cup Logo"></a>
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
            <li><a href="/assets/Crown Cup S4 Rulebook.pdf" target="_blank">Rules</a></li>
        </ul>
    </div>
</div>