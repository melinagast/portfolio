<?php
$menu = get_menu_by_slug('legals');
$logo = get_global_logo();
$email = get_global_email();
$socials = get_global_socials();
?>

<footer data-layout="footer">
    <img class="logo" src="<?= $logo['src'] ?>" alt="<?= $logo['alt'] ?>">
    <div class="socials">
        <a class="email" href="mailto:<?= $email ?>"><?= $email ?></a>
        <?php foreach ($socials as $item) : ?>
            <a target="_blank" href="<?= $item['link'] ?>" aria-label="Link zu <?= $item['title'] ?>">
                <img src="<?= $item['icon']['src'] ?>" alt="<?= $item['icon']['alt'] ?>">
            </a>
        <?php endforeach; ?>
    </div>
    <nav class="nav-container">
        <ul class="nav">
            <?php foreach ($menu as $item) : ?>
                <li class="nav-item">
                    <a target="<?= $item['target'] ?>" href="<?= $item['url'] ?>">
                        <?= $item['title'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</footer>