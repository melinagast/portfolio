<?php
// Icon aus dem Theme-Ordner (frontend/assets/icons/<titel>.svg), z. B. film.svg für «Film»
function get_theme_arbeitsfeld_icon(string $title): ?array {
    $file = '/frontend/assets/icons/' . sanitize_title($title) . '.svg';
    $path = get_template_directory() . $file;
    if (!file_exists($path)) {
        return null;
    }
    return [
        'src' => get_template_directory_uri() . $file . '?v=' . filemtime($path),
        'alt' => $title,
        'title' => $title,
        'type' => 'image',
    ];
}
function get_arbeitsfeld_by_id(int $id): array {
    $icon = carbon_get_post_meta($id, 'icon');
    $projekte = array_map(function ($p) {
        return ['title' => get_the_title($p['id']), 'link' => get_permalink($p['id'])];
    }, carbon_get_post_meta($id, 'projekte') ?: []);
    return [
        'id' => $id,
        'title' => get_the_title($id),
        'icon' => get_theme_arbeitsfeld_icon(get_the_title($id)) ?: ($icon ? get_media_by_id($icon, 's') : null),
        'schriftzug' => carbon_get_post_meta($id, 'schriftzug'),
        'beschreibung' => carbon_get_post_meta($id, 'beschreibung'),
        'schwerpunkte' => carbon_get_post_meta($id, 'schwerpunkte') ?: [],
        'aufgaben' => carbon_get_post_meta($id, 'aufgaben') ?: [],
        'projekte' => $projekte,
    ];
}
function get_arbeitsfelder(): array {
    $posts = get_posts(['post_type' => 'arbeitsfeld', 'numberposts' => -1, 'orderby' => 'menu_order date', 'order' => 'ASC']);
    return array_map(fn($p) => get_arbeitsfeld_by_id($p->ID), $posts);
}
