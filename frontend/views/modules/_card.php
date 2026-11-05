<?php
// Projekt-Karte: $args['p'], $args['detail'] (Rolle + Link-Text anzeigen)
$p = $args['p'];
$detail = !empty($args['detail']);
?>
<a class="project-card" href="<?= esc_url($p['link']) ?>" data-terms="<?= esc_attr(implode(' ', array_column($p['disziplinen'], 'slug'))) ?>">
    <?php if ($p['vorschaubild']) : ?>
        <img src="<?= esc_url($p['vorschaubild']['src']) ?>" alt="<?= esc_attr($p['vorschaubild']['alt'] ?: $p['title']) ?>" loading="lazy">
    <?php else : ?>
        <span class="img-ph" aria-hidden="true"></span>
    <?php endif; ?>
    <div class="card-head">
        <h2><?= esc_html($p['title']) ?></h2>
        <span class="nummer"><?= esc_html($p['nummer']) ?></span>
    </div>
    <p class="beschreibung"><?= esc_html($p['kurzbeschreibung']) ?></p>
    <div class="card-meta">
        <?php foreach ($p['disziplinen'] as $t) : ?><span class="chip"><?= esc_html($t['name']) ?></span><?php endforeach; ?>
        <?php if ($detail && $p['rolle']) : ?><span class="rolle">Rolle: <?= esc_html($p['rolle']) ?></span><?php endif; ?>
    </div>
    <?php if ($detail) : ?><span class="more">Case Study ansehen →</span><?php endif; ?>
</a>
