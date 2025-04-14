<?php
add_filter('nav_menu_css_class', 'mi_footer_cat_nav_class', 10, 3);
function mi_footer_cat_nav_class($classes, $item, $args)
{

    if ('footer_cat' === $args->theme_location || 'footer_company' === $args->theme_location) {
        $classes[] = 'caption-1';
        $classes[] = 'text-variant-2';
    }

    return $classes;
}
