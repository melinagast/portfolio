<?php
/**
 * Custom Post Types: Projekt und Arbeitsfeld.
 */
add_action('init', function () {
    require_once __DIR__ . '/_project.php';
    require_once __DIR__ . '/_arbeitsfeld.php';
}, 0);
