<?php

/**
 * Template Name: Página de login
 * 
 * The template for login page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Morada Ideal
 */

get_header('login');

/* Start the Loop */
while (have_posts()) :
    the_post();
    get_template_part('template-parts/content/login/login', 'content');

endwhile; // End of the loop.

get_footer('login');
