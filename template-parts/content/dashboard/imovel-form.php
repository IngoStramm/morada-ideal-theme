<?php
$curr_step = $args['step'];
$post_id = isset($_REQUEST['imovel_id']) && $_REQUEST['imovel_id'] ? $_REQUEST['imovel_id'] : null;
$args['post_id'] = $post_id;

$operacao_terms = get_terms(array(
    'taxonomy'   => 'operacao',
    'hide_empty' => false,
));

$tipo_terms = get_terms(array(
    'taxonomy'   => 'tipo',
    'hide_empty' => false,
));

$regiao_terms = get_terms(array(
    'taxonomy'   => 'regiao',
    'hide_empty' => false,
));

$caracteristica_geral_terms = get_terms(array(
    'taxonomy'   => 'caracteristica-geral',
    'hide_empty' => false,
));

$tipologia_terms = get_terms(array(
    'taxonomy'   => 'tipologia',
    'hide_empty' => false,
));

$outras_denominacoes_terms = get_terms(array(
    'taxonomy'   => 'outras-denominacoes',
    'hide_empty' => false,
));

$casas_de_banho_terms = get_terms(array(
    'taxonomy'   => 'casas-de-banho',
    'hide_empty' => false,
));

$estado_terms = get_terms(array(
    'taxonomy'   => 'estado',
    'hide_empty' => false,
));

$filtro_terms = get_terms(array(
    'taxonomy'   => 'filtro',
    'hide_empty' => false,
));

$andar_terms = get_terms(array(
    'taxonomy'   => 'andar',
    'hide_empty' => false,
));

$user = wp_get_current_user();
$user_id = $user->get('id');
$args['user_id'] = $user_id;
$account_page_id = mi_get_option('mi_account_page');
$redirect_to = $account_page_id ? get_page_link($account_page_id) : get_home_url();
$args['redirect_to'] = $redirect_to;

$post = get_post($post_id);
$title = $post_id ? get_the_title($post_id) : null;
$price = $post_id ? get_post_meta($post_id, 'imovel_valor', true) : null;
$imovel_area_bruta = $post_id ? get_post_meta($post_id, 'imovel_area_bruta', true) : null;
$imovel_area_util = $post_id ? get_post_meta($post_id, 'imovel_area_util', true) : null;
$imovel_ano = $post_id ? get_post_meta($post_id, 'imovel_ano', true) : null;
$imovel_garagens = $post_id ? get_post_meta($post_id, 'imovel_garagens', true) : null;
$imovel_galeria = $post_id ? get_post_meta($post_id, 'imovel_galeria', true) : array();
$imovel_rua = $post_id ? get_post_meta($post_id, 'imovel_rua', true) : null;
$imovel_lat = $post_id ? get_post_meta($post_id, 'imovel_lat', true) : null;
$imovel_lng = $post_id ? get_post_meta($post_id, 'imovel_lng', true) : null;
$imovel_numero = $post_id ? get_post_meta($post_id, 'imovel_numero', true) : null;
$imovel_codigo_postal = $post_id ? get_post_meta($post_id, 'imovel_codigo_postal', true) : null;
$imovel_cidade = $post_id ? get_post_meta($post_id, 'imovel_cidade', true) : null;
$imovel_estado = $post_id ? get_post_meta($post_id, 'imovel_estado', true) : null;

$operacao_post_terms = $post_id ? get_the_terms($post_id, 'operacao') : array();
$operacao_post_terms_id = array();
if (is_array($operacao_post_terms)) {
    foreach ($operacao_post_terms as $post_term) {
        $operacao_post_terms_id[] = $post_term->term_id;
    }
}
$current_operacao_term = count($operacao_post_terms) > 0 ? $operacao_post_terms[0] : null;

$tipo_post_terms = $post_id ? get_the_terms($post_id, 'tipo') : array();
$tipo_post_terms_id = array();
$current_tipo_term = null;
if (is_array($tipo_post_terms)) {
    foreach ($tipo_post_terms as $post_term) {
        $tipo_post_terms_id[] = $post_term->term_id;
        if ($post_term->parent !== 0) {
            $current_tipo_term = $post_term;
        }
    }
}

$regiao_post_terms = $post_id ? get_the_terms($post_id, 'regiao') : array();
$regiao_post_terms_id = array();
if (is_array($regiao_post_terms)) {
    foreach ($regiao_post_terms as $post_term) {
        $regiao_post_terms_id[] = $post_term->term_id;
    }
}

$caracteristica_geral_post_terms = $post_id ? get_the_terms($post_id, 'caracteristica-geral') : array();
$caracteristica_geral_post_terms_id = array();
if (is_array($caracteristica_geral_post_terms)) {
    foreach ($caracteristica_geral_post_terms as $post_term) {
        $caracteristica_geral_post_terms_id[] = $post_term->term_id;
    }
}

$tipologia_post_terms = $post_id ? get_the_terms($post_id, 'tipologia') : array();
$tipologia_post_terms_id = array();
if (is_array($tipologia_post_terms)) {
    foreach ($tipologia_post_terms as $post_term) {
        $tipologia_post_terms_id[] = $post_term->term_id;
    }
}

$outras_denominacoes_post_terms = $post_id ? get_the_terms($post_id, 'outras-denominacoes') : array();
$outras_denominacoes_post_terms_id = array();
if (is_array($outras_denominacoes_post_terms)) {
    foreach ($outras_denominacoes_post_terms as $post_term) {
        $outras_denominacoes_post_terms_id[] = $post_term->term_id;
    }
}

$casas_de_banho_post_terms = $post_id ? get_the_terms($post_id, 'casas-de-banho') : array();
$casas_de_banho_post_terms_id = array();
if (is_array($casas_de_banho_post_terms)) {
    foreach ($casas_de_banho_post_terms as $post_term) {
        $casas_de_banho_post_terms_id[] = $post_term->term_id;
    }
}

$estado_post_terms = $post_id ? get_the_terms($post_id, 'estado') : array();
$estado_post_terms_id = array();
if (is_array($estado_post_terms)) {
    foreach ($estado_post_terms as $post_term) {
        $estado_post_terms_id[] = $post_term->term_id;
    }
}

$filtro_post_terms = $post_id ? get_the_terms($post_id, 'filtro') : array();
$filtro_post_terms_id = array();
if (is_array($filtro_post_terms)) {
    foreach ($filtro_post_terms as $post_term) {
        $filtro_post_terms_id[] = $post_term->term_id;
    }
}

$andar_post_terms = $post_id ? get_the_terms($post_id, 'andar') : array();
$andar_post_terms_id = array();
if (is_array($andar_post_terms)) {
    foreach ($andar_post_terms as $post_term) {
        $andar_post_terms_id[] = $post_term->term_id;
    }
}

$post_thumbnail = $post_id ? get_the_post_thumbnail($post_id, array('100', '100'), array('loading' => false, 'class' => 'img-fluid rounded my-2')) : null;
$post_thumbnail_url = $post_id ? get_the_post_thumbnail_url($post_id, 'full') : null;

$imovel_caracteristicas_especificas = $post_id ? get_post_meta($post_id, 'imovel_caracteristicas_especificas', true) : array();

get_template_part('template-parts/content/dashboard/imovel-form-steps/step', $curr_step, $args);
