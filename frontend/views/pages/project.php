<?php
$project = get_project_by_id(get_the_ID());
?>

<main data-page="project">
    <section class="project-head">
        <?php if ($project['schriftzug']) : ?>
            <span class="schriftzug"><?= $project['schriftzug'] ?></span>
        <?php endif; ?>
        <h1 class="title">
            <?= $project['title'] ?>
            <span class="nummer"><?= $project['nummer'] ?></span>
        </h1>
        <p class="kurzbeschreibung"><?= $project['kurzbeschreibung'] ?></p>
        <dl class="meta">
            <dt>Rolle</dt>
            <dd><?= $project['rolle'] ?></dd>
            <dt>Mitarbeit</dt>
            <dd><?= $project['mitarbeit'] ?></dd>
        </dl>
        <?php if ($project['vorschaubild']) : ?>
            <img class="vorschaubild" src="<?= $project['vorschaubild']['src'] ?>" alt="<?= $project['vorschaubild']['alt'] ?>">
        <?php endif; ?>
    </section>

    <section class="project-intro">
        <div class="einleitung"><?= $project['einleitung'] ?></div>
        <?php if ($project['aufgaben']) : ?>
            <ul class="aufgaben">
                <?php foreach ($project['aufgaben'] as $item) : ?>
                    <li><?= $item['aufgabe'] ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>

    <?php if ($project['ergebnis_bild'] || $project['ergebnis_karten']) : ?>
        <section class="project-ergebnis">
            <?php if ($project['ergebnis_bild']) : ?>
                <img src="<?= $project['ergebnis_bild']['src'] ?>" alt="<?= $project['ergebnis_bild']['alt'] ?>">
            <?php endif; ?>
            <?php foreach ($project['ergebnis_karten'] as $card) : ?>
                <article class="karte">
                    <h3><?= $card['title'] ?></h3>
                    <p><?= $card['text'] ?></p>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <?php if ($project['prozess_bild'] || $project['prozess_text'] || $project['prozess_schritte']) : ?>
        <section class="project-prozess">
            <?php if ($project['prozess_bild']) : ?>
                <img src="<?= $project['prozess_bild']['src'] ?>" alt="<?= $project['prozess_bild']['alt'] ?>">
            <?php endif; ?>
            <?php if ($project['prozess_text']) : ?>
                <p><?= $project['prozess_text'] ?></p>
            <?php endif; ?>
            <?php if ($project['prozess_schritte']) : ?>
                <ol class="schritte">
                    <?php foreach ($project['prozess_schritte'] as $step) : ?>
                        <li><?= $step['schritt'] ?></li>
                    <?php endforeach; ?>
                </ol>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</main>