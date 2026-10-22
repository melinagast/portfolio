<?php
$data = $args['data'];
?>

<section data-module="projekte_archiv">
    <h1 class="title"><?= $data['title'] ?></h1>

    <div class="project-grid">
        <?php foreach ($data['projects'] as $project) : ?>
            <a class="project-card" href="<?= esc_url($project['link']) ?>">
                <?php if ($project['vorschaubild']) : ?>
                    <img src="<?= $project['vorschaubild']['src'] ?>" alt="<?= $project['vorschaubild']['alt'] ?>">
                <?php endif; ?>

                <div class="card-head">
                    <h2><?= $project['title'] ?></h2>
                    <?php if ($project['nummer']) : ?>
                        <span class="nummer"><?= $project['nummer'] ?></span>
                    <?php endif; ?>
                </div>

                <p class="beschreibung"><?= $project['kurzbeschreibung'] ?></p>

                <?php if ($project['rolle']) : ?>
                    <p class="rolle">Rolle: <?= $project['rolle'] ?></p>
                <?php endif; ?>

                <span class="more">Case Study ansehen →</span>
            </a>
        <?php endforeach; ?>
    </div>
</section>
