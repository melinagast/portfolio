<?php $d = $args['data']; $has_text = !empty($d['text']); ?>
<section data-module="fakten" class="<?= $has_text ? 'two' : '' ?>">
    <div>
        <h2><?= esc_html($d['title']) ?></h2>
        <dl><?php foreach ($d['items'] as $i) : ?><dt><?= esc_html($i['label']) ?></dt><dd><?= esc_html($i['wert']) ?></dd><?php endforeach; ?></dl>
    </div>
    <?php if ($has_text) : ?>
        <div class="side">
            <p class="persoenlich"><?= nl2br(esc_html($d['text'])) ?></p>
            <?php if (!empty($d['button_text'])) : ?><a class="pill-link" href="<?= esc_url(home_url($d['button_link'])) ?>"><?= esc_html($d['button_text']) ?></a><?php endif; ?>
        </div>
    <?php endif; ?>
</section>
