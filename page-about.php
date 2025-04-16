<?php

/** 
 * Template Name: Página Sobre
 * 
 * The template for About Page
 * 
 * @package morada-ideal 
 */
?>
<?php get_header(); ?>
<?php

if (have_posts()) {
    // Load posts loop.
    while (have_posts()) {
        the_post();
        get_template_part('template-parts/content/about', 'content');
    }
} else {
    // If no content, include the "No posts found" template.
    get_template_part('template-parts/content/content-none');
}
?>

<?php get_footer();
