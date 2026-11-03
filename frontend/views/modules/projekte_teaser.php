<?php $d = $args['data']; ?>
<section data-module="projekte_teaser">
    <h2><?= esc_html($d['title']) ?></h2>
    <ul class="list">
        <?php foreach ($d['projects'] as $p) : ?>
            <li>
                <a href="<?= esc_url($p['link']) ?>">
                    <span class="nummer"><?= esc_html($p['nummer']) ?></span>
                    <span class="name"><?= esc_html($p['title']) ?></span>
                    <span class="tags"><?= esc_html(implode(' · ', array_column($p['disziplinen'], 'name'))) ?></span>
                </a>
                <?php if ($p['vorschaubild']) : ?>
                    <img src="<?= esc_url($p['vorschaubild']['src']) ?>" alt="<?= esc_attr($p['vorschaubild']['alt']) ?>" loading="lazy">
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <a class="button" href="<?= esc_url(home_url($d['button_link'])) ?>"><?= esc_html($d['button_text']) ?></a>
</section>
