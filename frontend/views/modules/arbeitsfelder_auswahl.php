<?php $d = $args['data']; ?>
<section data-module="arbeitsfelder_auswahl">
    <?php get_template_part('frontend/views/modules/_band', null, ['felder' => $d['felder'], 'interactive' => true]); ?>
    <?php foreach ($d['felder'] as $f) : ?>
        <article class="detail" id="field-<?= (int) $f['id'] ?>" hidden>
            <button type="button" class="close" data-close>Schliessen ×</button>
            <span class="script"><?= esc_html($f['schriftzug']) ?></span>
            <h2><?= esc_html($f['title']) ?></h2>
            <p><?= nl2br(esc_html($f['beschreibung'])) ?></p>
            <?php if ($f['schwerpunkte']) : ?>
                <ul class="chips"><?php foreach ($f['schwerpunkte'] as $s) : ?><li><?= esc_html($s['titel']) ?></li><?php endforeach; ?></ul>
            <?php endif; ?>
            <?php if ($f['aufgaben']) : ?>
                <ul class="points"><?php foreach ($f['aufgaben'] as $a) : ?><li><?= esc_html($a['aufgabe']) ?></li><?php endforeach; ?></ul>
            <?php endif; ?>
            <?php if ($f['projekte']) : ?>
                <p class="related">Projekte: <?php foreach ($f['projekte'] as $p) : ?><a href="<?= esc_url($p['link']) ?>"><?= esc_html($p['title']) ?></a> <?php endforeach; ?></p>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
</section>
