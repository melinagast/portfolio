<?php
add_filter('init', function () {
    register_nav_menus([
        'main' => 'Hauptnavigation',
        'legals' => 'Rechtliches (Footer)',
    ]);
});
