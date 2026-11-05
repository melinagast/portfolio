<?php $d = $args['data']; ?>
<section data-module="projekte_teaser">
    <div class="head">
        <h2><?= esc_html($d['title']) ?></h2>
        <a class="pill-link" href="<?= esc_url(home_url($d['button_link'])) ?>"><?= esc_html($d['button_text']) ?></a>
    </div>
    <div class="project-grid">
        <?php foreach ($d['projects'] as $p) : get_template_part('frontend/views/modules/_card', null, ['p' => $p, 'detail' => false]); endforeach; ?>
    </div>
</section>
