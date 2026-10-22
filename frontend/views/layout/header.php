<?php
$menu = get_menu_by_slug(slug: 'main');
$logo = get_global_logo();
?>

<header data-layout="header">
    <a class="logo-link" href="<?= esc_url(home_url('/')) ?>" aria-label="Zur Startseite">
        <img class="logo" src="<?= $logo['src'] ?>" alt="<?= $logo['alt'] ?>" />
    </a>
    <nav class="nav-container">
        <ul class="nav">
            <?php foreach ($menu as $item): ?>
                <li class="nav-item">
                    <a target="<?= $item['target'] ?>" href="<?= $item['url'] ?>">
                        <?= $item['title'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>