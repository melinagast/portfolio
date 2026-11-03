<?php

function get_project_by_id(int $id): array {
    $image = function ($field) use ($id) {
        $image_id = carbon_get_post_meta($id, $field);
        return $image_id ? get_media_by_id($image_id) : null;
    };

    return [
        'title' => get_the_title($id),
        'disziplinen' => array_map(fn($t) => ['name' => $t->name, 'slug' => $t->slug], get_the_terms($id, 'disziplin') ?: []),
        'link' => get_permalink($id),
        'nummer' => carbon_get_post_meta($id, 'nummer'),
        'schriftzug' => carbon_get_post_meta($id, 'schriftzug'),
        'kurzbeschreibung' => carbon_get_post_meta($id, 'kurzbeschreibung'),
        'rolle' => carbon_get_post_meta($id, 'rolle'),
        'mitarbeit' => carbon_get_post_meta($id, 'mitarbeit'),
        'vorschaubild' => $image('vorschaubild'),
        'einleitung' => apply_filters('the_content', carbon_get_post_meta($id, 'einleitung')),
        'aufgaben' => carbon_get_post_meta($id, 'aufgaben') ?: [],
        'ergebnis_bild' => $image('ergebnis_bild'),
        'ergebnis_karten' => carbon_get_post_meta($id, 'ergebnis_karten') ?: [],
        'prozess_bild' => $image('prozess_bild'),
        'prozess_text' => carbon_get_post_meta($id, 'prozess_text'),
        'prozess_schritte' => carbon_get_post_meta($id, 'prozess_schritte') ?: [],
    ];
}

function get_project_navigation(int $id): ?array {
    $all = get_posts(['post_type' => 'project', 'numberposts' => -1, 'orderby' => 'date', 'order' => 'DESC', 'fields' => 'ids']);
    $i = array_search($id, $all);
    if ($i === false || count($all) < 2) return null;
    $next = $all[($i + 1) % count($all)];
    return ['title' => get_the_title($next), 'link' => get_permalink($next)];
}

function get_projects(int $limit = -1): array {
    $posts = get_posts([
        'post_type' => 'project',
        'numberposts' => $limit,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);

    return array_map(function ($post) {
        return get_project_by_id($post->ID);
    }, $posts);
}