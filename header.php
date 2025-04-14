<?php

/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package morada-ideal
 */
?>

<!DOCTYPE html>

<html <?php language_attributes(); ?> <?php mi_the_html_classes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>

</head>

<body class="body">
    <!-- RTL -->
    <!-- <a href="javascript:void(0);" id="toggle-rtl" class="tf-btn primary">RTL</a> -->
    <!-- /RTL  -->
    <?php echo mi_preloader(); ?>

    <div id="wrapper">
        <div id="pagee" class="clearfix">
            <?php do_action('mi_scripts'); ?>
            <?php get_template_part('template-parts/header/site-header'); ?>