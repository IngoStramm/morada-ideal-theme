<?php

/**
 * mi_debug
 *
 * @param  mixed $a
 * @return string
 */
function mi_debug($a)
{
    echo '<pre>';
    var_dump($a);
    echo '</pre>';
}
/**
 * mi_version
 *
 * @return string
 */
function mi_version()
{
    // $version = '1.0.1';
    $version = rand(0, 9999);
    // generate random version

    return $version;
}

/**
 * mi_the_html_classes
 *
 * @return string
 */
function mi_the_html_classes()
{
    /**
     * Filters the classes for the main <html> element.
     *
     * @param string The list of classes. Default empty string.
     */
    $classes = apply_filters('mi_html_classes', '');
    if (!$classes) {
        return;
    }
    echo 'class="' . esc_attr($classes) . '"';
}

/**
 * mi_pagination.
 *
 * @global array $wp_query   Current WP Query.
 * @global array $wp_rewrite URL rewrite rules.
 *
 * @param  int   $mid   Total of items that will show along with the current page.
 * @param  int   $end   Total of items displayed for the last few pages.
 * @param  bool  $show  Show all items.
 * @param  mixed $query Custom query.
 *
 * @return string       Return the pagination.
 */
function mi_pagination($mid = 2, $end = 1, $show = false, $query = null)
{
    // Prevent show pagination number if Infinite Scroll of JetPack is active.
    if (!isset($_GET['infinity'])) {

        global $wp_query, $wp_rewrite;

        $total_pages = $wp_query->max_num_pages;

        if (is_object($query) && null != $query) {
            $total_pages = $query->max_num_pages;
        }

        if ($total_pages > 1) {
            $url_base = $wp_rewrite->pagination_base;
            $big = 999999999;

            // Sets the paginate_links arguments.
            $arguments = apply_filters(
                'mi_pagination_args',
                array(
                    'base'      => esc_url_raw(str_replace($big, '%#%', get_pagenum_link($big, false))),
                    'format'    => '',
                    'current'   => max(1, get_query_var('paged')),
                    'total'     => $total_pages,
                    'show_all'  => $show,
                    'end_size'  => $end,
                    'mid_size'  => $mid,
                    'type'      => 'list',
                    'prev_text' => '<span aria-hidden="true">&laquo;</span>',
                    'next_text' => '<span aria-hidden="true">&raquo;</span>',
                )
            );

            // Aplica o HTML/classes CSS do bootstrap
            $mi_paginate_links = paginate_links($arguments);
            // $mi_paginate_links = str_replace('page-numbers', 'pagination', paginate_links($arguments));
            // $mi_paginate_links = str_replace('<li>', '<li class="page-item">', $mi_paginate_links);
            $mi_paginate_links = str_replace('<li><span aria-current="page" class="page-numbers current">', '<li><a class="nav-item active" href="">', $mi_paginate_links);
            $mi_paginate_links = str_replace('</span></li>', '</a></li>', $mi_paginate_links);
            $mi_paginate_links = str_replace('<a class="page-numbers"', '<a class="nav-item"', $mi_paginate_links);
            // $mi_paginate_links = str_replace('page-numbers dots', 'nav-item', $mi_paginate_links);
            $mi_paginate_links = str_replace('<a class="next page-numbers"', '<a class="nav-item"', $mi_paginate_links);
            $mi_paginate_links = str_replace('<a class="prev page-numbers"', '<a class="nav-item"', $mi_paginate_links);
            $mi_paginate_links = str_replace('<span class="page-link dots">', '<a class="nav-item" href="">', $mi_paginate_links);
            // $mi_paginate_links = str_replace('</span>', '</a>', $mi_paginate_links);
            $mi_paginate_links = str_replace('<ul class=\'page-numbers\'>', '<ul class="wd-navigation mt-20">', $mi_paginate_links);
            // $mi_paginate_links = str_replace('<li class="page-item"><a class="page-link dots" href="">', '<li class="page-item disabled"><a class="page-link dots" href="">', $mi_paginate_links);

            $pagination = '<div class="my-4"><nav aria-label="Page navigation">' . $mi_paginate_links . '</nav></div>';

            // Prevents duplicate bars in the middle of the url.
            if ($url_base) {
                $pagination = str_replace('//' . $url_base . '/', '/' . $url_base . '/', $pagination);
            }

            return $pagination;
        }
    }
}

if (!function_exists('mi_paging_nav')) {

    /**
     * Print HTML with meta information for the current post-date/time and author.
     *
     * @since 2.2.0
     */
    function mi_paging_nav()
    {
        $mid  = 2;     // Total of items that will show along with the current page.
        $end  = 1;     // Total of items displayed for the last few pages.
        $show = false; // Show all items.

        echo mi_pagination($mid, $end, false);
    }
}

/**
 * mi_check_if_plugin_is_active
 *
 * @param  string $plugin
 * @return boolean
 */
function mi_check_if_plugin_is_active($plugin)
{
    $active_plugins = get_option('active_plugins');
    return in_array($plugin, $active_plugins);
}

/**
 * mi_get_pages
 *
 * @return array
 */
function mi_get_pages()
{
    $pages = get_pages();
    $return_array = [];
    foreach ($pages as $page) {
        $return_array[$page->ID] = $page->post_title;
    }
    return $return_array;
}

/**
 * mi_logo
 *
 * @return string
 */
function mi_logo()
{
    $html = '';
    if (has_custom_logo()) {
        $custom_logo_id = get_theme_mod('custom_logo');
        $image = wp_get_attachment_image_src($custom_logo_id, 'medium');
        $html .= '<img class="site-logo" src="' . $image[0] . '" />';
    }
    return $html;
}

function mi_get_wysiwyg_output($meta_key, $post_id = 0)
{
    global $wp_embed;

    $post_id = $post_id ? $post_id : get_the_id();

    $content = get_post_meta($post_id, $meta_key, 1);
    $content = $wp_embed->autoembed($content);
    $content = $wp_embed->run_shortcode($content);
    $content = wpautop($content);
    $content = do_shortcode($content);

    return $content;
}

function mi_get_user_name()
{
    $user = wp_get_current_user();
    $nome = $user->first_name && $user->last_name ?
        $user->first_name . ' ' . $user->last_name :
        $user->display_name;
    return $nome;
}

function mi_text_login_btn()
{
    $output = '';
    if (is_user_logged_in()) {
        $nome = mi_get_user_name();
        $output = sprintf(__('Olá, %s', 'iv'), $nome);
    } else {
        $output = __('Entrar/Cadastrar', 'iv');
    }
    return $output;
}

/**
 * mi_get_page_id
 *
 * @param  string $slug ('login', 'newuser', 'lostpassword', 'resetpassword', 'dashboard', 'profile', 'editimovel', 'myimoveis')
 * @return string
 */
function mi_get_page_id($slug)
{
    $return_id = '';
    switch ($slug) {
        case 'login':
            $login_page_id = mi_get_option('mi_login_page', false, 'mi_site_pages_options');
            if ($login_page_id) {
                $return_id = $login_page_id;
            }
            break;

        case 'newuser':
            $new_user_page_id = mi_get_option('mi_new_user_page', false, 'mi_site_pages_options');
            if ($new_user_page_id) {
                $return_id = $new_user_page_id;
            }
            break;

        case 'lostpassword':
            $lostpassword_page_id = mi_get_option('mi_lostpassword_page', false, 'mi_site_pages_options');
            if ($lostpassword_page_id) {
                $return_id = $lostpassword_page_id;
            }
            break;

        case 'resetpassword':
            $resetpassword_page_id = mi_get_option('mi_resetpassword_page', false, 'mi_site_pages_options');
            if ($resetpassword_page_id) {
                $return_id = $resetpassword_page_id;
            }
            break;

        case 'dashboard':
            $account_page_id = mi_get_option('mi_dashboard_page', false, 'mi_dashboard_pages_options');
            if ($account_page_id) {
                $return_id = $account_page_id;
            }
            break;

        case 'profile':
            $account_page_id = mi_get_option('mi_profile_page', false, 'mi_dashboard_pages_options');
            if ($account_page_id) {
                $return_id = $account_page_id;
            }
            break;

        case 'editimovel':
            $edit_imovel_page_id = mi_get_option('mi_edit_imovel_page', false, 'mi_dashboard_pages_options');
            if ($edit_imovel_page_id) {
                $return_id = $edit_imovel_page_id;
            }
            break;

        case 'myimoveis':
            $edit_my_imovel_page_id = mi_get_option('mi_my_imovel_page', false, 'mi_dashboard_pages_options');
            if ($edit_my_imovel_page_id) {
                $return_id = $edit_my_imovel_page_id;
            }
            break;

        default:
            $return_id = null;
            break;
    }
    return $return_id;
}

/**
 * mi_get_page_url
 *
 * @param  string $slug ('login', 'newuser', 'lostpassword', 'resetpassword', 'dashboard', 'editimovel', 'myimoveis')
 * @return string
 */
function mi_get_page_url($slug)
{
    $return_url = '';
    switch ($slug) {
        case 'login':
            $login_page_id = mi_get_page_id('login');
            if ($login_page_id) {
                $return_url = get_page_link($login_page_id);
            }
            break;

        case 'newuser':
            $new_user_page_id = mi_get_page_id('newuser');
            if ($new_user_page_id) {
                $return_url = get_page_link($new_user_page_id);
            }
            break;

        case 'lostpassword':
            $lostpassword_page_id = mi_get_page_id('lostpassword');
            if ($lostpassword_page_id) {
                $return_url = get_page_link($lostpassword_page_id);
            }
            break;

        case 'resetpassword':
            $resetpassword_page_id = mi_get_page_id('resetpassword');
            if ($resetpassword_page_id) {
                $return_url = get_page_link($resetpassword_page_id);
            }
            break;

        case 'dashboard':
            $account_page_id = mi_get_page_id('dashboard');
            if ($account_page_id) {
                $return_url = get_page_link($account_page_id);
            }
            break;

        case 'profile':
            $account_page_id = mi_get_page_id('profile');
            if ($account_page_id) {
                $return_url = get_page_link($account_page_id);
            }
            break;

        case 'editimovel':
            $edit_imovel_page_id = mi_get_page_id('editimovel');
            if ($edit_imovel_page_id) {
                $return_url = get_page_link($edit_imovel_page_id);
            }
            break;

        case 'myimoveis':
            $my_imovel_page_id = mi_get_page_id('myimoveis');
            if ($my_imovel_page_id) {
                $return_url = get_page_link($my_imovel_page_id);
            }
            break;

        case 'myimoveis':
            $my_imovel_page_id = mi_get_page_id('myimoveis');
            if ($my_imovel_page_id) {
                $return_url = get_page_link($my_imovel_page_id);
            }
            break;


        default:
            $return_url = get_home_url();
            break;
    }
    return $return_url;
}

/**
 * mi_get_option
 *
 * @param  string $key
 * @param  boolean $default
 * @param  string $option_key
 * @return mixed
 */
function mi_get_option($key = '', $default = false, $option_key = 'mi_theme_options')
{
    if (function_exists('cmb2_get_option')) {
        // Use cmb2_get_option as it passes through some key filters.
        return cmb2_get_option($option_key, $key, $default);
    }
    // Fallback to get_option if CMB2 is not loaded yet.
    $opts = get_option($option_key, $default);
    $val = $default;
    if ('all' == $key) {
        $val = $opts;
    } elseif (is_array($opts) && array_key_exists($key, $opts) && false !== $opts[$key]) {
        $val = $opts[$key];
    }
    return $val;
}

/**
 * mi_certificado_energetico_options
 *
 * @return array
 */
function mi_certificado_energetico_options()
{
    $options = array(
        'A+'        => esc_html__('A+', 'mi'),
        'A'         => esc_html__('A', 'mi'),
        'B'         => esc_html__('B', 'mi'),
        'B-'        => esc_html__('B-', 'mi'),
        'C'         => esc_html__('C', 'mi'),
        'D'         => esc_html__('D', 'mi'),
        'E'         => esc_html__('E', 'mi'),
        'F'         => esc_html__('F', 'mi'),
    );
    return $options;
}

/**
 * mi_atualiza_termos
 *
 * @param  array/string $terms_id
 * @param  int $post_id
 * @param  string $tax_slug
 * @return array/WP_Error
 */
function mi_atualiza_termos($terms_id, $post_id, $tax_slug)
{
    // Converte para int os IDs dos termos no array
    // Isso é necessário para que a função 'wp_set_object_terms' entenda que se trata de IDs,
    // senão ela irá criar novos termos tratando os IDs como se fossem títulos (ou slugs) dos termos
    // como não irá encontrar estes termos, então irá criar novos termos usando os IDs como título
    if (is_array($terms_id)) {
        $int_terms_id = [];
        foreach ($terms_id as $term) {
            $int_terms_id[] = intval($term);
        }
    } else {
        $int_terms_id = (int)$terms_id;
    }

    // os termos precisam ser inseridos após o post ser criado, 
    // porque o usuário não tem permissãi para criar termos
    $insert_terms = wp_set_object_terms($post_id, $int_terms_id, $tax_slug);
    return $insert_terms;
}

/**
 * mi_calcula_valor_por_metro
 *
 * @param  string/int $valor
 * @param  string/int $metro
 * @return int
 */
function mi_calcula_valor_por_metro($valor, $metro)
{
    if (!$valor || !$metro) {
        return 0;
    }
    if (is_string($valor)) {
        $valor_formatado = str_replace('.', '', $valor);
        $valor_formatado = str_replace(',', '.', $valor_formatado);
        $valor_formatado = (int)$valor_formatado;
    } else {
        $valor_formatado = $valor;
    }
    $metro_formatado = (int)$metro;
    $result = ceil($valor_formatado / $metro_formatado);
    return $result;
}

/**
 * mi_check_edit_imovel_user_permition
 *
 * @param  string/int $post_id
 * @return boolean
 */
function mi_check_edit_imovel_user_permition($user_id, $post_id)
{
    if (!$user_id) {
        return false;
    }
    if (!$post_id) {
        return true;
    }
    $is_user_administrator = mi_user_has_role($user_id, 'administrator');
    if ($is_user_administrator) {
        return true;
    }
    $post = get_post($post_id);
    $author_id = $post->post_author;
    $check_user = (int)$user_id === (int)$author_id;
    return $check_user;
}

/**
 * mi_user_has_role
 *
 * @param  int $user_id
 * @param  string $role_name
 * @return boolean
 */
function mi_user_has_role($user_id, $role_name)
{
    $user_meta = get_userdata($user_id);
    $user_roles = $user_meta->roles;
    return in_array($role_name, $user_roles);
}

/**
 * mi_get_user_imoveis
 *
 * @param  string/int $user_id
 * @return array
 */
function mi_get_user_imoveis($user_id, $status = array())
{
    $post_status = array_merge(array('publish'), $status);
    $imoveis = get_posts(
        array(
            'post_type'             => 'imovel',
            'posts_per_page'        => -1,
            'post_status'           => $post_status,
            'author'                => $user_id,
            // 'meta_query'            => array(
            //     'relation'          => 'AND',
            //     array(
            //         'key'      => 'mi_author_imovel_id',
            //         'value'    => $user_id,
            //     ),
            // )
        )
    );
    wp_reset_postdata();
    return $imoveis;
}

/**
 * mi_check_imovel_date
 *
 * @param  string/int $post_id
 * @return int
 */
function mi_check_imovel_date($post_id)
{
    $post = get_post($post_id);
    $creation_date = date_create($post->post_date);
    // mi_debug($creation_date);
    // $today = date_create();
    $today = new DateTime();
    // mi_debug($today);
    // $interval = date_diff($creation_date, $today);
    // mi_debug($interval);
    // return $interval->d;
    $interval = $today->diff($creation_date);
    $editable = true;
    if ($interval->y > 0 || $interval->m > 0 || $interval->d > 7) {
        $editable = false;
    }
    return $editable;
}

/**
 * mi_get_imoveis_by_price
 *
 * @return array
 */
function mi_get_imoveis_by_price()
{

    $args = array(
        'post_type' => 'imovel',
        'posts_per_page' => -1, // Get all posts
    );

    $query = new WP_Query($args);
    $prices = [];
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $mi_imovel_preco = get_post_meta($post_id, 'imovel_valor', true);
            if ($mi_imovel_preco) {
                $prices[] = floatval($mi_imovel_preco);
            }
        }

        wp_reset_postdata(); // Important to reset post data
    }
    sort($prices);
    return $prices;
}

/**
 * mi_remove_url_parameters
 *
 * @param  string $url
 * @param  array $params
 * @return string
 */
function mi_remove_url_parameters($url, $params)
{
    // Analisar a URL
    $parsed_url = parse_url($url);

    // Obter a query string
    parse_str($parsed_url['query'] ?? '', $query_params);

    // Remover os parâmetros especificados
    foreach ($params as $param) {
        unset($query_params[$param]);
    }

    // Reconstruir a query string
    $new_query_string = http_build_query($query_params);

    // Montar a nova URL
    $new_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];
    if (isset($parsed_url['port'])) {
        $new_url .= ':' . $parsed_url['port'];
    }
    $new_url .= $parsed_url['path'];

    // Adicionar a nova query string, se houver
    if (!empty($new_query_string)) {
        $new_url .= '?' . $new_query_string;
    }

    return $new_url;
}

/**
 * mi_filters_params
 *
 * @return array
 */
function mi_filters_params()
{
    $params = array(
        'operacao-term',
        'tipo-terms',
        'tipologia-term',
        'preco-min',
        'preco-max',
        'caracteristica-geral-terms',
        'metragem-imovel-min',
        'metragem-imovel-max',
        'search',
        'lat',
        'lng',
        'imovel_estado',
        'imovel_cidade',
        'imovel_codigo_postal',
        'imovel_rua',
    );
    return $params;
}

/**
 * mi_sort_params
 *
 * @return array
 */
function mi_sort_params()
{
    $params = array(
        'orderby',
        'start-date',
        'end-date',
        'action',
    );
    return $params;
}

/**
 * mi_search_params
 *
 * @return string
 */
function mi_search_params()
{
    $params = array(
        's',
        'post_type',
        'lat',
        'lng'
    );
    $hidden_inputs = mi_add_query_params_as_inputs($params);
    return $hidden_inputs;
}

/**
 * mi_add_query_params_as_inputs
 *
 * @param  array $params
 * @return string
 */
function mi_add_query_params_as_inputs($params)
{
    $output = '';
    foreach ($params as $param) {
        if (isset($_GET[$param]) && $_GET[$param]) {
            if (is_array($_GET[$param])) {
                foreach ($_GET[$param] as $v) {
                    $output .= '<input type="hidden" name="' . $param . '" value="' . $v . '">';
                }
            } else {
                $output .= '<input type="hidden" name="' . $param . '" value="' . $_GET[$param] . '">';
            }
        }
    }
    return $output;
}


/**
 * mi_unset_params
 *
 * @param  array $params
 * @return void
 */
function mi_unset_params($params)
{
    foreach ($params as $param) {
        unset($_GET[$param]);
    }
}


/**
 * mi_precos_options
 *
 * @return array
 */
function mi_precos_options()
{
    $options = array(
        '60000' => '60.000 €',
        '80000' => '80.000 €',
        '100000' => '100.000 €',
        '120000' => '120.000 €',
        '140000' => '140.000 €',
        '150000' => '150.000 €',
        '160000' => '160.000 €',
        '180000' => '180.000 €',
        '200000' => '200.000 €',
        '220000' => '220.000 €',
        '240000' => '240.000 €',
        '260000' => '260.000 €',
        '280000' => '280.000 €',
        '300000' => '300.000 €',
        '320000' => '320.000 €',
        '340000' => '340.000 €',
        '360000' => '360.000 €',
        '380000' => '380.000 €',
        '400000' => '400.000 €',
        '450000' => '450.000 €',
        '500000' => '500.000 €',
        '550000' => '550.000 €',
        '600000' => '600.000 €',
        '650000' => '650.000 €',
        '700000' => '700.000 €',
        '750000' => '750.000 €',
        '800000' => '800.000 €',
        '850000' => '850.000 €',
        '900000' => '900.000 €',
        '950000' => '950.000 €',
        '1000000' => '1 milhão €',
        '1100000' => '1,1 milhões €',
        '1200000' => '1,2 milhões €',
        '1300000' => '1,3 milhões €',
        '1400000' => '1,4 milhões €',
        '1500000' => '1,5 milhões €',
        '1600000' => '1,6 milhões €',
        '1700000' => '1,7 milhões €',
        '1800000' => '1,8 milhões €',
        '1900000' => '1,9 milhões €',
        '2000000' => '2 milhões €',
        '2100000' => '2,1 milhões €',
        '2200000' => '2,2 milhões €',
        '2300000' => '2,3 milhões €',
        '2400000' => '2,4 milhões €',
        '2500000' => '2,5 milhões €',
        '2600000' => '2,6 milhões €',
        '2700000' => '2,7 milhões €',
        '2800000' => '2,8 milhões €',
        '2900000' => '2,9 milhões €',
        '3000000' => '3 milhões €',
    );
    return $options;
}

/**
 * mi_get_min_prices
 *
 * @return float
 */
function mi_get_min_prices()
{
    $args = array(
        'post_type'     => 'imovel',
        'order'         => 'ASC',
        'orderby'       => 'meta_value_num',
        'meta_key'      => 'imovel_valor',
        'nopaging'              => true,
        'posts_per_page'        => -1
    );
    $min_price = 0;
    $posts = get_posts($args);
    if (count($posts) > 0) {
        $min_price_post_id = $posts[0]->ID;
        $min_price = get_post_meta($min_price_post_id, 'imovel_valor', true);
    }
    wp_reset_postdata();
    return (float)$min_price;
}

/**
 * mi_get_max_prices
 *
 * @return float
 */
function mi_get_max_prices()
{
    $args = array(
        'post_type'             => 'imovel',
        'order'                 => 'DESC',
        'orderby'               => 'meta_value_num',
        'meta_key'              => 'imovel_valor',
        'nopaging'              => true,
        'posts_per_page'        => -1
    );
    $max_price = 0;
    $posts = get_posts($args);
    if (count($posts) > 0) {
        $max_price_post_id = $posts[0]->ID;
        $max_price = get_post_meta($max_price_post_id, 'imovel_valor', true);
    }
    wp_reset_postdata();
    return (float)$max_price;
}

define('MI_MIN_PRICE', mi_get_min_prices());
define('MI_MAX_PRICE', mi_get_max_prices());

/**
 * mi_get_selected_min_price
 *
 * @return float
 */
function mi_get_selected_min_price()
{
    $min_price = null;
    if (isset($_GET['preco-min']) && $_GET['preco-min']) {
        $min_price = (float)$_GET['preco-min'];
    }
    return $min_price;
}

/**
 * mi_get_selected_max_price
 *
 * @return float
 */
function mi_get_selected_max_price()
{
    $max_price = null;
    if (isset($_GET['preco-max']) && $_GET['preco-max']) {
        $max_price = (float)$_GET['preco-max'];
    }
    return $max_price;
}

/**
 * mi_get_min_area
 *
 * @return float
 */
function mi_get_min_area()
{
    $args = array(
        'post_type'     => 'imovel',
        'order'         => 'ASC',
        'orderby'       => 'meta_value_num',
        'meta_key'      => 'imovel_area_bruta',
        'nopaging'              => true,
        'posts_per_page'        => -1
    );
    $min_area = 0;
    $posts = get_posts($args);
    if (count($posts) > 0) {
        $min_area_post_id = $posts[0]->ID;
        $min_area = get_post_meta($min_area_post_id, 'imovel_area_bruta', true);
    }
    wp_reset_postdata();
    return (float)$min_area;
}

/**
 * mi_get_max_area
 *
 * @return float
 */
function mi_get_max_area()
{
    $args = array(
        'post_type'     => 'imovel',
        'order'         => 'DESC',
        'orderby'       => 'meta_value_num',
        'meta_key'      => 'imovel_area_bruta',
        'nopaging'              => true,
        'posts_per_page'        => -1
    );
    $max_area = 0;
    $posts = get_posts($args);
    if (count($posts) > 0) {
        $max_area_post_id = $posts[0]->ID;
        $max_area = get_post_meta($max_area_post_id, 'imovel_area_bruta', true);
    }
    wp_reset_postdata();
    return (float)$max_area;
}

define('MI_MIN_AREA', mi_get_min_area());
define('MI_MAX_AREA', mi_get_max_area());

/**
 * mi_get_selected_min_area
 *
 * @return float
 */
function mi_get_selected_min_area()
{
    $min_area = null;
    if (isset($_GET['metragem-imovel-min']) && $_GET['metragem-imovel-min']) {
        $min_area = (float)$_GET['metragem-imovel-min'];
    }
    return $min_area;
}

/**
 * mi_get_selected_max_area
 *
 * @return float
 */
function mi_get_selected_max_area()
{
    $max_area = null;
    if (isset($_GET['metragem-imovel-max']) && $_GET['metragem-imovel-max']) {
        $max_area = (float)$_GET['metragem-imovel-max'];
    }
    return $max_area;
}

/**
 * mi_metragem_options
 *
 * @return array
 */
function mi_metragem_options()
{
    $options = array(
        40 => '40 m²',
        60 => '60 m²',
        80 => '80 m²',
        90 => '90 m²',
        100 => '100 m²',
        120 => '120 m²',
        140 => '140 m²',
        160 => '160 m²',
        180 => '180 m²',
        200 => '200 m²',
        250 => '250 m²',
        300 => '300 m²',
        350 => '350 m²',
        400 => '400 m²',
        450 => '450 m²',
        500 => '500 m²',
        600 => '600 m²',
        700 => '700 m²',
        800 => '800 m²',
        900 => '900 m²'
    );
    return $options;
}

/**
 * mi_get_lat_lng_from_google_by_address
 *
 * @param  string $endereco_completo
 * @return array
 */
function mi_get_lat_lng_from_google_by_address($endereco_completo)
{
    $geocode_key = mi_get_option('geocode_key', false, 'mi_google_keys_options');
    if (!$geocode_key) {
        return new WP_Error('incomplete_settings', __('Geocode Key não definida.', 'ea-dentistas'));
    }

    $address_encoded = urlencode($endereco_completo);
    $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?key=' . $geocode_key . '&address=' . $address_encoded . '&sensor=false');

    $output = json_decode($geocode);
    if (isset($output->error_message)) {
        mi_debug($output->error_message);
        mi_debug($output->status);
        return;
    }

    $lat = $output->results[0]->geometry->location->lat;
    $lng = $output->results[0]->geometry->location->lng;
    return array(
        'lat' => $lat,
        'lng' => $lng
    );
}

/**
 * mi_get_imoveis
 *
 * @return array
 */
function mi_get_imoveis()
{
    global $wp_query;
    $posts = $wp_query->posts;
    $imoveis = [];
    if ($posts) {
        foreach ($posts as $post) {
            $post_id = $post->ID;
            $post_url = get_post_permalink($post_id);
            $title = get_the_title($post_id);
            $thumbnail = get_the_post_thumbnail_url($post_id, 'medium');
            $imovel_valor = get_post_meta($post_id, 'imovel_valor', true);
            $imovel_area_bruta = get_post_meta($post_id, 'imovel_area_bruta', true);
            $imovel_rua = get_post_meta($post_id, 'imovel_rua', true);
            $imovel_numero = get_post_meta($post_id, 'imovel_numero', true);
            $imovel_cidade = get_post_meta($post_id, 'imovel_cidade', true);
            $imovel_estado = get_post_meta($post_id, 'imovel_estado', true);
            $imovel_codigo_postal = get_post_meta($post_id, 'imovel_codigo_postal', true);

            $author_id = $post->post_author;
            $author_name = get_the_author_meta('display_name', $author_id);
            $author_avatar = get_user_meta($author_id, 'mi_user_avatar', true);

            $imovel_operacao = get_post_meta($post_id, 'imovel_operacao', true);
            $imovel_tipologias = get_the_terms($post_id, 'tipologia');
            $imovel_caracteristicas_gerais = get_the_terms($post_id, 'caracteristica-geral');
            $imovel_outras_denominacoes_gerais = get_the_terms($post_id, 'outras-denominacoes');
            $imovel_casas_de_banho_gerais = get_the_terms($post_id, 'casas-de-banho');
            $imovel_estado_gerais = get_post_meta($post_id, 'imovel_estado_gerais', true);
            $imovel_mais_filtros_gerais = get_post_meta($post_id, 'imovel_mais_filtros_gerais', true);
            $imovel_galeria = get_post_meta($post_id, 'imovel_galeria', true);
            $imovel_andar_gerais = get_post_meta($post_id, 'imovel_andar_gerais', true);
            $imovel_caracteristicas_especificas = get_post_meta($post_id, 'imovel_caracteristicas_especificas', true);
            $imovel_certificado_energetico = get_post_meta($post_id, 'imovel_certificado_energetico', true);
            $imovel_lat = get_post_meta($post_id, 'imovel_lat', true);
            $imovel_lng = get_post_meta($post_id, 'imovel_lng', true);
            $imoveis[$post_id] = array(
                'post_id'                                       => $post_id,
                'post_url'                                      => $post_url,
                'title'                                         => $title,
                'thumbnail'                                     => $thumbnail,
                'galeria'                                       => $imovel_galeria,
                'valor'                                         => $imovel_valor,
                'metragem'                                      => $imovel_area_bruta,
                'rua'                                           => $imovel_rua,
                'numero'                                        => $imovel_numero,
                'cidade'                                        => $imovel_cidade,
                'estado'                                        => $imovel_estado,
                'codigo_postal'                                 => $imovel_codigo_postal,
                'operacao'                                      => $imovel_operacao,
                'tipologias'                                    => $imovel_tipologias,
                'caracteristicas_gerais'                        => $imovel_caracteristicas_gerais,
                'outras_denominacoes_gerais'                    => $imovel_outras_denominacoes_gerais,
                'casas_de_banho_gerais'                         => $imovel_casas_de_banho_gerais,
                'estado_gerais'                                 => $imovel_estado_gerais,
                'mais_filtros_gerais'                           => $imovel_mais_filtros_gerais,
                'andar_gerais'                                  => $imovel_andar_gerais,
                'caracteristicas_especificas'                   => $imovel_caracteristicas_especificas,
                'certificado_energetico'                        => $imovel_certificado_energetico,
                'author_name'                                   => $author_name,
                'author_avatar'                                 => $author_avatar,
                'lat'                                           => $imovel_lat,
                'lng'                                           => $imovel_lng,
            );
        }
    }
    return $imoveis;
}

/**
 * mi_get_field_value
 *
 * @param  string $name
 * @return mixed
 */
function mi_get_field_value($name)
{
    $value = isset($_POST[$name]) && !is_null($_POST[$name]) ? $_POST[$name] : null;
    if (!$value) {
        // retorna uma mensagem de erro com o campo 'success' falso
        wp_send_json_error(array('msg' => __("Campo \"$name\" não foi passado ou está vazio.", 'cl')), 200);
    }
    return $value;
}

/**
 * mi_format_money
 *
 * @param  mixed $number
 * @return string
 */
function mi_format_money($number, $decimal = 0)
{
    if (!is_numeric($number)) {
        $number = str_replace('.', '', $number);
        $number = str_replace(',', '.', $number);
    }

    $number = floatval($number);

    return number_format($number, $decimal, ',', '.');
}

/**
 * mi_format_number
 *
 * @param  string $number
 * @return float
 */
function mi_format_number($number)
{
    $number = str_replace('.', '', $number);
    $number = str_replace(',', '.', $number);
    $number = floatval($number);
    return $number;
}

/**
 * mi_garagens_options
 *
 * @return array
 */
function mi_garagens_options()
{
    $options = array(
        '0'             => esc_html__('Nenhum', 'mi'),
        '1'             => esc_html__('1', 'mi'),
        '2'             => esc_html__('2', 'mi'),
        '3'             => esc_html__('3', 'mi'),
        '4'             => esc_html__('4', 'mi'),
        '5'             => esc_html__('5', 'mi'),
        '6'             => esc_html__('6', 'mi'),
        '7'             => esc_html__('7', 'mi'),
        '8'             => esc_html__('8', 'mi'),
        '9'             => esc_html__('9', 'mi'),
        '9+'            => esc_html__('Mais de 9', 'mi'),
    );
    return $options;
}

/**
 * mi_dados_imovel_form_1
 *
 * @param  string $edit_novo_imovel_link
 * @return array
 */
function mi_dados_imovel_form_1()
{
    $messages = [
        'operacao-term'                             =>  __('Operação inválida.', 'mi'),
        'tipo-terms'                                =>  __('Tipo(s) inválido(s).', 'mi'),
        'imovel_rua'                                =>  __('Rua inválida.', 'mi'),
        'imovel_numero'                             =>  __('Número inválido.', 'mi'),
        'imovel_codigo_postal'                      =>  __('Código postal inválido.', 'mi'),
        'imovel_cidade'                             =>  __('Cidade inválida.', 'mi'),
        'imovel_estado'                             =>  __('Estado inválido.', 'mi'),
        'lat'                                       =>  __('Latitude inválida.', 'mi'),
        'lng'                                       =>  __('Longitude inválida.', 'mi'),
        'imovel_price'                              =>  __('Preço inválido.', 'mi'),
    ];
    $dados = mi_form_dados_array($messages);

    return $dados;
}

/**
 * mi_dados_imovel_form_2
 *
 * @return array
 */
function mi_dados_imovel_form_2()
{
    $messages = [
        'imovel-content'                        =>  __('Descrição inválida.', 'mi'),
        'imovel_area_bruta'                     =>  __('Área bruta inválida.', 'mi'),
        'imovel_area_util'                      =>  __('Área bruta inválida.', 'mi'),
        'imovel_ano'                            =>  __('Ano inválido.', 'mi'),
        'imovel_garagens'                       =>  __('Garagem inválida.', 'mi'),
        'imovel_certificado_energetico'         =>  __('Certificado energético inválido.', 'mi'),
        'caracteristicas-gerais-terms'          =>  __('Característica(s) Geral(is) inválida(s).', 'mi'),
        'tipologia-term'                        =>  __('Tipologia inválida.', 'mi'),
        'outras-denominacoes-terms'             =>  __('Outra(s) Denominação(ões) inválida(s).', 'mi'),
        'casas-de-banho-term'                   =>  __('Casa(s) de Banho inválida(s).', 'mi'),
        'estado-terms'                          =>  __('Filtro(s) inválido(s).', 'mi'),
        'andar-term'                            =>  __('andar-term.', 'mi'),
        'filtro-terms'                          =>  __('Filtro(s) inválido(s).', 'mi'),
        'caracteristicas-especificas'           =>  __('Característica(s) específica(s) inválida(s).', 'mi'),
    ];
    $dados = mi_form_dados_array($messages);

    return $dados;
}

/**
 * mi_form_dados_array
 *
 * @param  array $messages
 * @return array
 */
function mi_form_dados_array($messages)
{
    $dados = [];

    foreach ($messages as $name => $message) {
        if (!isset($_POST[$name]) || !$_POST[$name]) {
            $dados[$name] = [
                'status'            => false,
                'message'           => $message
            ];
        } else {
            $dados[$name] = [
                'status'            => true,
                'value'             => $_POST[$name]
            ];
        }
    }

    return $dados;
}
