<?php

/**
 * Template Name: Página de senha perdida
 * 
 * The template for Lost Password page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Morada Ideal
 */

get_header('login');

/* Start the Loop */
while (have_posts()) :
    the_post();
    get_template_part('template-parts/content/login/lost-password', 'content');

endwhile; // End of the loop.

get_footer('login');
