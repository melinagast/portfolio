<?php $d = $args['data']; ?>
<section data-module="textblock">
    <?php if ($d['title']) : ?><h2><?= esc_html($d['title']) ?></h2><?php endif; ?>
    <div class="text"><?= apply_filters('the_content', $d['text']) ?></div>
</section>
