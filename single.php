<?php

/**
 * The template for displaying all single posts.
 *
 * @package morada-ideal
 */

get_header(); ?>

<?php

if (have_posts()) {
    // Load posts loop.
    while (have_posts()) {
        the_post();
        get_template_part('template-parts/content/single', 'content');
    }
}
get_footer();
