<?php
$d = $args['data'];
$status = isset($_GET['kontakt']) ? sanitize_key(wp_unslash($_GET['kontakt'])) : '';
$status_text = [
    'gesendet' => 'Danke, deine Nachricht ist angekommen. Ich melde mich bei dir.',
    'fehler' => 'Das hat leider nicht geklappt. Bitte versuch es nochmals oder melde dich über LinkedIn oder Instagram.',
][$status] ?? '';

// Social-Icons in Espresso (Glyphen ohne Hintergrund, passend zu den Kacheln)
$icons = [
    'linkedin' => '<svg viewBox="6 6 36 36" width="34" height="34" fill="currentColor" aria-hidden="true"><circle cx="10.9" cy="10.4" r="4.1"/><rect x="7.3" y="18.2" width="7.2" height="23.1"/><path d="M19 18.2h6.6v3.1c1.4-2.2 4-3.7 7.2-3.7 6 0 9.7 3.9 9.7 10.5v13.2h-7.1V29.6c0-3-1.3-4.8-3.9-4.8-2.8 0-4.4 1.9-4.4 4.8v11.7H19z"/></svg>',
    'instagram' => '<svg viewBox="6 6 36 36" width="34" height="34" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="10" y="10" width="28" height="28" rx="8"/><circle cx="24" cy="24" r="6.5"/><circle cx="31.8" cy="16.2" r="1.9" fill="currentColor" stroke="none"/></svg>',
];
?>
<section data-module="kontaktformular">
    <?php if (!empty($d['socials'])) : ?>
        <ul class="kontakt-socials" aria-label="Weitere Kontaktmöglichkeiten">
            <?php foreach ($d['socials'] as $s) :
                $key = '';
                foreach (array_keys($icons) as $k) {
                    if (stripos($s['title'] . ' ' . $s['link'], $k) !== false) { $key = $k; break; }
                }
                ?>
                <li>
                    <a class="social-tile <?= $key ? '' : 'is-text' ?>" href="<?= esc_url($s['link']) ?>" target="_blank" rel="noopener" aria-label="<?= esc_attr($s['title']) ?>">
                        <?= $key ? $icons[$key] : esc_html($s['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form class="card-form" id="kontakt-form" method="post" action="<?= esc_url(admin_url('admin-post.php')) ?>" data-contact>
        <h2>Nachricht senden</h2>
        <?php if ($d['text']) : ?><p><?= nl2br(esc_html($d['text'])) ?></p><?php endif; ?>
        <input type="hidden" name="action" value="<?= esc_attr(PORTFOLIO_CONTACT_ACTION) ?>">
        <input type="hidden" name="_nonce" value="<?= esc_attr(wp_create_nonce(PORTFOLIO_CONTACT_ACTION)) ?>">
        <div class="hp" aria-hidden="true"><label for="k-web">Website</label><input id="k-web" name="website" type="text" tabindex="-1" autocomplete="off"></div>
        <label for="k-name">Name</label><input id="k-name" name="name" type="text" autocomplete="name" maxlength="100" required>
        <label for="k-mail">E-Mail</label><input id="k-mail" name="mail" type="email" autocomplete="email" required>
        <label for="k-msg">Nachricht</label><textarea id="k-msg" name="msg" rows="5" maxlength="5000" required></textarea>
        <button type="submit" class="submit">Senden</button>
        <p class="form-status <?= $status === 'fehler' ? 'is-error' : '' ?>" role="status" aria-live="polite"><?= esc_html($status_text) ?></p>
        <p class="hint">Deine Nachricht kommt direkt bei mir an.</p>
    </form>
</section>
