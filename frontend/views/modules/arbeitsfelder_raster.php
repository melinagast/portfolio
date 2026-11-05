<?php $d = $args['data']; ?>
<section data-module="arbeitsfelder_raster">
    <h2><?= esc_html($d['title']) ?></h2>
    <?php get_template_part('frontend/views/modules/_band', null, ['felder' => $d['felder'], 'interactive' => false]); ?>
    <a class="pill-link" href="<?= esc_url(home_url($d['button_link'])) ?>"><?= esc_html($d['button_text']) ?></a>
</section>
