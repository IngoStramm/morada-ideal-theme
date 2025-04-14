<?php

add_action('pre_get_posts', 'mi_filter_query');

/**
 * mi_filter_query
 *
 * @param  mixed $query
 * @return void
 */
function mi_filter_query($wp_query)
{
    if (!is_main_query() || is_admin()) {
        return;
    }

    if (!is_home() && !is_author() && !is_search() && !is_archive()) {
        return;
    }

    if ($wp_query->get('post_type') === 'nav_menu_item') {
        return;
    }

    $filter_params = mi_filters_params();
    $check = false;
    foreach ($filter_params as $params) {
        if (isset($_GET[$params]) && $_GET[$params]) {
            $check = true;
        }
    }

    if (!$check) {
        return;
    }

    $search = isset($_GET['search']) && $_GET['search'] ? $_GET['search'] : null;
    $lat = isset($_GET['lat']) && $_GET['lat'] ? $_GET['lat'] : null;
    $lng = isset($_GET['lng']) && $_GET['lng'] ? $_GET['lng'] : null;
    $imovel_estado = isset($_GET['imovel_estado']) && $_GET['imovel_estado'] ? $_GET['imovel_estado'] : null;
    $imovel_cidade = isset($_GET['imovel_cidade']) && $_GET['imovel_cidade'] ? $_GET['imovel_cidade'] : null;
    $imovel_codigo_postal = isset($_GET['imovel_codigo_postal']) && $_GET['imovel_codigo_postal'] ? $_GET['imovel_codigo_postal'] : null;
    $imovel_rua = isset($_GET['imovel_rua']) && $_GET['imovel_rua'] ? $_GET['imovel_rua'] : null;

    $tipo_terms = isset($_GET['tipo-terms']) && $_GET['tipo-terms'] ? $_GET['tipo-terms'] : null;
    $tipologia_term = isset($_GET['tipologia-term']) && $_GET['tipologia-term'] ? $_GET['tipologia-term'] : null;
    $operacao_term = isset($_GET['operacao-term']) && $_GET['operacao-term'] ? $_GET['operacao-term'] : null;
    $caracteristica_geral_terms = isset($_GET['caracteristica-geral-terms']) && $_GET['caracteristica-geral-terms'] ? $_GET['caracteristica-geral-terms'] : null;

    $preco_max = isset($_GET['preco-max']) && $_GET['preco-max'] ? $_GET['preco-max'] : null;
    $preco_min = isset($_GET['preco-min']) && $_GET['preco-min'] ? $_GET['preco-min'] : null;

    $metragem_imovel_max = isset($_GET['metragem-imovel-max']) && $_GET['metragem-imovel-max'] ? $_GET['metragem-imovel-max'] : null;
    $metragem_imovel_min = isset($_GET['metragem-imovel-min']) && $_GET['metragem-imovel-min'] ? $_GET['metragem-imovel-min'] : null;

    if ($tipo_terms || $tipologia_term || $operacao_term || $caracteristica_geral_terms) {
        $tax_query = array(
            'relation' => 'AND'
        );
        if ($operacao_term) {
            $tax_query[] = array(
                'taxonomy'      => 'operacao',
                'field'         => 'term_id',
                'terms'         => $operacao_term,
            );
        }
        if ($tipo_terms) {
            $tax_query[] = array(
                'taxonomy'      => 'tipo',
                'field'         => 'term_id',
                'terms'         => $tipo_terms,
            );
        }
        if ($tipologia_term) {
            $tax_query[] = array(
                'taxonomy'      => 'tipologia',
                'field'         => 'term_id',
                'terms'         => $tipologia_term,
            );
        }
        if ($caracteristica_geral_terms) {
            $tax_query[] = array(
                'taxonomy'      => 'caracteristica-geral',
                'field'         => 'term_id',
                'terms'         => $caracteristica_geral_terms,
                'operator'      => 'IN'
            );
        }
        $wp_query->set('tax_query', $tax_query);
    }
    $address_meta = array(
        'relation' => 'OR'
    );
    // procura pelo que for digitado no campo de pesquisa
    if ($search) {
        $address_meta[] = array(
            'key' => 'imovel_rua',
            'value' => $search,
            'compare' => 'LIKE',
        );
    }
    if ($search) {
        $address_meta[] = array(
            'key' => 'imovel_codigo_postal',
            'value' => $search,
            'compare' => 'LIKE',
        );
    }
    if ($search) {
        $address_meta[] = array(
            'key' => 'imovel_cidade',
            'value' => $search,
            'compare' => 'LIKE',
        );
    }
    if ($search) {
        $address_meta[] = array(
            'key' => 'imovel_estado',
            'value' => $search,
            'compare' => 'LIKE',
        );
    }
    // procura por cada campo de endereço
    if ($imovel_rua) {
        $address_meta[] = array(
            'key' => 'imovel_rua',
            'value' => $imovel_rua,
            'compare' => 'LIKE',
        );
    }
    if ($imovel_codigo_postal) {
        $address_meta[] = array(
            'key' => 'imovel_codigo_postal',
            'value' => $imovel_codigo_postal,
            'compare' => 'LIKE',
        );
    }
    if ($imovel_cidade) {
        $address_meta[] = array(
            'key' => 'imovel_cidade',
            'value' => $imovel_cidade,
            'compare' => 'LIKE',
        );
    }
    if ($imovel_estado) {
        $address_meta[] = array(
            'key' => 'imovel_estado',
            'value' => $imovel_estado,
            'compare' => 'LIKE',
        );
    }
    if ($lat) {
        $address_meta[] = array(
            'key' => 'imovel_lat',
            'value' => $lat,
            'compare' => 'LIKE',
        );
    }
    if ($lng) {
        $address_meta[] = array(
            'key' => 'imovel_lng',
            'value' => $lng,
            'compare' => 'LIKE',
        );
    }
    $filters_meta = array(
        'relation' => 'AND'
    );
    if ($preco_min) {
        $filters_meta[] = array(
            'key' => 'imovel_valor',
            'value' => floatval($preco_min),
            'compare' => '>=',
            'type' => 'numeric'
        );
    }
    if ($preco_max) {
        $filters_meta[] = array(
            'key' => 'imovel_valor',
            'value' => floatval($preco_max),
            'compare' => '<=',
            'type' => 'numeric'
        );
    }
    if ($metragem_imovel_min) {
        $filters_meta[] = array(
            'key' => 'imovel_area_bruta',
            'value' => floatval($metragem_imovel_min),
            'compare' => '>=',
            'type' => 'numeric'
        );
    }
    if ($metragem_imovel_max) {
        $filters_meta[] = array(
            'key' => 'imovel_area_bruta',
            'value' => floatval($metragem_imovel_max),
            'compare' => '<=',
            'type' => 'numeric'
        );
    }
    $meta_query = array(
        'relation' => 'AND'
    );
    if (strtolower($search) !== 'portugal') {
        $meta_query[] = $address_meta;
    }
    $meta_query[] = $filters_meta;

    $wp_query->set('meta_query', $meta_query);
}
