<?php $d = $args['data']; ?>
<section data-module="skills">
    <div class="title-wrap">
        <h2><?= esc_html($d['title']) ?></h2>
        <?php if (!empty($d['script'])) : ?><span class="script"><?= esc_html($d['script']) ?></span><?php endif; ?>
    </div>

    <?php foreach (preg_split('/\R{2,}/', trim($d['intro'])) as $para) : ?>
        <p class="skills-intro"><?= nl2br(esc_html($para)) ?></p>
    <?php endforeach; ?>

    <div class="skill-cards">
        <?php foreach ($d['gruppen'] as $g) : ?>
            <article class="skill-card">
                <h3><?= esc_html($g['titel']) ?></h3>
                <ul class="tools">
                    <?php foreach ($g['punkte'] as $punkt) : ?><li><?= esc_html($punkt) ?></li><?php endforeach; ?>
                </ul>
            </article>
        <?php endforeach; ?>

        <?php if (!empty($d['qualis'])) : ?>
            <article class="skill-card wide">
                <h3>Qualifikationen</h3>
                <ul class="tools">
                    <?php foreach ($d['qualis'] as $i) : ?><li><?= esc_html($i['titel']) ?><?php if (!empty($i['jahr'])) : ?><small><?= esc_html($i['jahr']) ?></small><?php endif; ?></li><?php endforeach; ?>
                </ul>
            </article>
        <?php endif; ?>
    </div>
</section>
