<?php
$p = get_project_by_id(get_the_ID());
$next = get_project_navigation(get_the_ID());
$has_result = $p['ergebnis_bild'] || $p['ergebnis_karten'];
$has_process = $p['prozess_bild'] || $p['prozess_text'] || $p['prozess_schritte'];
?>
<main data-page="project">
    <section class="project-head">
        <span class="bignum"><?= esc_html($p['nummer']) ?></span>
        <?php if ($p['schriftzug']) : ?><span class="script"><?= esc_html($p['schriftzug']) ?></span><?php endif; ?>
        <h1 class="title"><?= esc_html($p['title']) ?></h1>
        <p class="tags"><?= esc_html(implode(' · ', array_column($p['disziplinen'], 'name'))) ?></p>
        <p class="kurzbeschreibung"><?= esc_html($p['kurzbeschreibung']) ?></p>
        <dl class="meta">
            <?php if ($p['rolle']) : ?><dt>Rolle</dt><dd><?= esc_html($p['rolle']) ?></dd><?php endif; ?>
            <?php if ($p['mitarbeit']) : ?><dt>Mitarbeit</dt><dd><?= esc_html($p['mitarbeit']) ?></dd><?php endif; ?>
        </dl>
        <?php if ($p['vorschaubild']) : ?>
            <img class="vorschaubild" src="<?= esc_url($p['vorschaubild']['src']) ?>" alt="<?= esc_attr($p['vorschaubild']['alt']) ?>">
        <?php endif; ?>
    </section>

    <section class="project-intro">
        <div class="einleitung"><?= $p['einleitung'] ?></div>
        <?php if ($p['aufgaben']) : ?>
            <div><h2>Aufgaben</h2>
            <ul class="aufgaben"><?php foreach ($p['aufgaben'] as $i) : ?><li><?= esc_html($i['aufgabe']) ?></li><?php endforeach; ?></ul></div>
        <?php endif; ?>
    </section>

    <?php if ($p['links']) : ?>
        <section class="project-links">
            <?php foreach ($p['links'] as $l) : ?>
                <a class="button" href="<?= esc_url($l['url']) ?>" target="_blank" rel="noopener"><?= esc_html($l['titel']) ?> ↗</a>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <?php if ($has_result || $has_process) : ?>
    <section class="project-tabs" data-tabs>
        <div class="toggle" role="tablist">
            <?php if ($has_result) : ?><button type="button" class="pill active" data-tab="ergebnis">Ergebnis</button><?php endif; ?>
            <?php if ($has_process) : ?><button type="button" class="pill <?= $has_result ? '' : 'active' ?>" data-tab="prozess">Prozess</button><?php endif; ?>
        </div>
        <?php if ($has_result) : ?>
        <div class="panel" data-panel="ergebnis">
            <?php if ($p['ergebnis_bild']) : ?><img src="<?= esc_url($p['ergebnis_bild']['src']) ?>" alt="<?= esc_attr($p['ergebnis_bild']['alt']) ?>"><?php endif; ?>
            <div class="cards"><?php foreach ($p['ergebnis_karten'] as $c) : ?>
                <article class="karte"><h3><?= esc_html($c['title']) ?></h3><p><?= esc_html($c['text']) ?></p></article>
            <?php endforeach; ?></div>
        </div>
        <?php endif; ?>
        <?php if ($has_process) : ?>
        <div class="panel" data-panel="prozess" <?= $has_result ? 'hidden' : '' ?>>
            <?php if ($p['prozess_bild']) : ?><img src="<?= esc_url($p['prozess_bild']['src']) ?>" alt="<?= esc_attr($p['prozess_bild']['alt']) ?>"><?php endif; ?>
            <?php if ($p['prozess_text']) : ?><p><?= esc_html($p['prozess_text']) ?></p><?php endif; ?>
            <ol class="schritte"><?php foreach ($p['prozess_schritte'] as $s) : ?><li><?= esc_html($s['schritt']) ?></li><?php endforeach; ?></ol>
        </div>
        <?php endif; ?>
    </section>
    <?php endif; ?>

    <?php if ($next) : ?>
        <a class="next-project" href="<?= esc_url($next['link']) ?>"><small>Nächstes Projekt</small><span><?= esc_html($next['title']) ?> →</span></a>
    <?php endif; ?>
</main>
