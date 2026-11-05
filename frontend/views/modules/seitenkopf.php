<?php
$d = $args['data'];
$paras = $d['text'] ? preg_split('/\R{2,}/', trim($d['text'])) : [];
$bild = $d['bild'] ?? null;
?>
<section data-module="seitenkopf" class="<?= $bild ? 'has-portrait' : '' ?>">
    <?php if ($bild) : ?>
        <div class="portrait"><img src="<?= esc_url($bild['src']) ?>" alt="<?= esc_attr($bild['alt']) ?>"></div>
    <?php endif; ?>
    <div class="body">
        <div class="title-wrap">
            <h1><?= esc_html($d['title']) ?></h1>
            <?php if ($d['script']) : ?><span class="script"><?= esc_html($d['script']) ?></span><?php endif; ?>
        </div>
        <?php foreach ($paras as $para) : ?><p><?= nl2br(esc_html($para)) ?></p><?php endforeach; ?>
    </div>
</section>
