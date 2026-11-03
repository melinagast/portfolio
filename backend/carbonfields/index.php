<?php
add_action('carbon_fields_register_fields', function () {
    require_once __DIR__ . '/_globals.php';
    require_once __DIR__ . '/_modules.php';
    require_once __DIR__ . '/_project.php';
    require_once __DIR__ . '/_arbeitsfeld.php';
});
