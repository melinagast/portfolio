<?php
$d = $args['data'];
$res = $pro = null; $res_p = $pro_p = null;
foreach ($d['projects'] as $p) {
    if (!$res && $p['ergebnis_bild']) { $res = $p['ergebnis_bild']; $res_p = $p; }
    if (!$pro && $p['prozess_bild']) { $pro = $p['prozess_bild']; $pro_p = $p; }
}
$count = count($d['projects']);
?>
<section data-module="projekte_archiv">
    <div class="title-wrap">
        <h1 class="title"><?= esc_html($d['title']) ?></h1>
        <?php if (!empty($d['script'])) : ?><span class="script"><?= esc_html($d['script']) ?></span><?php endif; ?>
    </div>
    <p class="intro"><?= esc_html(!empty($d['text']) ? $d['text'] : $count . ' Projekte aus Web, Film, Audio, Branding, Raum und Illustration. Zu jedem gibt es das Ergebnis und den Prozess dahinter.') ?></p>
    <div class="filter" data-filter>
        <button type="button" class="pill active" data-term="all" aria-pressed="true">Alle</button>
        <?php foreach ($d['disziplinen'] as $t) : ?>
            <button type="button" class="pill" data-term="<?= esc_attr($t['slug']) ?>" aria-pressed="false"><?= esc_html($t['name']) ?></button>
        <?php endforeach; ?>
    </div>
    <div class="project-grid">
        <?php foreach ($d['projects'] as $p) : get_template_part('frontend/views/modules/_card', null, ['p' => $p, 'detail' => true]); endforeach; ?>
    </div>
</section>
<section class="ergebnis-band">
    <div class="text">
        <h2>Ergebnis <em>oder</em> Prozess?</h2>
        <p>In jeder Case Study wählst du selbst: Das Ergebnis zeigt, was entstanden ist. Der Prozess zeigt Moodboards, Skizzen und Varianten davor.</p>
    </div>
    <div class="tiles">
        <a class="project-card" href="<?= esc_url($res_p ? $res_p['link'] : home_url('/projekte/')) ?>">
            <?php if ($res) : ?><img src="<?= esc_url($res['src']) ?>" alt="Ergebnis"><?php else : ?><span class="img-ph" aria-hidden="true"></span><?php endif; ?>
            <b>Ergebnis</b>
        </a>
        <a class="project-card" href="<?= esc_url($pro_p ? $pro_p['link'] : home_url('/projekte/')) ?>">
            <?php if ($pro) : ?><img src="<?= esc_url($pro['src']) ?>" alt="Prozess"><?php else : ?><span class="img-ph" aria-hidden="true"></span><?php endif; ?>
            <b>Prozess</b>
        </a>
    </div>
</section>
