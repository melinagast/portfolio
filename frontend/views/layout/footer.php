<?php
$menu = get_menu_by_slug('legals');
$logo = get_global_logo();
$email = get_global_email();
$socials = get_global_socials();
$foot = get_global_footer();
?>
<footer data-layout="footer">
    <span class="script claim"><?= esc_html($foot['claim']) ?></span>
    <a class="button" href="mailto:<?= esc_attr($email) ?>"><?= esc_html($foot['button']) ?></a>
    <div class="row">
        <?php if ($logo['src']) : ?><img class="logo" src="<?= esc_url($logo['src']) ?>" alt="<?= esc_attr($logo['alt']) ?>"><?php endif; ?>
        <div class="socials">
            <a class="email" href="mailto:<?= esc_attr($email) ?>"><?= esc_html($email) ?></a>
            <?php foreach ($socials as $item) : ?>
                <a target="_blank" rel="noopener" href="<?= esc_url($item['link']) ?>" aria-label="<?= esc_attr($item['title']) ?>">
                    <?php if ($item['icon']) : ?><img src="<?= esc_url($item['icon']['src']) ?>" alt=""><?php else : ?><?= esc_html($item['title']) ?><?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="row small">
        <span><?= esc_html($foot['copyright']) ?></span>
        <ul class="nav"><?php foreach ($menu as $item) : ?><li><a href="<?= esc_url($item['url']) ?>"><?= esc_html($item['title']) ?></a></li><?php endforeach; ?></ul>
    </div>
</footer>
