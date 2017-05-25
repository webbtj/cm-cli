<!DOCTYPE html>
<?php $smarty = wp_smarty(); ?>

<html> <!--<![endif]-->
  <head>

    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>

    <!-- Meta Data ===================================================== -->
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,follow" />

    <!-- Fonts ================================================== -->
    <!-- <script src="//typekit"></script> -->
    <script>try{Typekit.load({ async: true });}catch(e){}</script>

    <!-- Favicons ====================================================== -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#6a2c91">
    <meta name="theme-color" content="#6a2c91">


    <?php
        $smarty->display('includes/social-meta.tpl');
    ?>

    <?php wp_head(); ?>

  </head>
    <body <?php body_class(); ?>>

    <?php
        $smarty->display('includes/header.tpl');
