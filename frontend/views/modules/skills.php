<?php $d = $args['data']; ?>
<section data-module="skills">
    <div class="title-wrap">
        <h2><?= esc_html($d['title']) ?></h2>
        <?php if (!empty($d['script'])) : ?><span class="script"><?= esc_html($d['script']) ?></span><?php endif; ?>
    </div>

    <ul class="staerken" aria-label="Stärken">
        <?php foreach ($d['staerken'] as $wort) : ?><li><?= esc_html($wort) ?></li><?php endforeach; ?>
    </ul>

    <div class="skill-cards">
        <?php foreach ($d['gruppen'] as $g) : ?>
            <article class="skill-card">
                <h3><?= esc_html($g['titel']) ?></h3>
                <ul class="tools">
                    <?php foreach ($g['punkte'] as $punkt) : ?><li><?= esc_html($punkt) ?></li><?php endforeach; ?>
                </ul>
            </article>
        <?php endforeach; ?>
    </div>

    <div class="skill-lists">
        <div class="leise">
            <h3>Ausserdem</h3>
            <dl>
                <?php foreach ($d['leise'] as $i) : ?><dt><?= esc_html($i['label']) ?></dt><dd><?= esc_html($i['wert']) ?></dd><?php endforeach; ?>
            </dl>
        </div>
        <div class="qualis">
            <h3>Qualifikationen</h3>
            <dl>
                <?php foreach ($d['qualis'] as $i) : ?><dt><?= esc_html($i['jahr']) ?></dt><dd><?= esc_html($i['titel']) ?></dd><?php endforeach; ?>
            </dl>
        </div>
    </div>
</section>
