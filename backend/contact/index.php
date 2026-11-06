<?php
/**
 * Kontaktformular: verschickt die Nachricht direkt per E-Mail an die Adresse
 * aus «Globales». Es wird nichts in der Datenbank gespeichert.
 *
 * Ablauf: Formular (frontend/views/modules/kontaktformular.php) sendet per POST
 * an admin-post.php (action=portfolio_contact). Mit JavaScript antwortet der
 * Handler mit JSON, ohne JavaScript leitet er zurück auf die Kontaktseite.
 */

const PORTFOLIO_CONTACT_ACTION = 'portfolio_contact';
const PORTFOLIO_CONTACT_MAX_PER_WINDOW = 3;      // Nachrichten pro Absender
const PORTFOLIO_CONTACT_WINDOW = 10 * MINUTE_IN_SECONDS;

// -> Antwort an den Browser (JSON bei JavaScript, sonst Weiterleitung)
function portfolio_contact_respond (bool $ok, string $message, bool $ajax): void {
    if ($ajax) {
        $ok ? wp_send_json_success(['message' => $message]) : wp_send_json_error(['message' => $message]);
    }
    $back = wp_get_referer() ?: home_url('/kontakt/');
    $back = remove_query_arg('kontakt', $back);
    wp_safe_redirect(add_query_arg('kontakt', $ok ? 'gesendet' : 'fehler', $back) . '#kontakt-form');
    exit;
}

// -> Nachricht prüfen und verschicken
function portfolio_contact_handle (): void {
    $ajax = !empty($_POST['ajax']);

    if (!isset($_POST['_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_nonce'])), PORTFOLIO_CONTACT_ACTION)) {
        portfolio_contact_respond(false, 'Die Seite war zu lange offen. Bitte lade sie neu und sende die Nachricht nochmals.', $ajax);
    }

    // Honeypot: Menschen sehen dieses Feld nicht, Bots füllen es aus
    if (!empty($_POST['website'])) {
        portfolio_contact_respond(true, 'Danke, deine Nachricht ist angekommen.', $ajax);
    }

    $name = trim(wp_strip_all_tags(sanitize_text_field(wp_unslash($_POST['name'] ?? ''))));
    $mail = sanitize_email(wp_unslash($_POST['mail'] ?? ''));
    $msg = trim(sanitize_textarea_field(wp_unslash($_POST['msg'] ?? '')));

    if ($name === '' || $msg === '' || !is_email($mail)) {
        portfolio_contact_respond(false, 'Bitte fülle Name, E-Mail und Nachricht aus.', $ajax);
    }
    if (mb_strlen($name) > 100 || mb_strlen($msg) > 5000) {
        portfolio_contact_respond(false, 'Dein Name oder deine Nachricht ist zu lang.', $ajax);
    }

    // Einfache Bremse gegen Mehrfachversand (pro Absender-Adresse, ohne IP im Klartext)
    $key = 'pf_contact_' . md5(($_SERVER['REMOTE_ADDR'] ?? '') . wp_salt());
    $count = (int) get_transient($key);
    if ($count >= PORTFOLIO_CONTACT_MAX_PER_WINDOW) {
        portfolio_contact_respond(false, 'Du hast gerade mehrere Nachrichten gesendet. Bitte versuch es in ein paar Minuten nochmals.', $ajax);
    }

    $to = get_global_email();
    if (!is_email($to)) {
        portfolio_contact_respond(false, 'Das Formular ist im Moment nicht erreichbar. Bitte melde dich über LinkedIn oder Instagram.', $ajax);
    }

    $subject = 'Nachricht über melinagast.ch von ' . $name;
    $body = $msg . "\n\n--\n" . $name . "\n" . $mail;
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . str_replace(['<', '>', ',', '"'], '', $name) . ' <' . $mail . '>',
    ];

    $from_name = fn() => 'melinagast.ch';
    add_filter('wp_mail_from_name', $from_name);
    $sent = wp_mail($to, $subject, $body, $headers);
    remove_filter('wp_mail_from_name', $from_name);

    if (!$sent) {
        portfolio_contact_respond(false, 'Das hat leider nicht geklappt. Bitte versuch es später nochmals oder melde dich über LinkedIn oder Instagram.', $ajax);
    }

    set_transient($key, $count + 1, PORTFOLIO_CONTACT_WINDOW);
    portfolio_contact_respond(true, 'Danke, deine Nachricht ist angekommen. Ich melde mich bei dir.', $ajax);
}

add_action('admin_post_nopriv_' . PORTFOLIO_CONTACT_ACTION, 'portfolio_contact_handle');
add_action('admin_post_' . PORTFOLIO_CONTACT_ACTION, 'portfolio_contact_handle');
