<?php $d = $args['data']; ?>
<section data-module="seitenkopf">
    <h1><?= esc_html($d['title']) ?></h1>
    <?php if ($d['script']) : ?><span class="script"><?= esc_html($d['script']) ?></span><?php endif; ?>
    <?php if ($d['text']) : ?><p><?= nl2br(esc_html($d['text'])) ?></p><?php endif; ?>
</section>
