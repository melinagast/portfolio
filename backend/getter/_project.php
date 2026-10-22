<?php

function get_project_by_id(int $id): array {
    $image = function ($field) use ($id) {
        $image_id = carbon_get_post_meta($id, $field);
        return $image_id ? get_media_by_id($image_id) : null;
    };

    return [
        'title' => get_the_title($id),
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

function get_projects(): array {
    $posts = get_posts([
        'post_type' => 'project',
        'numberposts' => -1,
        'orderby' => 'date',
        'order' => 'ASC',
    ]);

    return array_map(function ($post) {
        return get_project_by_id($post->ID);
    }, $posts);
}