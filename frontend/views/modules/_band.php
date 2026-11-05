<?php
// Gemeinsames Band: $args['felder'], $args['interactive']
$felder = $args['felder'];
$interactive = !empty($args['interactive']);
?>
<div class="marquee" data-marquee>
    <div class="marquee-track">
        <?php for ($loop = 0; $loop < 2; $loop++) : foreach ($felder as $f) : ?>
            <<?= $interactive ? 'button type="button" data-field="' . (int) $f['id'] . '"' : 'a href="' . esc_url(home_url('/arbeitsfelder/')) . '"' ?> class="tile" <?= $loop ? 'aria-hidden="true" tabindex="-1"' : '' ?>>
                <span class="box"><?php if ($f['icon']) : ?><img src="<?= esc_url($f['icon']['src']) ?>" alt=""><?php endif; ?></span>
                <span class="label"><?= esc_html($f['title']) ?></span>
            </<?= $interactive ? 'button' : 'a' ?>>
        <?php endforeach; endfor; ?>
    </div>
</div>
