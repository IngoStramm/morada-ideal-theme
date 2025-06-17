<?php

/** 
 * Template Name: Página do Simulador de Crédito Habitação
 * 
 * The template for Simulador de Crédito Habitação
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
        get_template_part('template-parts/content/simulador', 'credito-habitacao-content');
    }
} else {
    // If no content, include the "No posts found" template.
    get_template_part('template-parts/content/content-none');
}
?>

<?php get_footer();
