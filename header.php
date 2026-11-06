<!DOCTYPE html>
<html lang="<?php bloginfo('language') ?>">
<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
    <link rel="preload" href="<?= get_template_directory_uri() ?>/frontend/assets/fonts/Anton-Regular.woff" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="<?= get_template_directory_uri() ?>/frontend/assets/fonts/HankenGrotesk-Variable.woff" as="font" type="font/woff" crossorigin>
    <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/frontend/styles/main.css?v=<?= filemtime(get_template_directory() . '/frontend/styles/main.css') ?>">
    <?php $fav = carbon_get_theme_option('favicon'); if ($fav) : $f = get_media_by_id($fav, 'xxs'); ?>
        <link rel="icon" href="<?= esc_url($f['src']) ?>">
    <?php endif; ?>
    <title><?= is_front_page() ? 'Melina Gast – Portfolio' : wp_get_document_title() ?></title>
    <?php wp_head(); ?>
</head>
<body>
