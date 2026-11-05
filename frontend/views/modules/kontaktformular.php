<?php $d = $args['data']; ?>
<section data-module="kontaktformular">
    <div class="rows">
        <div class="row"><span class="lab">E-Mail</span><a class="mail" href="mailto:<?= esc_attr($d['email']) ?>"><?= esc_html($d['email']) ?></a></div>
        <?php foreach ($d['socials'] as $s) : ?>
            <div class="row"><span class="lab"><?= esc_html($s['title']) ?></span><a href="<?= esc_url($s['link']) ?>" target="_blank" rel="noopener"><?= esc_html(preg_replace('#^https?://(www\.)?#', '', rtrim($s['link'], '/'))) ?></a></div>
        <?php endforeach; ?>
    </div>
    <form class="card-form" data-mailto="<?= esc_attr($d['email']) ?>">
        <h2>Nachricht senden</h2>
        <?php if ($d['text']) : ?><p><?= nl2br(esc_html($d['text'])) ?></p><?php endif; ?>
        <label for="k-name">Name</label><input id="k-name" name="name" type="text" autocomplete="name" required>
        <label for="k-mail">E-Mail</label><input id="k-mail" name="mail" type="email" autocomplete="email" required>
        <label for="k-msg">Nachricht</label><textarea id="k-msg" name="msg" rows="5" required></textarea>
        <button type="submit" class="submit">Senden</button>
        <p class="hint">Beim Senden öffnet sich dein E-Mail-Programm mit dem fertigen Text.</p>
    </form>
</section>
