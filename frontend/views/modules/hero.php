<?php $d = $args['data']; ?>
<section data-module="hero">
    <div class="hero-text">
        <h1 class="hero-title"><?= esc_html($d['title']) ?></h1>
        <span class="script hero-script"><?= esc_html($d['script']) ?></span>
        <?php if ($d['text']) : ?><p><?= esc_html($d['text']) ?></p><?php endif; ?>
    </div>
    <?php if (!empty($d['image'])) : ?>
        <img class="hero-image" src="<?= esc_url($d['image']['src']) ?>" alt="<?= esc_attr($d['image']['alt']) ?>">
    <?php endif; ?>
</section>
