<?php
register_taxonomy('disziplin', ['project'], [
    'label' => 'Disziplin',
    'labels' => [
        'name' => 'Disziplinen',
        'singular_name' => 'Disziplin',
        'menu_name' => 'Disziplinen',
        'all_items' => 'Alle Disziplinen',
        'edit_item' => 'Disziplin bearbeiten',
        'add_new_item' => 'Neue Disziplin hinzufügen',
    ],
    'public' => true,
    'show_in_rest' => false,
    'show_in_nav_menus' => false,
    'show_admin_column' => true,
    'query_var' => true,
    'hierarchical' => true,
    'rewrite' => ['slug' => 'disziplin'],
]);
