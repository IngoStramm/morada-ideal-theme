<?php

function mi_get_category_parents($id, $link = false, $separator = '/', $nicename = false, $visited = array(), $iscrumb = false)
{
    $chain = '';
    $parent = get_term($id, 'category');
    if (is_wp_error($parent)) {
        return $parent;
    }
    if ($nicename) {
        $name = $parent->slug;
    } else {
        $name = $parent->name;
    }
    if ($parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent, $visited)) {
        $visited[] = $parent->parent;
        $chain .= mi_get_category_parents($parent->parent, $link, $separator, $nicename, $visited, $iscrumb);
    }
    if (is_rtl()) {
        $sep_direction = '\\';
    } else {
        $sep_direction = '/';
    }
    if ($iscrumb) {
        $chain .= '<li><span class="sep">' . $sep_direction . '</span><a href="' . esc_url(get_category_link($parent->term_id)) . '"><span>' . $name . '</span></a></li>' . $separator;
    } elseif ($link && !$iscrumb) {
        $chain .= '<a href="' . esc_url(get_category_link($parent->term_id)) . '">' . $name . '</a>' . $separator;
    } else {
        $chain .= $name . $separator;
    }
    return $chain;
}

function mi_get_breadcrumbs()
{
    global $wp_query;
    $search = isset($_GET['search']) && $_GET['search'] ? $_GET['search'] : null;
    $output = '';
    if (is_rtl()) {
        $sep_direction = '\\';
    } else {
        $sep_direction = '/';
    }
    $output .= '<nav style="--bs-breadcrumb-divider: \' > \';" aria-label="breadcrumb">';
    $output .= '<ol class="breadcrumb">';
    $output .= '<li class="breadcrumb-item"><a href="' . esc_url(home_url()) . '"><span>' . get_bloginfo('name') . '</span></a></li>';

    if (! is_front_page()) {
        // Check for categories, archives, search page, single posts, pages, the 404 page, and attachments
        if (is_category()) {
            $cat_obj     = $wp_query->get_queried_object();
            $thisCat     = get_category($cat_obj->term_id);
            $parentCat   = get_category($thisCat->parent);
            if ($thisCat->parent != 0) {
                $cat_parents = mi_get_category_parents($parentCat, true, '', false, array(), true);
            }
            if ($thisCat->parent != 0 && ! is_wp_error($cat_parents)) {
                echo $cat_parents;
            }
            $output .= '<li class="breadcrumb-item active" aria-current="page"><span class="sep">' . $sep_direction . '</span><a href="' . get_category_link($thisCat) . '"><span>' . single_cat_title('', false) . '</span></a></li>';
        } else if (is_search() || $search) {
            $output .= '<li class="breadcrumb-item active" aria-current="page">' . $search . '</li>';
        } else if (is_archive() && ! is_category()) {
            $output .= '<li class="breadcrumb-item active" aria-current="page">' . __('Imóveis', 'mi') . '</li>';
        } else if (is_404()) {
            $output .= '<li class="breadcrumb-item active" aria-current="page">' . __('404 Não Encontrado', 'mi') . '</li>';
        } else if (is_singular()) {
            $category    = get_the_category();
            $category_id = $category->term_id;
            $cat_parents = mi_get_category_parents($category_id, true, '', false, array(), true);
            if (! is_wp_error($cat_parents)) {
                echo $cat_parents;
            }
            $output .= '<li class="breadcrumb-item active" aria-current="page">
                <a href="' . get_the_permalink() . '"><span class="sep">' . $sep_direction . '</span>' . get_the_title() . '</a>
            </li>';
        } elseif (is_singular('attachment')) {
            $output .= '<li class="breadcrumb-item active" aria-current="page">
                ' . get_the_title() . '</li>';
        } elseif (is_page()) {
            $post = $wp_query->get_queried_object();
            if ($post->post_parent == 0) {
                $output .= '<li class="breadcrumb-item active" aria-current="page"><span class="sep">/</span>' . get_the_title() . '</li>';
            } else {
                $title = the_title('', '', false);
                $ancestors = array_reverse(get_post_ancestors($post->ID));
                array_push($ancestors, $post->ID);
                foreach ($ancestors as $ancestor) {
                    if ($ancestor != end($ancestors)) {
                        $output .= '<li class="breadcrumb-item active" aria-current="page">
                            <span class="sep">' . $sep_direction . '</span><a href="' . esc_url(get_permalink($ancestor)) . '"> <span>' . strip_tags(apply_filters('single_post_title', get_the_title($ancestor))) . '</span></a>
                        </li>';
                    } else {
                        $output .= '<li class="breadcrumb-item active" aria-current="page">
                            <span class="sep">' . $sep_direction . '</span>' . strip_tags(apply_filters('single_post_title', get_the_title($ancestor)));
                        $output .= '</li>';
                    }
                }
            }
        }
    }
    $output .= '</ol>';
    $output .= '</nav>';
    return $output;
}
