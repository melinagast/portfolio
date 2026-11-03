<?php $d = $args['data']; ?>
<section data-module="kontaktformular">
    <h2><?= esc_html($d['title']) ?></h2>
    <?php if ($d['text']) : ?><p><?= nl2br(esc_html($d['text'])) ?></p><?php endif; ?>
    <p class="mail"><?= esc_html($d['email']) ?></p>
    <a class="button" href="mailto:<?= esc_attr($d['email']) ?>"><?= esc_html($d['button_text']) ?></a>
</section>
