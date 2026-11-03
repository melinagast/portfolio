<?php $d = $args['data']; ?>
<section data-module="zeitleiste">
    <h2><?= esc_html($d['title']) ?></h2>
    <ol>
        <?php foreach ($d['items'] as $i) : ?>
            <li><span class="jahr"><?= esc_html($i['jahr']) ?></span>
                <div><h3><?= esc_html($i['titel']) ?></h3>
                <?php if ($i['ort']) : ?><p class="ort"><?= esc_html($i['ort']) ?></p><?php endif; ?>
                <?php if ($i['text']) : ?><p><?= nl2br(esc_html($i['text'])) ?></p><?php endif; ?></div></li>
        <?php endforeach; ?>
    </ol>
</section>
