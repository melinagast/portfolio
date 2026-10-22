<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// -> Inhaltsfeld-Konfiguration der globalen Einstellungen des Themes
Container::make('theme_options', 'Globales')
    ->add_fields([
        Field::make('image', 'logo', 'Logo')
            ->set_required(),
        Field::make('text', 'email', 'E-Mail')
            ->set_required()
            ->set_default_value('melina.gast@gmx.ch')
            ->set_attribute('type', 'email'),
        Field::make('complex', 'socials', 'Socials')
            ->set_layout('tabbed-vertical')
            ->set_header_template('<% if ( title ) { %> <%- title %><% } %>')
            ->add_fields([
                Field::make('text', 'title', 'Titel')
                    ->set_required()
                    ->set_attribute('placeholder', 'z. B. LinkedIn')
                    ->set_width(50),
                Field::make('text', 'link', 'Link')
                    ->set_required()
                    ->set_attribute('placeholder', 'https://...')
                    ->set_width(50),
                Field::make('image', 'icon', 'Icon')
                    ->set_required(),
            ]),
        // todo: Globale Inhaltsfelder hier ergänzen
    ]);