<?php
/**
 * EINMALIGER Import: füllt Impressum und Datenschutz und aktualisiert Über mich.
 * Aufruf: /wp-admin/?mg_legal=1 (als Admin eingeloggt). Danach diese Datei und die require-Zeile in functions.php entfernen.
 */
add_action('admin_init', function () {
    if (empty($_GET['mg_legal']) || !current_user_can('manage_options')) return;
    header('Content-Type: text/plain; charset=utf-8');
    $log = [];
    $it = fn($titel, $text) => ['_type' => '_', 'titel' => $titel, 'text' => $text];

    $impressum = [
        $it('Betreiberin', "Melina Gast\nHubstrasse 26\n8303 Bassersdorf\nSchweiz"),
        $it('Kontakt', 'E-Mail: melina.gast@gmx.ch'),
        $it('Verantwortlich für den Inhalt', 'Melina Gast'),
        $it('Entstehung', 'Diese Website ist mein persönliches Portfolio. Sie ist im Ateliersemester IM5 im Studiengang Multimedia Production an der FHGR (Fachhochschule Graubünden) entstanden.'),
        $it('Haftungsausschluss', "Ich erstelle die Inhalte dieser Website mit grösster Sorgfalt. Für Richtigkeit, Vollständigkeit und Aktualität übernehme ich aber keine Gewähr.\n\nFür Inhalte externer Websites, auf die ich verlinke, sind ausschliesslich deren Betreiber verantwortlich."),
        $it('Urheberrecht', 'Texte, Bilder, Grafiken, Audio- und Videoinhalte stammen von mir oder den bei den Projekten genannten Personen. Eine Verwendung oder Weitergabe ist nur mit meiner schriftlichen Zustimmung erlaubt.'),
    ];
    $datenschutz = [
        $it('Verantwortliche', 'Verantwortlich für die Bearbeitung von Personendaten auf dieser Website ist Melina Gast, E-Mail: melina.gast@gmx.ch.'),
        $it('Grundsatz', 'Ich bearbeite Personendaten nur so weit, wie es für den Betrieb dieser Website und für die Beantwortung von Anfragen nötig ist. Grundlage ist das Schweizer Datenschutzgesetz (DSG).'),
        $it('Hosting und Server-Logs', 'Die Website wird bei Infomaniak Network SA in der Schweiz gehostet. Beim Aufruf speichert der Server technisch notwendige Daten, zum Beispiel IP-Adresse, Datum und Uhrzeit, aufgerufene Seite und Browsertyp. Diese Daten dienen dem sicheren Betrieb und werden nach kurzer Zeit gelöscht.'),
        $it('Kontakt und E-Mail', 'Wenn du mir über das Kontaktformular oder per E-Mail schreibst, bearbeite ich Name, E-Mail-Adresse und Nachricht, um dir zu antworten. Das Formular öffnet dein E-Mail-Programm, auf dem Server dieser Website wird nichts gespeichert. Ich gebe diese Daten nicht weiter und lösche sie, sobald deine Anfrage erledigt ist und keine Aufbewahrungspflicht besteht.'),
        $it('Cookies und Analyse', 'Diese Website setzt keine Tracking- oder Werbe-Cookies ein und nutzt keine Analyse-Tools.'),
        $it('Schriften', 'Die Schriften werden über Google Fonts geladen. Dabei wird deine IP-Adresse an Google übermittelt, damit die Schriften an deinen Browser ausgeliefert werden können.'),
        $it('Links zu LinkedIn und Instagram', 'Im Footer verlinke ich meine Profile bei LinkedIn und Instagram. Es sind reine Links ohne eingebettete Plugins. Erst wenn du darauf klickst, gelten die Datenschutzbestimmungen der jeweiligen Anbieter.'),
        $it('Deine Rechte', 'Du kannst jederzeit Auskunft über deine gespeicherten Daten verlangen sowie deren Berichtigung oder Löschung. Schreib dazu eine E-Mail an melina.gast@gmx.ch.'),
        $it('Änderungen', 'Ich kann diese Erklärung anpassen, wenn sich die Website oder die Rechtslage ändert. Stand: November 2026.'),
    ];

    foreach (['Impressum' => $impressum, 'Datenschutz' => $datenschutz] as $title => $items) {
        $found = get_posts(['post_type' => 'page', 'title' => $title, 'numberposts' => 1, 'post_status' => 'any']);
        if (!$found) { $log[] = "Seite fehlt: $title"; continue; }
        carbon_set_post_meta($found[0]->ID, 'modules', [
            ['_type' => 'seitenkopf', 'title' => $title, 'script' => 'Rechtliches', 'text' => '', 'mit_portrait' => ''],
            ['_type' => 'rechtstext', 'items' => $items],
        ]);
        $log[] = "Gesetzt: $title";
    }

    // Über mich: nur Seitenkopf und Fakten anpassen, Rest bleibt
    $found = get_posts(['post_type' => 'page', 'title' => 'Über mich', 'numberposts' => 1, 'post_status' => 'any']);
    if ($found) {
        $mods = carbon_get_post_meta($found[0]->ID, 'modules') ?: [];
        foreach ($mods as &$m) {
            if ($m['_type'] === 'seitenkopf') {
                $m['text'] = "Ich bin Melina Gast und studiere Multimedia Production an der FHGR. Meinen Weg habe ich mit einer Lehre als Polydesignerin 3D Styling bei IKEA begonnen. Heute gestalte ich Websites, Filme, Audioformate und Konzepte.";
                $m['mit_portrait'] = 'yes';
            }
            if ($m['_type'] === 'fakten') {
                $m['items'] = array_values(array_filter($m['items'] ?? [], fn($i) => in_array($i['label'], ['Werkzeuge', 'Sprachen'], true)));
                $m['text'] = 'Ein Lieblingsprojekt habe ich nicht, denn praktisch alle meine Projekte machen mir Spass. Ausserhalb der Arbeit bin ich am liebsten in Bewegung: Ich mache extrem gerne Sport, vor allem Unihockey.';
                $m['button_text'] = 'Meine Arbeitsfelder →';
                $m['button_link'] = '/arbeitsfelder/';
            }
        }
        unset($m);
        carbon_set_post_meta($found[0]->ID, 'modules', $mods);
        $log[] = 'Über mich angepasst';
    } else {
        $log[] = 'Seite «Über mich» nicht gefunden';
    }
    echo implode("\n", $log) . "\n\nFertig. Jetzt diese Datei und die require-Zeile in functions.php entfernen.";
    exit;
});
