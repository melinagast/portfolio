<?php
$p = get_project_by_id(get_the_ID());
$next = get_project_navigation(get_the_ID());
$has_result = $p['ergebnis_bild'] || $p['ergebnis_karten'];
$has_process = $p['prozess_bild'] || $p['prozess_text'] || $p['prozess_schritte'];
$longest = max(array_map('mb_strlen', preg_split('/\s+/', trim($p['title']))) ?: [5]);
$tn = min(11.8, round(105 / max($longest, 1), 2));
$sub = array_filter([implode(', ', array_column($p['disziplinen'], 'name')), $p['mitarbeit'] ?: '']);
?>
<main data-page="project">
    <section class="project-head">
        <span class="bignum" aria-hidden="true"><?= esc_html($p['nummer']) ?></span>
        <div class="head-text">
            <div class="title-wrap" style="--tn: <?= esc_attr($tn) ?>">
                <h1 class="title"><?= esc_html($p['title']) ?></h1>
                <?php if ($p['schriftzug']) : ?><span class="script"><?= esc_html($p['schriftzug']) ?></span><?php endif; ?>
            </div>
            <p class="tags"><?= esc_html(implode(' · ', $sub)) ?></p>
            <?php if ($p['rolle']) : ?><p class="rolle">Rolle: <?= esc_html($p['rolle']) ?></p><?php endif; ?>
        </div>
    </section>

    <section class="project-intro">
        <div class="einleitung"><?= $p['einleitung'] ?></div>
        <?php if ($p['aufgaben']) : ?>
            <ol class="aufgaben" aria-label="Aufgaben"><?php foreach ($p['aufgaben'] as $i) : ?><li><?= esc_html($i['aufgabe']) ?></li><?php endforeach; ?></ol>
        <?php endif; ?>
    </section>

    <?php if ($p['links']) : ?>
        <section class="project-links">
            <?php foreach ($p['links'] as $l) : ?>
                <a class="pill-link" href="<?= esc_url($l['url']) ?>" target="_blank" rel="noopener"><?= esc_html($l['titel']) ?> ↗</a>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <?php if ($has_result || $has_process) : ?>
    <section class="project-tabs" data-tabs>
        <div class="tabs-head">
            <h2><?= $has_result && $has_process ? 'Ergebnis oder Prozess' : ($has_result ? 'Ergebnis' : 'Prozess') ?></h2>
            <?php if ($has_result && $has_process) : ?>
            <div class="toggle" role="group" aria-label="Ansicht wählen">
                <button type="button" class="pill active" data-tab="ergebnis" aria-pressed="true">Ergebnis</button>
                <button type="button" class="pill" data-tab="prozess" aria-pressed="false">Prozess</button>
            </div>
            <?php endif; ?>
        </div>
        <?php if ($has_result) : ?>
        <div class="panel" data-panel="ergebnis">
            <?php if ($p['ergebnis_bild']) : ?><img src="<?= esc_url($p['ergebnis_bild']['src']) ?>" alt="<?= esc_attr($p['ergebnis_bild']['alt']) ?>"><?php endif; ?>
            <?php if ($p['ergebnis_karten']) : ?>
            <div class="cards"><?php foreach ($p['ergebnis_karten'] as $c) : ?>
                <article class="karte"><h3><?= esc_html($c['title']) ?></h3><p><?= esc_html($c['text']) ?></p></article>
            <?php endforeach; ?></div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if ($has_process) : ?>
        <div class="panel process" data-panel="prozess" <?= $has_result ? 'hidden' : '' ?>>
            <?php if ($p['prozess_bild']) : ?><img src="<?= esc_url($p['prozess_bild']['src']) ?>" alt="<?= esc_attr($p['prozess_bild']['alt']) ?>"><?php endif; ?>
            <div class="steps">
                <?php if ($p['prozess_text']) : ?><p><?= esc_html($p['prozess_text']) ?></p><?php endif; ?>
                <?php if ($p['prozess_schritte']) : ?><ol class="schritte"><?php foreach ($p['prozess_schritte'] as $s) : ?><li><?= esc_html($s['schritt']) ?></li><?php endforeach; ?></ol><?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </section>
    <?php endif; ?>

    <?php if ($next) : ?>
        <a class="next-project" href="<?= esc_url($next['link']) ?>"><small>Nächstes Projekt</small><span><?= esc_html(trim($next['nummer'] . ' ' . $next['title'])) ?> →</span></a>
    <?php endif; ?>
</main>
