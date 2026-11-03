<!DOCTYPE html>
<html lang="<?php bloginfo('language') ?>">
<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Anton&family=Hanken+Grotesk:wght@400;500;700&family=Instrument+Serif:ital@1&family=Mrs+Saint+Delafield&display=swap">
    <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/frontend/styles/main.css?v=<?= filemtime(get_template_directory() . '/frontend/styles/main.css') ?>">
    <?php $fav = carbon_get_theme_option('favicon'); if ($fav) : $f = get_media_by_id($fav, 'xxs'); ?>
        <link rel="icon" href="<?= esc_url($f['src']) ?>">
    <?php endif; ?>
    <title><?= is_front_page() ? 'Melina Gast – Portfolio' : wp_get_document_title() ?></title>
    <?php wp_head(); ?>
</head>
<body>
