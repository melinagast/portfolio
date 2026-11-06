<?php
function get_global_logo() {
    $id = carbon_get_theme_option('logo');
    return $id ? get_media_by_id($id) : ['src' => '', 'alt' => 'Melina Gast'];
}
function get_global_portrait() {
    $id = carbon_get_theme_option('portrait');
    if ($id) {
        return get_media_by_id($id, 'l');
    }
    // Fallback: ausgeschnittenes Portrait aus dem Theme
    $file = get_template_directory() . '/frontend/assets/img/portrait.png';
    return file_exists($file)
        ? ['src' => get_template_directory_uri() . '/frontend/assets/img/portrait.png', 'alt' => 'Melina Gast', 'title' => 'Melina Gast']
        : null;
}
function get_global_email() {
    return carbon_get_theme_option('email');
}
function get_global_footer(): array {
    return [
        'claim' => carbon_get_theme_option('footer_claim') ?: "let's work together",
        'button' => carbon_get_theme_option('footer_button_text') ?: 'Kontakt aufnehmen →',
        'copyright' => carbon_get_theme_option('copyright') ?: '© 2026 Melina Gast',
    ];
}
function get_global_socials() {
    $socials = carbon_get_theme_option('socials') ?: [];
    return array_map(function ($item) {
        $item['icon'] = $item['icon'] ? get_media_by_id($item['icon']) : null;
        return $item;
    }, $socials);
}
