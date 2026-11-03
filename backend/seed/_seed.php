<?php
/**
 * EINMALIGER Import der Startinhalte. Aufruf: /wp-admin/?mg_seed=1 (als Admin eingeloggt).
 * Danach diese Datei und die require-Zeile in functions.php wieder entfernen.
 */
require_once __DIR__ . '/_seed_texts.php';

add_action('admin_init', function () {
    if (empty($_GET['mg_seed']) || !current_user_can('manage_options')) return;
    header('Content-Type: text/plain; charset=utf-8');
    $log = [];

    // --- Disziplinen
    foreach (['Web', 'Film', 'Audio', 'Branding', 'Raum', 'Illustration'] as $t) {
        if (!term_exists($t, 'disziplin')) wp_insert_term($t, 'disziplin');
    }

    // --- Projekte (Nr. 01 = neuestes)
    $projects = [
        ['Stage Somedia', 'Stage', ['Film', 'Branding'], 'Wahlmodul bei Communicaziun', '', 'Drei Wochen in Video und Marketing, dazu das Kommunikationskonzept «Glion Run».'],
        ['Repower Social Recruiting', 'Recruit', ['Branding', 'Film'], 'Lead Design, im Team', 'im Team', 'Social-Recruiting-Strategie «Strom, ledig, sucht» mit Videoformaten und Landingpage-Prototyp.'],
        ['Bad Ragartz', 'Raum', ['Raum'], 'Konzept und Layout, im Team', 'im Team', 'Rauminszenierung für den Bahnhof Bad Ragaz zur 10. Bad Ragartz 2027.'],
        ['Multitalk Radio Calanda', 'On air', ['Audio', 'Branding'], 'Sendung und Gestaltung', '', 'Gestaltung und Betreuung einer eigenen Radiosendung, live und als Podcast.'],
        ['Soziale Fachdienste', 'Web', ['Web', 'Branding'], 'Redesign', '', 'Neues Erscheinungsbild und neuer Web-Auftritt für die Soziale Fachdienste AG.'],
        ['FHGR Merch', 'Merch', ['Branding', 'Illustration'], 'Rebranding', 'Jule Buchmann', 'Rebranding und Kollektion in drei Designlinien: Calanda, Typo und Steinbock.'],
        ['Webdesign & Informatik', 'Code', ['Web'], 'Design und Umsetzung', '', 'Webdesign von der Idee in Figma bis zur Umsetzung mit HTML, CSS und JavaScript.'],
        ['Dokumentarfilme', 'Action', ['Film'], 'Projektleitung', '', 'Projektleitung, Gespräche mit Protagonistinnen und Dramaturgie bei Dokumentarfilmen.'],
        ['Sketch & Draw', 'Draw', ['Illustration'], 'Zeichnungen', '', 'Analoge Zeichnungen mit Fokus auf Perspektive, Licht und Schatten.'],
        ['Konzept RaBe', 'Idee', ['Branding', 'Web'], 'Konzept', '', 'Kommunikationskonzept mit Branding und Web-Auftritt.'],
        ['IPA Flower Experience', 'Flowers', ['Raum'], 'Lehrabschlussarbeit (IPA)', '', 'Verkaufsfläche für den Sommerevent «Flower Experience» bei IKEA Dietlikon, von der Idee bis zur Umsetzung.'],
        ['Acne Studios', 'Style', ['Raum'], 'Raumkonzept', '', 'Gestaltungskonzept für einen Shop-in-Shop, mit Renderings und Layoutplänen.'],
    ];
    $ids = [];
    $n = count($projects);
    foreach ($projects as $i => $p) {
        $existing = get_posts(['post_type' => 'project', 'title' => $p[0], 'numberposts' => 1, 'post_status' => 'any']);
        if ($existing) { $id = $existing[0]->ID; $log[] = "Projekt vorhanden: {$p[0]}"; }
        else {
            $id = wp_insert_post([
                'post_type' => 'project', 'post_status' => 'publish', 'post_title' => $p[0],
                'post_date' => date('Y-m-d H:i:s', strtotime('2026-10-20 12:00:00') - $i * 86400),
            ]);
            $log[] = "Projekt angelegt: {$p[0]}";
        }
        $ids[$p[0]] = $id;
        wp_set_object_terms($id, $p[2], 'disziplin');
        carbon_set_post_meta($id, 'nummer', sprintf('%02d', $i + 1));
        carbon_set_post_meta($id, 'schriftzug', $p[1]);
        carbon_set_post_meta($id, 'kurzbeschreibung', $p[5]);
        carbon_set_post_meta($id, 'rolle', $p[3]);
        carbon_set_post_meta($id, 'mitarbeit', $p[4]);
        carbon_set_post_meta($id, 'einleitung', '<p>' . esc_html($p[5]) . '</p>');
    }

    // --- Arbeitsfelder
    $felder = [
        ['Web', 'online', 'Ich gestalte Websites von der ersten Skizze in Figma bis zur Umsetzung mit HTML, CSS und JavaScript. Dieses Portfolio ist ein eigenes WordPress-Theme.', ['UX und UI', 'Figma', 'HTML, CSS, JS', 'WordPress'], ['Struktur und Nutzerführung planen', 'Layouts, Typografie und Farben festlegen', 'Mit Code umsetzen und testen'], ['Soziale Fachdienste', 'Webdesign & Informatik', 'Konzept RaBe']],
        ['Film', 'action', 'Bei Dokumentarfilmen übernehme ich Projektleitung, führe Gespräche mit Protagonistinnen, arbeite an der Dramaturgie und bereite den Schnitt vor.', ['Projektleitung', 'Interviews', 'Dramaturgie', 'Schnittvorbereitung'], ['Idee und Ablauf planen', 'Gespräche führen und begleiten', 'Dramaturgie für den Schnitt entwickeln'], ['Dokumentarfilme']],
        ['Audio', 'on air', 'Ich gestalte und betreue eine eigene Radiosendung auf Radio Calanda, live und als Podcast.', ['Radio', 'Podcast', 'Live'], ['Sendungen planen und moderieren', 'Themen und Gäste vorbereiten', 'Beiträge als Podcast aufbereiten'], ['Multitalk Radio Calanda']],
        ['Branding', 'brand', 'Von Rebranding über Kommunikationskonzepte bis zu Logos, Flyern und Flaggen. Ich entwickle eine Identität, die zum Auftrag passt.', ['Rebranding', 'Konzept', 'Logo', 'Print'], ['Moodboards und Designlinien erarbeiten', 'Logos, Farben und Typografie entwerfen', 'Mockups und Präsentation vorbereiten'], ['FHGR Merch', 'Soziale Fachdienste', 'Konzept RaBe']],
        ['Raum', 'space', 'Ich entwickle Gestaltungskonzepte für Verkaufsräume und zeige sie mit Renderings und Layoutplänen.', ['Konzept', 'Rendering', 'Layoutplan'], ['Marke und Raum zusammendenken', 'Layoutpläne zeichnen', 'Renderings erstellen'], ['Acne Studios', 'Bad Ragartz', 'IPA Flower Experience']],
        ['Illustration', 'draw', 'Analoge Zeichnungen mit Fokus auf Perspektive, Licht und Schatten.', ['Skizze', 'Perspektive', 'Licht und Schatten'], ['Motive von Hand skizzieren', 'Perspektive und Proportionen üben', 'Zeichnungen in Projekten einsetzen'], ['Sketch & Draw', 'FHGR Merch']],
        ['Konzept', 'idee', 'Aus einer Idee wird ein tragfähiges Konzept: Zielgruppe, Aussage und Gestaltung hängen zusammen.', ['Kommunikation', 'Moodboards', 'Strategie'], ['Idee und Zielgruppe klären', 'Moodboards und Skizzen erarbeiten', 'Konzept präsentieren'], ['Konzept RaBe', 'Acne Studios', 'FHGR Merch']],
        ['Typografie', 'type', 'Schrift gibt einer Gestaltung Charakter. Ich setze sie bewusst ein, vom Logo bis zum Layout.', ['Schrift', 'Layout', 'Farbe'], ['Schriften auswählen und kombinieren', 'Layouts und Raster aufbauen', 'Farben abstimmen'], ['FHGR Merch', 'Soziale Fachdienste', 'Webdesign & Informatik']],
        ['Projektleitung', 'plan', 'Bei Dokumentarfilmen und Gruppenprojekten behalte ich Ablauf, Menschen und Termine im Blick.', ['Planung', 'Gespräche', 'Dramaturgie'], ['Ablauf und Termine planen', 'Gespräche mit Protagonistinnen führen', 'Dramaturgie festlegen'], ['Dokumentarfilme', 'Multitalk Radio Calanda', 'FHGR Merch']],
        ['Prototyping', 'click', 'Von der Skizze zum klickbaren Entwurf in Figma, bevor etwas gebaut wird.', ['Figma', 'Mockups', 'UX'], ['Wireframes skizzieren', 'Klickbare Prototypen in Figma bauen', 'Mit HTML, CSS und JavaScript umsetzen'], ['Webdesign & Informatik', 'Soziale Fachdienste', 'Konzept RaBe']],
    ];
    foreach ($felder as $i => $f) {
        $existing = get_posts(['post_type' => 'arbeitsfeld', 'title' => $f[0], 'numberposts' => 1, 'post_status' => 'any']);
        $id = $existing ? $existing[0]->ID : wp_insert_post(['post_type' => 'arbeitsfeld', 'post_status' => 'publish', 'post_title' => $f[0], 'menu_order' => $i]);
        $log[] = ($existing ? 'Arbeitsfeld vorhanden: ' : 'Arbeitsfeld angelegt: ') . $f[0];
        carbon_set_post_meta($id, 'schriftzug', $f[1]);
        carbon_set_post_meta($id, 'beschreibung', $f[2]);
        carbon_set_post_meta($id, 'schwerpunkte', array_map(fn($t) => ['_type' => '_', 'titel' => $t], $f[3]));
        carbon_set_post_meta($id, 'aufgaben', array_map(fn($t) => ['_type' => '_', 'aufgabe' => $t], $f[4]));
        carbon_set_post_meta($id, 'projekte', array_values(array_filter(array_map(function ($t) use ($ids) {
            return isset($ids[$t]) ? ['value' => 'post:project:' . $ids[$t], 'type' => 'post', 'subtype' => 'project', 'id' => $ids[$t]] : null;
        }, $f[5]))));
    }

    // --- Seiten mit Modulen
    $pages = [
        'Startseite' => [
            ['_type' => 'hero', 'title' => 'Portfolio', 'script' => 'Melina', 'text' => 'Multimedia Production an der FHGR. Gestaltung für Web, Film, Audio und Raum.'],
            ['_type' => 'about_teaser', 'title' => 'Über mich', 'script' => 'Hey!', 'text' => 'Ich studiere Multimedia Production an der FHGR. Meinen Weg habe ich mit einer Polydesign-Lehre begonnen. Heute gestalte ich Websites, Filme, Audioformate und Konzepte.', 'button_text' => 'Mehr über mich →', 'button_link' => '/ueber-mich/'],
            ['_type' => 'projekte_teaser', 'title' => 'Neueste Projekte', 'anzahl' => '3', 'button_text' => 'Alle Projekte →', 'button_link' => '/projekte/'],
            ['_type' => 'arbeitsfelder_raster', 'title' => 'Arbeitsfelder', 'button_text' => 'Mehr zu meinen Skills →', 'button_link' => '/arbeitsfelder/'],
        ],
        'Über mich' => [
            ['_type' => 'seitenkopf', 'title' => 'Über mich', 'script' => 'Hey!', 'text' => "Ich bin Melina Gast und studiere Multimedia Production an der FHGR. Meinen Weg habe ich mit einer Lehre als Polydesignerin 3D Styling bei IKEA begonnen. Heute gestalte ich Websites, Filme, Audioformate und Konzepte, oft gemeinsam mit meiner Kollegin Jule Buchmann.\n\nAktuell suche ich eine Stelle im Pensum von 40 oder 60 Prozent, zum Beispiel in Grafik, Social Media oder Video."],
            ['_type' => 'zeitleiste', 'title' => 'Mein Weg', 'items' => [
                ['_type' => '_', 'jahr' => '2019–2023', 'titel' => 'Polydesign-Lehre', 'ort' => '', 'text' => '3D Styling bei IKEA Dietlikon, dazu Berufsmatura Gestaltung & Kunst in Zürich.'],
                ['_type' => '_', 'jahr' => '2024–2027', 'titel' => 'Multimedia Production, FHGR', 'ort' => '', 'text' => 'Web, Film, Audio und Raum, dazu die eigene Radiosendung Multitalk auf Radio Calanda.'],
                ['_type' => '_', 'jahr' => '2025–2026', 'titel' => 'Berufserfahrung', 'ort' => '', 'text' => 'Grafikdesign und Verkauf bei IKEA, seit März 2026 Social Media & Marketing bei Now! Media.'],
                ['_type' => '_', 'jahr' => 'Sommer 2026', 'titel' => 'Stage Somedia', 'ort' => 'Communicaziun, Chur', 'text' => 'Drei Wochen im Video- und Marketingteam.'],
            ]],
            ['_type' => 'fakten', 'title' => 'Auf einen Blick', 'items' => [
                ['_type' => '_', 'label' => 'Studium', 'wert' => 'Multimedia Production, FHGR'],
                ['_type' => '_', 'label' => 'Davor', 'wert' => 'Polydesign-Lehre'],
                ['_type' => '_', 'label' => 'Werkzeuge', 'wert' => 'Figma, InDesign, Illustrator, Photoshop, Premiere Pro, Visual Studio Code, GitHub, WordPress'],
                ['_type' => '_', 'label' => 'Arbeitsfelder', 'wert' => 'Web, Film, Audio, Branding, Raum, Illustration, Konzept, Typografie, Projektleitung, Prototyping'],
                ['_type' => '_', 'label' => 'Sprachen', 'wert' => 'Deutsch, Englisch, Französisch'],
                ['_type' => '_', 'label' => 'Aktuell', 'wert' => 'Social Media & Marketing, Now! Media GmbH'],
            ]],
            ['_type' => 'arbeitsfelder_raster', 'title' => 'Arbeitsfelder', 'button_text' => 'Meine Arbeitsfelder →', 'button_link' => '/arbeitsfelder/'],
        ],
        'Projekte' => [['_type' => 'projekte_archiv', 'title' => 'Projekte']],
        'Arbeitsfelder' => [
            ['_type' => 'seitenkopf', 'title' => 'Arbeitsfelder', 'script' => 'Skills', 'text' => 'Tippe auf ein Feld, um mehr zu sehen.'],
            ['_type' => 'arbeitsfelder_auswahl', 'title' => 'Arbeitsfelder'],
        ],
        'Kontakt' => [
            ['_type' => 'seitenkopf', 'title' => 'Kontakt', 'script' => 'Hi!', 'text' => 'Schreib mir, wenn dir etwas gefällt, für Aufträge, ein Praktikum oder einfach so.'],
            ['_type' => 'kontaktformular', 'title' => 'E-Mail', 'text' => '', 'button_text' => 'E-Mail schreiben'],
        ],
        'Impressum' => [['_type' => 'seitenkopf', 'title' => 'Impressum', 'script' => 'Rechtliches', 'text' => '']],
        'Datenschutz' => [['_type' => 'seitenkopf', 'title' => 'Datenschutz', 'script' => 'Rechtliches', 'text' => '']],
    ];
    $page_ids = [];
    foreach ($pages as $title => $modules) {
        $found = get_posts(['post_type' => 'page', 'title' => $title, 'numberposts' => 1, 'post_status' => 'any']);
        if (!$found) { $log[] = "Seite NICHT gefunden: $title"; continue; }
        $page_ids[$title] = $found[0]->ID;
        carbon_set_post_meta($found[0]->ID, 'modules', $modules);
        $log[] = "Module gesetzt: $title (" . count($modules) . ')';
    }
    if (!empty($page_ids['Startseite'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $page_ids['Startseite']);
    }

    // --- Menüs
    $build = function ($name, $titles) use ($page_ids) {
        $menu = wp_get_nav_menu_object($name);
        $mid = $menu ? $menu->term_id : wp_create_nav_menu($name);
        if ($menu && wp_get_nav_menu_items($mid)) return $mid;
        foreach ($titles as $t) {
            if (empty($page_ids[$t])) continue;
            wp_update_nav_menu_item($mid, 0, ['menu-item-title' => $t, 'menu-item-object' => 'page', 'menu-item-object-id' => $page_ids[$t], 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish']);
        }
        return $mid;
    };
    $main = $build('Hauptnavigation', ['Über mich', 'Projekte', 'Arbeitsfelder', 'Kontakt']);
    $legal = $build('Rechtliches', ['Impressum', 'Datenschutz']);
    set_theme_mod('nav_menu_locations', ['main' => $main, 'legals' => $legal]);
    $log[] = 'Menüs gesetzt';

    // --- Globals
    carbon_set_theme_option('email', 'melina.gast@gmx.ch');
    carbon_set_theme_option('footer_claim', "let's work together");
    carbon_set_theme_option('footer_button_text', 'Schreib mir');
    carbon_set_theme_option('copyright', '© 2026 Melina Gast');
    $log[] = 'Globals gesetzt';

    flush_rewrite_rules();
    echo implode("\n", $log);
    exit;
});
