<?php
/**
 * Einmaliger Bildimport: legt die Dateien aus ./bilder in die Mediathek
 * und setzt sie als Vorschaubild des gleichnamigen Projekts.
 * Aufruf (nur als eingeloggte Admin-Person): /wp-admin/?bilder_import=1
 * Vorhandene Vorschaubilder bleiben unberührt, ein zweiter Aufruf ist harmlos.
 */
add_action('admin_init', function () {
    if (empty($_GET['bilder_import']) || !current_user_can('manage_options')) {
        return;
    }
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $out = [];
    $projects = get_posts(['post_type' => 'project', 'numberposts' => -1, 'post_status' => 'any']);
    foreach (glob(__DIR__ . '/bilder/*.jpg') as $file) {
        $slug = basename($file, '.jpg');
        $target = null;
        foreach ($projects as $p) {
            $t = str_replace('amp', '', sanitize_title($p->post_title));
            if ($t === $slug || $p->post_name === $slug) { $target = $p; break; }
        }
        if (!$target) { $out[] = "$slug: kein passendes Projekt gefunden"; continue; }
        if (get_post_meta($target->ID, '_vorschaubild', true)) { $out[] = "$slug: hat schon ein Bild, übersprungen"; continue; }

        $tmp = wp_tempnam($file);
        copy($file, $tmp);
        $id = media_handle_sideload(['name' => $slug . '.jpg', 'tmp_name' => $tmp], $target->ID, $target->post_title);
        if (is_wp_error($id)) { @unlink($tmp); $out[] = "$slug: Fehler " . $id->get_error_message(); continue; }
        update_post_meta($id, '_wp_attachment_image_alt', $target->post_title);
        update_post_meta($target->ID, '_vorschaubild', $id);
        $out[] = "$slug: importiert (Mediathek-ID $id)";
    }
    wp_die('<pre>' . esc_html(implode("\n", $out ?: ['keine Bilder gefunden'])) . '</pre>', 'Bildimport', ['response' => 200]);
});
