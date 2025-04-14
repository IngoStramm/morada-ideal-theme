<?php

/**
 * Template Name: Página Perfil
 * 
 * The template for Profile Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Morada ideal
 */

get_header('dashboard');

/* Start the Loop */
while (have_posts()) :
    the_post();
    get_template_part('template-parts/content/dashboard/profile', 'content');

endwhile; // End of the loop.

get_footer('dashboard');
