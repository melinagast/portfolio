<?php
$menu = get_menu_by_slug('main');
$logo = get_global_logo();
?>
<header data-layout="header">
    <a class="logo-link" href="<?= esc_url(home_url('/')) ?>" aria-label="Zur Startseite">
        <?php if ($logo['src']) : ?><img class="logo" src="<?= esc_url($logo['src']) ?>" alt="<?= esc_attr($logo['alt']) ?>"><?php else : ?><span class="logo-text">MG</span><?php endif; ?>
    </a>
    <button type="button" class="nav-toggle" aria-label="Menü öffnen" aria-expanded="false" aria-controls="hauptmenue"><span></span><span></span><span></span></button>
    <nav class="nav-container" id="hauptmenue" aria-label="Hauptnavigation">
        <ul class="nav">
            <?php foreach ($menu as $item) : ?>
                <li class="nav-item"><a target="<?= esc_attr($item['target']) ?>" href="<?= esc_url($item['url']) ?>"><?= esc_html($item['title']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>
