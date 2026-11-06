<?php
/**
 * Einmaliger Import der Projektseiten-Inhalte: Ergebnis-/Prozessbilder, Ergebnis-Karten, Prozess-Texte.
 * Aufruf (nur als eingeloggte Admin-Person): /wp-admin/?seiten_import=1
 * Bereits gepflegte Texte bleiben unberührt; Bilder aus früheren Importen werden ersetzt.
 */
add_action('admin_init', function () {
    if (empty($_GET['seiten_import']) || !current_user_can('manage_options')) {
        return;
    }
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $daten = require __DIR__ . '/daten.php';
    $out = [];
    $projects = get_posts(['post_type' => 'project', 'numberposts' => -1, 'post_status' => 'any']);
    foreach ($daten as $slug => $d) {
        $target = null;
        foreach ($projects as $p) {
            $t = str_replace('amp', '', sanitize_title($p->post_title));
            if ($t === $slug || $p->post_name === $slug) { $target = $p; break; }
        }
        if (!$target) { $out[] = "$slug: kein Projekt gefunden"; continue; }
        $pid = $target->ID;

        foreach (['ergebnis' => 'ergebnis_bild', 'prozess' => 'prozess_bild'] as $typ => $feld) {
            $file = __DIR__ . "/projektbilder/$slug-$typ.jpg";
            if (!file_exists($file)) continue;
            $old = (int) get_post_meta($pid, '_' . $feld, true);
            if ($old && strpos(basename((string) get_attached_file($old)), "$slug-$typ") !== 0) { $out[] = "$slug $typ: eigenes Bild, übersprungen"; continue; }
            $tmp = wp_tempnam($file);
            copy($file, $tmp);
            $id = media_handle_sideload(['name' => "$slug-$typ.jpg", 'tmp_name' => $tmp], $pid, $target->post_title . ' – ' . $typ);
            if (is_wp_error($id)) { @unlink($tmp); $out[] = "$slug $typ: Fehler " . $id->get_error_message(); continue; }
            update_post_meta($id, '_wp_attachment_image_alt', $target->post_title . ' – ' . ($typ === 'ergebnis' ? 'Ergebnis' : 'Prozess'));
            update_post_meta($pid, '_' . $feld, $id);
            if ($old) wp_delete_attachment($old, true);
            $out[] = "$slug $typ: Bild gesetzt ($id)";
        }

        if (!empty($d['karten']) && !carbon_get_post_meta($pid, 'ergebnis_karten')) {
            $rows = array_map(fn($k) => ['_type' => '_', 'title' => $k[0], 'text' => $k[1]], $d['karten']);
            carbon_set_post_meta($pid, 'ergebnis_karten', $rows);
            $out[] = "$slug: " . count($rows) . ' Karten gesetzt';
        }
        if (!empty($d['prozess_text']) && !carbon_get_post_meta($pid, 'prozess_text')) {
            carbon_set_post_meta($pid, 'prozess_text', $d['prozess_text']);
            $out[] = "$slug: Prozess-Text gesetzt";
        }
        if (!empty($d['schritte']) && !carbon_get_post_meta($pid, 'prozess_schritte')) {
            carbon_set_post_meta($pid, 'prozess_schritte', array_map(fn($s) => ['_type' => '_', 'schritt' => $s], $d['schritte']));
            $out[] = "$slug: Prozess-Schritte gesetzt";
        }
    }
    wp_die('<pre>' . esc_html(implode("\n", $out ?: ['nichts zu tun'])) . '</pre>', 'Seitenimport', ['response' => 200]);
});
