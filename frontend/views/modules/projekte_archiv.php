<?php $d = $args['data']; ?>
<section data-module="projekte_archiv">
    <h1 class="title"><?= esc_html($d['title']) ?></h1>
    <div class="filter" data-filter>
        <button type="button" class="pill active" data-term="all">Alle</button>
        <?php foreach ($d['disziplinen'] as $t) : ?>
            <button type="button" class="pill" data-term="<?= esc_attr($t['slug']) ?>"><?= esc_html($t['name']) ?></button>
        <?php endforeach; ?>
    </div>
    <div class="project-grid">
        <?php foreach ($d['projects'] as $p) : ?>
            <a class="project-card" href="<?= esc_url($p['link']) ?>" data-terms="<?= esc_attr(implode(' ', array_column($p['disziplinen'], 'slug'))) ?>">
                <?php if ($p['vorschaubild']) : ?>
                    <img src="<?= esc_url($p['vorschaubild']['src']) ?>" alt="<?= esc_attr($p['vorschaubild']['alt']) ?>" loading="lazy">
                <?php endif; ?>
                <div class="card-head">
                    <span class="nummer"><?= esc_html($p['nummer']) ?></span>
                    <h2><?= esc_html($p['title']) ?></h2>
                </div>
                <p class="tags"><?= esc_html(implode(' · ', array_column($p['disziplinen'], 'name'))) ?></p>
                <p class="beschreibung"><?= esc_html($p['kurzbeschreibung']) ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</section>
