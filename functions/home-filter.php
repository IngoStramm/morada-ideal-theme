<?php

add_action('admin_post_mi_home_filter_imovel', 'mi_home_filter_imovel_handle');
add_action('admin_post_nopriv_mi_home_filter_imovel', 'mi_home_filter_imovel_handle');

function mi_home_filter_imovel_handle()
{
    nocache_headers();
    $home_url = get_site_url();
    $redirect_to = get_site_url(null, '/imovel/');

    if (!isset($_POST['mi_form_home_filter_imovel_nonce']) || !wp_verify_nonce($_POST['mi_form_home_filter_imovel_nonce'], 'mi_form_home_filter_imovel_nonce')) {
        $_SESSION['mi_home_filter_error_message'] = __('Não foi possível validar a requisição.', 'mi');
        wp_safe_redirect($home_url);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'mi_home_filter_imovel') {
        $_SESSION['mi_home_filter_error_message'] = __('Formulário inválido.', 'mi');
        wp_safe_redirect($home_url);
        exit;
    }
    $operacao_term = isset($_POST['operacao-term']) && $_POST['operacao-term'] ? $_POST['operacao-term'] : null;
    $tipo_terms = isset($_POST['tipo-terms']) && $_POST['tipo-terms'] ? $_POST['tipo-terms'] : null;
    $search = isset($_POST['search']) && $_POST['search'] ? urlencode($_POST['search']) : null;
    $lat = isset($_POST['lat']) && $_POST['lat'] ? $_POST['lat'] : null;
    $lng = isset($_POST['lng']) && $_POST['lng'] ? $_POST['lng'] : null;
    $imovel_estado = isset($_POST['imovel_estado']) && $_POST['imovel_estado'] ? $_POST['imovel_estado'] : null;
    $imovel_cidade = isset($_POST['imovel_cidade']) && $_POST['imovel_cidade'] ? $_POST['imovel_cidade'] : null;
    $imovel_codigo_postal = isset($_POST['imovel_codigo_postal']) && $_POST['imovel_codigo_postal'] ? $_POST['imovel_codigo_postal'] : null;
    $imovel_rua = isset($_POST['imovel_rua']) && $_POST['imovel_rua'] ? $_POST['imovel_rua'] : null;

    $redirect_to = $operacao_term ? add_query_arg('operacao-term', $operacao_term, $redirect_to) : $redirect_to;
    $redirect_to = $tipo_terms ? add_query_arg('tipo-terms', $tipo_terms, $redirect_to) : $redirect_to;
    $redirect_to = $search ? add_query_arg('search', $search, $redirect_to) : $redirect_to;
    $redirect_to = $lat ? add_query_arg('lat', $lat, $redirect_to) : $redirect_to;
    $redirect_to = $lng ? add_query_arg('lng', $lng, $redirect_to) : $redirect_to;
    $redirect_to = $imovel_estado ? add_query_arg('imovel_estado', $imovel_estado, $redirect_to) : $redirect_to;
    $redirect_to = $imovel_cidade ? add_query_arg('imovel_cidade', $imovel_cidade, $redirect_to) : $redirect_to;
    $redirect_to = $imovel_codigo_postal ? add_query_arg('imovel_codigo_postal', $imovel_codigo_postal, $redirect_to) : $redirect_to;
    $redirect_to = $imovel_rua ? add_query_arg('imovel_rua', $imovel_rua, $redirect_to) : $redirect_to;
    wp_safe_redirect($redirect_to);
    exit;
}
