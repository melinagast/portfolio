<?php
$menu = get_menu_by_slug('legals');
$email = get_global_email();
$socials = get_global_socials();
$foot = get_global_footer();
?>
<footer data-layout="footer">
    <div class="top">
        <span class="script claim"><?= esc_html($foot['claim']) ?></span>
        <a class="button" href="<?= esc_url(home_url('/kontakt/')) ?>"><?= esc_html($foot['button']) ?></a>
    </div>
    <div class="bottom">
        <span class="copy"><span class="badge" aria-hidden="true">MG</span><?= esc_html($foot['copyright']) ?></span>
        <span class="contact">
            <a class="email" href="mailto:<?= esc_attr($email) ?>"><?= esc_html($email) ?></a>
            <?php foreach ($socials as $item) : ?>
                <a class="social" target="_blank" rel="noopener" href="<?= esc_url($item['link']) ?>" aria-label="<?= esc_attr($item['title']) ?>">
                    <?php if ($item['icon']) : ?><img src="<?= esc_url($item['icon']['src']) ?>" alt=""><?php else : ?><?= esc_html($item['title']) ?><?php endif; ?>
                </a>
            <?php endforeach; ?>
        </span>
        <ul class="legal"><?php foreach ($menu as $item) : ?><li><a href="<?= esc_url($item['url']) ?>"><?= esc_html($item['title']) ?></a></li><?php endforeach; ?></ul>
    </div>
</footer>
