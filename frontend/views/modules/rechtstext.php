<?php $d = $args['data']; ?>
<section data-module="rechtstext">
    <?php foreach ($d['items'] as $i) : ?>
        <div class="block">
            <h2><?= esc_html($i['titel']) ?></h2>
            <div class="body">
                <?php foreach (preg_split('/\R{2,}/', trim($i['text'])) as $para) : ?><p><?= nl2br(esc_html($para)) ?></p><?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</section>
