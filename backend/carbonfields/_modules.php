<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

$kopf = fn() => [
    Field::make('text', 'title', 'Titel')->set_required(),
    Field::make('text', 'script', 'Schriftzug (Script-Wort)')->set_help_text('z. B. Work, Hey!, Hi!'),
];

Container::make('post_meta', 'Module')
    ->where('post_type', '=', 'page')
    ->add_fields([
        Field::make('complex', 'modules', 'Module')
            ->add_fields('hero', 'Hero', [
                Field::make('text', 'title', 'Titel')->set_default_value('Portfolio'),
                Field::make('text', 'script', 'Schriftzug')->set_default_value('Melina'),
                Field::make('textarea', 'text', 'Kurztext'),
                Field::make('image', 'image', 'Bild (leer = Portrait aus Globales)'),
            ])
            ->add_fields('about_teaser', 'Über-mich-Teaser', [
                Field::make('text', 'title', 'Titel')->set_default_value('Über mich'),
                Field::make('text', 'script', 'Schriftzug')->set_default_value('Hey!'),
                Field::make('textarea', 'text', 'Text'),
                Field::make('text', 'button_text', 'Button-Text')->set_default_value('Mehr über mich →'),
                Field::make('text', 'button_link', 'Button-Link')->set_default_value('/ueber-mich/'),
            ])
            ->add_fields('projekte_teaser', 'Neueste Projekte', [
                Field::make('text', 'title', 'Titel')->set_default_value('Neueste Projekte'),
                Field::make('text', 'anzahl', 'Anzahl')->set_attribute('type', 'number')->set_default_value('3'),
                Field::make('text', 'button_text', 'Button-Text')->set_default_value('Alle Projekte →'),
                Field::make('text', 'button_link', 'Button-Link')->set_default_value('/projekte/'),
            ])
            ->add_fields('arbeitsfelder_raster', 'Arbeitsfelder-Band (animiert)', [
                Field::make('text', 'title', 'Titel')->set_default_value('Arbeitsfelder'),
                Field::make('text', 'button_text', 'Button-Text')->set_default_value('Mehr zu meinen Skills →'),
                Field::make('text', 'button_link', 'Button-Link')->set_default_value('/arbeitsfelder/'),
            ])
            ->add_fields('seitenkopf', 'Seitenkopf', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('text', 'script', 'Schriftzug'),
                Field::make('textarea', 'text', 'Einleitung')->set_help_text('Leerzeile = neuer Absatz.'),
                Field::make('checkbox', 'mit_portrait', 'Portrait links anzeigen (z. B. Über mich)'),
            ])
            ->add_fields('projekte_archiv', 'Projekte-Archiv (mit Filter)', [
                Field::make('text', 'title', 'Titel')->set_default_value('Projekte')->set_required(),
                Field::make('text', 'script', 'Schriftzug')->set_default_value('Work'),
                Field::make('textarea', 'text', 'Einleitung'),
            ])
            ->add_fields('arbeitsfelder_auswahl', 'Arbeitsfelder-Auswahl (Band + Detail)', [
                Field::make('text', 'title', 'Titel')->set_default_value('Arbeitsfelder'),
            ])
            ->add_fields('textblock', 'Textblock', [
                Field::make('text', 'title', 'Titel'),
                Field::make('rich_text', 'text', 'Text'),
            ])
            ->add_fields('zeitleiste', 'Zeitleiste', [
                Field::make('text', 'title', 'Titel')->set_default_value('Werdegang'),
                Field::make('complex', 'items', 'Einträge')
                    ->set_layout('tabbed-vertical')
                    ->set_header_template('<% if ( titel ) { %> <%- jahr %> – <%- titel %><% } %>')
                    ->add_fields([
                        Field::make('text', 'jahr', 'Jahr / Zeitraum')->set_width(30),
                        Field::make('text', 'titel', 'Titel')->set_width(70),
                        Field::make('text', 'ort', 'Ort / Firma'),
                        Field::make('textarea', 'text', 'Text'),
                    ]),
            ])
            ->add_fields('fakten', 'Fakten', [
                Field::make('text', 'title', 'Titel')->set_default_value('Fakten'),
                Field::make('textarea', 'text', 'Persönlicher Absatz (rechts, gross)'),
                Field::make('text', 'button_text', 'Button-Text'),
                Field::make('text', 'button_link', 'Button-Link'),
                Field::make('complex', 'items', 'Einträge')
                    ->set_layout('tabbed-vertical')
                    ->set_header_template('<% if ( label ) { %> <%- label %><% } %>')
                    ->add_fields([
                        Field::make('text', 'label', 'Label')->set_width(40),
                        Field::make('text', 'wert', 'Wert')->set_width(60),
                    ]),
            ])
            ->add_fields('rechtstext', 'Rechtstext (Impressum, Datenschutz)', [
                Field::make('complex', 'items', 'Abschnitte')
                    ->set_layout('tabbed-vertical')
                    ->set_header_template('<% if ( titel ) { %> <%- titel %><% } %>')
                    ->add_fields([
                        Field::make('text', 'titel', 'Überschrift'),
                        Field::make('textarea', 'text', 'Text')->set_help_text('Leerzeile = neuer Absatz.'),
                    ]),
            ])
            ->add_fields('kontaktformular', 'Kontakt', [
                Field::make('text', 'title', 'Titel')->set_default_value('Kontakt'),
                Field::make('textarea', 'text', 'Text'),
                Field::make('text', 'button_text', 'Button-Text')->set_default_value('E-Mail schreiben'),
            ])
            ->set_layout('tabbed-vertical'),
    ]);

function render_modules (): void {
    $modules = carbon_get_the_post_meta('modules');
    if (empty($modules)) {
        return;
    }
    foreach ($modules as $module) {
        switch ($module['_type']) {
            case 'hero':
                $module['image'] = !empty($module['image']) ? get_media_by_id($module['image'], 'l') : get_global_portrait();
                break;
            case 'about_teaser':
                $module['bild'] = get_global_portrait();
                break;
            case 'seitenkopf':
                $module['bild'] = !empty($module['mit_portrait']) ? get_global_portrait() : null;
                break;
            case 'projekte_teaser':
                $module['projects'] = get_projects((int) ($module['anzahl'] ?: 3));
                break;
            case 'projekte_archiv':
                $module['projects'] = get_projects();
                $module['disziplinen'] = array_map(fn($t) => ['name' => $t->name, 'slug' => $t->slug], get_terms(['taxonomy' => 'disziplin', 'hide_empty' => false, 'orderby' => 'term_id', 'order' => 'ASC']) ?: []);
                break;
            case 'arbeitsfelder_raster':
            case 'arbeitsfelder_auswahl':
                $module['felder'] = get_arbeitsfelder();
                break;
            case 'kontaktformular':
                $module['email'] = get_global_email();
                $module['socials'] = get_global_socials();
                break;
        }
        get_template_part('frontend/views/modules/' . $module['_type'], null, ['data' => $module]);
    }
}
