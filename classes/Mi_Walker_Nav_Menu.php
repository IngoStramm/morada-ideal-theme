<?php

/**
 * Custom walker class.
 */
class Mi_Walker_Nav_Menu extends Walker_Nav_Menu
{

    /**
     * Starts the list before the elements are added.
     *
     * Adds classes to the unordered list sub-menus.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        // Depth-dependent classes.
        $indent = ($depth > 0  ? str_repeat("\t", $depth) : ''); // code indent
        $display_depth = ($depth + 1); // because it counts the first submenu as 0
        $classes = array();
        $class_names = implode(' ', $classes);

        // Build HTML for output.
        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
    }

    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        global $wp_query;
        $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent

        // Depth-dependent classes.
        $depth_classes = array();
        $depth_class_names = esc_attr(implode(' ', $depth_classes));

        // Passed classes.
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        foreach ($classes as $key => $class) {
            if ($class === 'menu-item-has-children' && $depth === 0) {
                $classes[$key] = 'dropdown2';
            }
            if ($class === 'current-menu-item' || $class === 'current-menu-ancestor' || $class === 'current-menu-parent') {
                $classes[] = 'current';
            }
        }

        $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth)));

        // Build HTML.
        $output .= $indent . '<li id="nav-menu-item-' . $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

        $a_classes_names = array('nav-link');

        if ($depth === 0 && in_array('dropdown', $classes)) {
            array_push($a_classes_names, 'nav-link');
            array_push($a_classes_names, 'dropdown-toggle');
        } else {
            array_push($a_classes_names, 'main-menu-link');
        }
        // current-menu-ancestor
        if (in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes)) {
            array_push($a_classes_names, 'active');
        }

        // mi_debug($a_classes_names);

        // Link attributes.
        $attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';
        $attributes .= ' class="' . implode(' ', $a_classes_names) . '"';

        $attributes .= $depth === 0 && in_array('dropdown', $classes) ? ' role="button" data-bs-toggle="dropdown" aria-expanded="false"' : '';

        $attributes .= $depth === 0 && in_array('dropdown', $classes) ? ' role="button"' : '';

        $attributes .= in_array('current-menu-item', $classes) ? ' aria-current="page"' : '';

        // Build HTML output and pass through the proper filter.
        $item_output = sprintf(
            '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters('the_title', $item->title, $item->ID),
            $args->link_after,
            $args->after
        );
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
