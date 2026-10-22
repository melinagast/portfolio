<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('post_meta', 'Projekt')
    ->where('post_type', '=', 'project')
    ->add_fields([
        Field::make('text', 'nummer', 'Nummer (Gestaltungselement)')
            ->set_attribute('placeholder', '03')
            ->set_width(25)
            ->set_help_text('z. B. 03, steht neben dem Titel und ist nicht Teil davon.'),
        Field::make('text', 'schriftzug', 'Schriftzug')
            ->set_width(75),
        Field::make('textarea', 'kurzbeschreibung', 'Kurzbeschreibung')
            ->set_required(),
        Field::make('text', 'rolle', 'Rolle')
            ->set_width(50),
        Field::make('text', 'mitarbeit', 'Mitarbeit')
            ->set_width(50),
        Field::make('image', 'vorschaubild', 'Vorschaubild')
            ->set_required(),
        Field::make('rich_text', 'einleitung', 'Einleitung'),

        Field::make('complex', 'aufgaben', 'Aufgaben')
            ->set_layout('grid')
            ->set_collapsed(true)
            ->set_header_template('<% if ( aufgabe ) { %> <%- aufgabe %><% } %>')
            ->add_fields([
                Field::make('text', 'aufgabe', 'Aufgabe'),
            ]),

        Field::make('image', 'ergebnis_bild', 'Ergebnis-Bild'),
        Field::make('complex', 'ergebnis_karten', 'Ergebnis-Karten')
            ->set_layout('grid')
            ->set_collapsed(true)
            ->set_header_template('<% if ( title ) { %> <%- title %><% } %>')
            ->add_fields([
                Field::make('text', 'title', 'Titel'),
                Field::make('textarea', 'text', 'Text'),
            ]),

        Field::make('image', 'prozess_bild', 'Prozess-Bild'),
        Field::make('textarea', 'prozess_text', 'Prozess-Einleitung'),
        Field::make('complex', 'prozess_schritte', 'Prozess-Schritte')
            ->set_layout('grid')
            ->set_collapsed(true)
            ->set_header_template('<% if ( schritt ) { %> <%- schritt %><% } %>')
            ->add_fields([
                Field::make('text', 'schritt', 'Schritt'),
            ]),
    ]);