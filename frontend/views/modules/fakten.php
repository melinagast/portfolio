<?php $d = $args['data']; ?>
<section data-module="fakten">
    <h2><?= esc_html($d['title']) ?></h2>
    <dl><?php foreach ($d['items'] as $i) : ?><dt><?= esc_html($i['label']) ?></dt><dd><?= esc_html($i['wert']) ?></dd><?php endforeach; ?></dl>
</section>
