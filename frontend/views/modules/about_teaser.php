<?php $d = $args['data']; ?>
<section data-module="about_teaser">
    <div class="head"><h2><?= esc_html($d['title']) ?></h2><span class="script"><?= esc_html($d['script']) ?></span></div>
    <p><?= nl2br(esc_html($d['text'])) ?></p>
    <a class="button" href="<?= esc_url(home_url($d['button_link'])) ?>"><?= esc_html($d['button_text']) ?></a>
</section>
