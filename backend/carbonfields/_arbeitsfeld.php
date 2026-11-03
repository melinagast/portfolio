<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('post_meta', 'Arbeitsfeld')
    ->where('post_type', '=', 'arbeitsfeld')
    ->add_fields([
        Field::make('image', 'icon', 'Icon')->set_required(),
        Field::make('text', 'schriftzug', 'Schriftzug (Script-Wort)')
            ->set_help_text('z. B. online, action, on air'),
        Field::make('textarea', 'beschreibung', 'Beschreibung'),
        Field::make('complex', 'schwerpunkte', 'Schwerpunkte')
            ->set_layout('grid')->set_collapsed(true)
            ->set_header_template('<% if ( titel ) { %> <%- titel %><% } %>')
            ->add_fields([Field::make('text', 'titel', 'Schwerpunkt')]),
        Field::make('complex', 'aufgaben', 'Aufgaben')
            ->set_layout('grid')->set_collapsed(true)
            ->set_header_template('<% if ( aufgabe ) { %> <%- aufgabe %><% } %>')
            ->add_fields([Field::make('text', 'aufgabe', 'Aufgabe')]),
        Field::make('association', 'projekte', 'Verknüpfte Projekte')
            ->set_types([['type' => 'post', 'post_type' => 'project']]),
    ]);
