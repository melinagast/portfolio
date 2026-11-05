<?php $d = $args['data']; ?>
<section data-module="about_teaser" class="<?= !empty($d['bild']) ? 'has-portrait' : '' ?>">
    <?php if (!empty($d['bild'])) : ?>
        <div class="portrait"><img src="<?= esc_url($d['bild']['src']) ?>" alt="<?= esc_attr($d['bild']['alt']) ?>"></div>
    <?php endif; ?>
    <div class="body">
        <h2><?= esc_html($d['title']) ?></h2>
        <p><?= nl2br(esc_html($d['text'])) ?></p>
        <a class="button pill-link" href="<?= esc_url(home_url($d['button_link'])) ?>"><?= esc_html($d['button_text']) ?></a>
    </div>
</section>
