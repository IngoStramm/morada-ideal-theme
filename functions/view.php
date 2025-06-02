<?php

/**
 * mi_total_imoveis_sort_message
 *
 * @return string
 */
function mi_total_imoveis_sort_message()
{
    global $wp_query;
    if (!is_main_query() || is_admin() || $wp_query->get('post_type') === 'nav_menu_item') {
        return;
    }
    $post_count = $wp_query->found_posts;
    $search_term = isset($wp_query->query_vars['search']) && $wp_query->query_vars['search'] ? $wp_query->query_vars['search'] : null;
    $output = '';
    $output .= $search_term ? sprintf(__('%s imóveis encontrados em %s', 'mi'), $post_count, $search_term) : sprintf(__('%s imóveis encontrados', 'mi'), $post_count);
    return $output;
}

/**
 * mi_imovel_meta_list
 *
 * @param  string $imovel_tipologia
 * @param  string $imovel_casas_banho
 * @param  string $imovel_area_bruta
 * @return string
 */
function mi_imovel_meta_list($imovel_tipologia = null, $imovel_casas_banho = null, $imovel_area_bruta = null, $certificado_energetico = null)
{
    $output = '';
    $output .= '
    <ul class="meta-list">';

    if ($imovel_tipologia) {
        $output .= '
        <li class="item">
                <i class="icon icon-bed"></i>
                <span class="fw-6">' . $imovel_tipologia . '</span>
            </li>';
    }

    if ($imovel_casas_banho) {
        $output .= '
            <li class="item">
                <i class="icon icon-bath"></i>
                <span class="fw-6">' . $imovel_casas_banho . '</span>
            </li>';
    }

    if ($imovel_area_bruta) {
        $output .= '
            <li class="item">
                <i class="icon icon-sqft"></i>
                <span class="fw-6">' . $imovel_area_bruta . 'm²</span>
            </li>';
    }

    if ($certificado_energetico) {
        $output .= '
            <li class="item">
                <svg class="certicado-energetico-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M0 256L28.5 28c2-16 15.6-28 31.8-28H228.9c15 0 27.1 12.1 27.1 27.1c0 3.2-.6 6.5-1.7 9.5L208 160H347.3c20.2 0 36.7 16.4 36.7 36.7c0 7.4-2.2 14.6-6.4 20.7l-192.2 281c-5.9 8.6-15.6 13.7-25.9 13.7h-2.9c-15.7 0-28.5-12.8-28.5-28.5c0-2.3 .3-4.6 .9-6.9L176 288H32c-17.7 0-32-14.3-32-32z"/></svg>
                <span class="fw-6">' . $certificado_energetico . '</span>
            </li>';
    }
    $output .= '
    </ul>';
    return $output;
}

/**
 * mi_autocomplete_search_input
 *
 * @param  string $imovel_lat
 * @param  string $imovel_lng
 * @param  boolean $display_box_address
 * @param  boolean $is_required
 * @param  boolean $display_hidden_fields
 * @return string
 */
function mi_autocomplete_search_input($imovel_lat = '', $imovel_lng = '', $display_box_address = false, $is_required = false, $display_hidden_fields = true, $validate_autocomplete_input = false)
{
    $search = isset($_GET['search']) && $_GET['search'] ? $_GET['search'] : null;
    if (!$imovel_lat) {
        $imovel_lat = isset($_GET['lat']) && $_GET['lat'] ? $_GET['lat'] : null;
    }
    if (!$imovel_lng) {
        $imovel_lng = isset($_GET['lng']) && $_GET['lng'] ? $_GET['lng'] : null;
    }
    $imovel_estado = isset($_GET['imovel_estado']) && $_GET['imovel_estado'] ? $_GET['imovel_estado'] : null;
    $imovel_cidade = isset($_GET['imovel_cidade']) && $_GET['imovel_cidade'] ? $_GET['imovel_cidade'] : null;
    $imovel_codigo_postal = isset($_GET['imovel_codigo_postal']) && $_GET['imovel_codigo_postal'] ? $_GET['imovel_codigo_postal'] : null;
    $imovel_rua = isset($_GET['imovel_rua']) && $_GET['imovel_rua'] ? $_GET['imovel_rua'] : null;
    $required = $is_required ? 'required' : '';
    $data_validate = $validate_autocomplete_input ? 'data-validate="true"' : 'data-validate="false"';
    $invalid_feedback = '<div class="ms-2 invalid-feedback">' . __('Campo obrigatório', 'mi') . '</div>';
    $output = '';
    $output .= '
    <div class="autocomplete-wrapper form-style">
        <div class="group-ip ip-icon">
            <input type="text" class="form-control autocomplete search-address-group" placeholder="' . __('Localização', 'mi') . '" value="' . $search . '" name="search" id="autocomplete" title="' . __('Pesquisar por', 'mi') . '" ' . $data_validate . ' ' . $required . '>
            <a href="#" class="icon-right icon-location"></a>' . $invalid_feedback . '
        </div>
        <div id="autocomplete-message" class="autocomplete-message invalid-feedback px-2">' . __('Digite um endereço completo (rua, cidade, Estado e código postal) para fazer a pesquisa.', 'mi') . '</div>
        <input type="hidden" value="' . $imovel_lat . '" name="lat" />
        <input type="hidden" value="' . $imovel_lng . '" name="lng" />';
    if ($display_hidden_fields) {
        $output .= '
        <input type="hidden" value="' . $imovel_estado . '" name="imovel_estado" />
        <input type="hidden" value="' . $imovel_cidade . '" name="imovel_cidade" />
        <input type="hidden" value="' . $imovel_codigo_postal . '" name="imovel_codigo_postal" />
        <input type="hidden" value="' . $imovel_rua . '" name="imovel_rua" />';
    }
    $output .= '
    </div>
    ';
    if ($display_box_address) {
        $output .= '
        <div class="box-address">
        </div>
        ';
    }
    return $output;
}

/**
 * mi_range_widget
 *
 * @param  string $text
 * @param  string $min_value
 * @param  string $max_value
 * @param  string $min_name
 * @param  string $max_name
 * @return string
 */
function mi_range_widget($id, $text, $min_value, $max_value, $min_name, $max_name)
{
    $output = '';
    $output .= '
    <div class="form-style widget-range">
        <div class="box-title-range">
            <span class="title-range fw-6">' . $text . ':</span>
            <div class="caption-range">
                <span data-min-caption class="fw-6"></span>
                <span class="fw-6">-</span>
                <span data-max-caption class="fw-6"></span>
            </div>
        </div>
        <div id="' . $id . '"></div>
        <div class="slider-labels">
            <input type="hidden" data-min-value name="' . $min_name . '" value="' . $min_value . '">
            <input type="hidden" data-max-value name="' . $max_name . '" value="' . $max_value . '">
        </div>
    </div>
    ';
    return $output;
}

/**
 * mi_radio_list
 *
 * @param  string $text
 * @param  array $terms
 * @param  mixed $selected_tipo_term_id
 * @param  string $slug
 * @return string
 */
function mi_radio_list($text, $terms, $selected_tipo_term_id, $slug, $radio = true, $term_array = false)
{
    $input_name = $term_array ? $slug . '-terms[]' : $slug . '-term';
    $type = $radio ? 'radio' : 'checkbox';
    $output = '';
    $output .= '
    <div class="box">
        <div class="form-style wd-amenities">
            <div class="group-checkbox">
                <h6 class="title text-black-2">' . $text . ':</h6>
                <div class="group-amenities">';
    foreach ($terms as $term) {
        if (is_array($selected_tipo_term_id)) {
            $checked = $selected_tipo_term_id && in_array((string)$term->term_id, $selected_tipo_term_id) ? 'checked' : '';
        } else {
            $checked = $term->term_id === (int)$selected_tipo_term_id ? 'checked' : '';
        }
        $output .= '
                    <fieldset class="amenities-item">
                        <input type="' . $type . '" class="tf-checkbox style-1" value="' . $term->term_id . '" id="' . $slug . '-term-' . $term->term_id . '" name="' . $input_name . '" ' . $checked . '>
                        <label for="' . $slug . '-term-' . $term->term_id . '" class="text-cb-amenities">' . $term->name . '</label>
                    </fieldset>';
    }
    $output .= '
                </div>
            </div>
        </div>
    </div>
    ';
    return $output;
}

/**
 * mi_overview_list_item_term
 *
 * @param  array $terms
 * @param  string $icon
 * @param  string $text
 * @return string
 */
function mi_overview_list_item_term($terms, $icon, $text)
{
    $output = '';
    if ($terms) {
        $output .= '
        <li class="item">
            <a href="#" class="box-icon w-52"><i class="icon ' .  $icon . '"></i></a>
            <div class="content">
                <span class="label">' . $text . '</span>';
        $count = 0;
        $first = 0;
        $last = count($terms) - 1;
        foreach ($terms as $term) {
            // if (!$term->parent) {
            $sep = '';
            if ($count !== $first && $count !== $last) {
                $sep .= ', ';
            }
            $output .= '
                <span>' . $sep . $term->name . '</span>';
            $count++;
            // }
        }
        $output .= '
            </div>
        </li>';
    }
    return $output;
}

/**
 * mi_overview_list_item_text
 *
 * @param  string $item
 * @param  string $icon
 * @param  string $text
 * @return string
 */
function mi_overview_list_item_text($item, $icon, $text)
{
    $output = '';
    $output .= '
        <li class="item">
            <a href="#" class="box-icon w-52"><i class="icon ' . $icon . '"></i></a>
            <div class="content">
                <span class="label">' . $text . ':</span>
                <span>' . $item . '</span>
            </div>
        </li>';
    return $output;
}

/**
 * mi_preloader
 *
 * @return string
 */
function mi_preloader()
{
    $preloader = mi_get_option('mi_preloader');
    $output = '';
    if ($preloader !== 'on') {
        return $output;
    }
    $output .= '
    <!-- preload -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
            <span class="icon icon-villa-fill"></span>
        </div>
    </div>
    <!-- /preload -->
    ';
    return $output;
}

/**
 * mi_get_icon
 *
 * @param  string $name
 * @return string
 */
function mi_get_icon($name)
{
    $icon = empty($name) || is_null($name) ? null : file_get_contents(MI_DIR . '/assets/icons/' . $name . '.svg');
    return !$icon ? null : $icon;
}

/**
 * mi_dismissible_alert
 *
 * @param  string $message
 * @param  string $type (primary, secondary, success, danger, warning, info, light, dark)
 * @return string
 */
function mi_dismissible_alert($message, $type = 'success')
{
    $output = '';
    if ($message) {
        $output .= '
        <div class="alert alert-' . $type . ' alert-dismissible d-flex align-items-center gap-2 fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>' . $message . '</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
    }
    return $output;
}
/**
 * mi_dismissible_alert
 *
 * @param  string $message
 * @param  string $type (primary, secondary, success, danger, warning, info, light, dark)
 * @return string
 */
function mi_alert($message, $type = 'success')
{
    $output = '';
    if ($message) {
        $output .= '
        <div class="alert alert-' . $type . ' d-flex align-items-center gap-2 fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>' . $message . '</div>
        </div>
        ';
    }
    return $output;
}

/**
 * mi_dashboard_footer
 *
 * @return string
 */
function mi_dashboard_footer()
{
    $site_name = get_bloginfo('name');
    $output = '';
    $output .= '
    <div class="footer-dashboard">
        <p>' . $site_name . '© Todos os direitos reservados</p>
    </div>';
    return $output;
}

/**
 * mi_button_toggle_dashboard_sidebar
 *
 * @return string
 */
function mi_button_toggle_dashboard_sidebar()
{
    $output = '';
    $output .= '
    <div class="button-show-hide show-mb">
            <span class="icon icon-categories fs-3 fw-normal"></span>
        </div>';
    return $output;
}

/**
 * mi_invalid_feedback
 *
 * @return string
 */
function mi_invalid_feedback()
{
    $output = '';
    $output .= '
    <div class="invalid-feedback">' . __('Campo obrigatório', 'mi') . '</div>';
    return $output;
}

/**
 * mi_edit_imovel_progress_bar
 *
 * @param  int $curr_step
 * @return string
 */
function mi_edit_imovel_progress_bar($curr_step = 1)
{
    $steps = [
        1 => __('1. Dados básicos', 'mi'),
        2 => __('2. Detalhes', 'mi'),
        3 => __('3. Fotos', 'mi')
    ];
    $output = '';
    $output .= '
    <ul class="edit-imovel-progress-bar">';
    foreach ($steps as $k => $step) {
        $active = $k === (int)$curr_step ? 'active' : '';
        $output .= '<li class="step ' . $active . '">' . $step . '</li>';
    }
    $output .= '</ul>';
    return $output;
}

/**
 * mi_imovel_form_hidden_inputs
 *
 * @param  array $imovel_data
 * @param  array $exclude_array
 * @return string
 */
function mi_imovel_form_hidden_inputs($imovel_data, $exclude_array = [])
{
    $output = '';
    if ($imovel_data) {
        foreach ($imovel_data as $name => $value) {
            if (!isset($exclude_array[$name]) || !$exclude_array[$name] && $value) {
                $output .= '<input type="hidden" name="' . $name . '" value="' . $value . '" />';
            }
        }
    }
    return $output;
}

/**
 * mi_checkbox_widget
 *
 * @param  string $title
 * @param  string $name
 * @param  array $terms
 * @param  array $post_terms
 * @return string
 */
function mi_checkbox_widget($title, $name, $terms, $post_terms, $is_required = false)
{
    $output = '';
    $output .= '
    <div class="box-amenities-property full-width">
            <div class="box-amenities">
                <div class="title-amenities text-btn">' . $title . '</div>
                <div class="list-amenities">';
    $count = 0;
    $total = count($terms) - 1;
    foreach ($terms as $term) {
        $checked = $post_terms && in_array($term, $post_terms) ? 'checked' : '';
        $required = $is_required ? ' required' : '';
        $output .= '
                        <fieldset class="amenities-item">
                            <input type="checkbox" class="tf-checkbox style-1" id="term-' . $term->term_id . '" name="' . $name . '" value="' . $term->term_id . '" ' . $checked . ' ' . $required . '>';
        $output .= '<label for="term-' . $term->term_id . '" class="text-cb-amenities">' . $term->name . '</label>';
        if ($is_required && $count === $total) {
            $output .= '<div class="invalid-feedback">' . __('Campo obrigatório, escolha uma opção', 'mi') . '</div>';
        }
        $output .= '</fieldset>';
        $count++;
    }
    $output .= '
                </div>
            </div>
        </div>';
    return $output;
}

/**
 * mi_radio_widget
 *
 * @param  string $title
 * @param  string $name
 * @param  array $terms
 * @param  WP_Term $current_term
 * @return string
 */
function mi_radio_widget($title, $name, $terms, $current_term, $is_required = false)
{
    $output = '';
    $output .= '
    <div class="box-radio-check">
            <label class="mb-3 text-btn">' . $title . '</label>';
    $count = 0;
    $total = count($terms) - 1;
    foreach ($terms as $term) {
        $checked = '';
        if ($current_term) {
            $checked = (int)$current_term->term_id === (int)$term->term_id ? 'checked' : '';
        }
        $required = '';
        if ($is_required) {
            $required = ' required';
        }
        $output .= '                
                <fieldset class="fieldset-radio">
                    <input type="radio" class="tf-checkbox style-1" id="term-' . $term->term_id . '" name="' . $name . '" value="' . $term->term_id . '" ' . $checked . ' ' . $required . '>';
        if ($is_required && $count === $total) {
            $output .= '<div class="invalid-feedback">' . __('Campo obrigatório, escolha uma opção', 'mi') . '</div>';
        }
        $output .= '<label for="term-' . $term->term_id . '" class="text-radio">' . $term->name . '</label>
                </fieldset>';
        $count++;
    }
    $output .= '
        </div>';
    return $output;
}

// add_filter('the_editor', 'mi_make_wp_editor_required');

function mi_make_wp_editor_required($output)
{

    $new_output = str_replace(
        '<textarea ',
        '<textarea required ',
        $output
    );

    $new_output = str_replace(
        '</textarea>',
        '</textarea><div class="invalid-feedback">' . __('Campo obrigatório', 'mi') . '</div>',
        $new_output
    );
    // mi_debug($new_output);
    return $new_output;
}

/**
 * mi_faq
 *
 * @param  array $term_posts
 * @param  string $term_name
 * @param  int $term_id
 * @return string
 */
function mi_faq($faq_terms_id, $title_center = true)
{
    $output = '';

    if ($faq_terms_id) {
        $output .= '
        <div class="row mt-5">
                <div class="col-md-12">';
        foreach ($faq_terms_id as $item_arr) {
            $term_id = $item_arr['faq_cat'];
            $args = [

                'post_type' => 'faq',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'faq-cat',
                        'field' => 'term_id',
                        'terms' => $term_id,
                    ),
                ),
                'posts_per_page'        => -1,
                'order'                 => 'ASC',
                'orderby'               => 'menu_order'
            ];
            $term_posts = get_posts($args);
            $term = get_term($term_id);
            if ($term_posts) {
                $term_description = term_description($term_id);
                $term_text_after = get_term_meta($term_id, 'text_after', true);
                $title_alignment = $title_center ? 'text-center' : '';
                $output .= '
        <div class="tf-faq">
            <h3 class="fw-8 ' . $title_alignment . ' title">' . $term->name . '</h3>';
                if ($term_description) {
                    $output .= '<div class="faq-description">' . $term_description . '</div>';
                }
                $output .= '
            <ul class="box-faq" id="wrapper-faq-' . $term_id . '">';
                foreach ($term_posts as $term_post) {
                    $term_post_id = $term_post->ID;
                    $output .= '
                    <li class="faq-item">
                        <a href="#accordion-faq-' . $term_id . '-' . $term_post_id . '" class="faq-header collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="accordion-faq-' . $term_id . '-' . $term_post_id . '">
                            ' . get_the_title($term_post_id) . '
                        </a>
                        <div id="accordion-faq-' . $term_id . '-' . $term_post_id . '" class="collapse" data-bs-parent="#wrapper-faq-' . $term_id . '">
                            <div class="faq-body">
                                ' . get_the_content(null, null, $term_post_id) . '
                            </div>
                        </div>
                    </li>';
                }
                $output .= '
            </ul>';
                if ($term_text_after) {
                    $output .= '<div class="faq-text-after">' . $term_text_after . '</div>';
                }
                $output .= '
        </div>';
            }
        }
    }
    return $output;
}
