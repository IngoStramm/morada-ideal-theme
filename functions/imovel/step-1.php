<?php

add_action('admin_post_mi_imovel_form_step_1', 'mi_imovel_form_step_1_handle');
add_action('admin_post_nopriv_mi_imovel_form_step_1', 'mi_imovel_form_step_1_handle');

function mi_imovel_form_step_1_handle()
{
    nocache_headers();
    $curr_step = 1;
    $edit_novo_imovel_link = mi_get_page_url('editimovel');
    $edit_novo_imovel_link = add_query_arg('step', $curr_step, $edit_novo_imovel_link);
    $meus_imoveis_link = mi_get_page_url('myimoveis');

    $post_id = isset($_REQUEST['imovel_id']) && $_REQUEST['imovel_id'] ? $_REQUEST['imovel_id'] : null;
    if ($post_id) {
        $edit_novo_imovel_link = add_query_arg('imovel_id', $post_id, $edit_novo_imovel_link);
    }
    unset($_SESSION['mi_imovel_error_message']);

    if (!isset($_POST['mi_form_imovel_step_1_nonce']) || !wp_verify_nonce($_POST['mi_form_imovel_step_1_nonce'], 'mi_form_imovel_step_1_nonce')) {

        $_SESSION['mi_imovel_error_message'] = __('Não foi possível validar a requisição.', 'mi');
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'mi_imovel_form_step_1') {

        $_SESSION['mi_imovel_error_message'] = __('Formulário inválido.', 'mi');
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    if (!isset($_REQUEST['step']) || (!$_REQUEST['step'] || (int)$_REQUEST['step'] !== $curr_step)) {
        $_SESSION['mi_imovel_error_message'] = __('Etapa do formulário inválida.', 'mi');
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }
    $next_step = 2;

    if (!isset($_POST['user_id']) || !$_POST['user_id']) {

        $_SESSION['mi_imovel_error_message'] = __('ID do usuário inválido.', 'mi');
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    $user_id = wp_strip_all_tags($_POST['user_id']);
    $check_user_exists = get_user_by('id', $user_id);
    if (!$check_user_exists) {

        $_SESSION['mi_imovel_error_message'] = __('Usuário inválido.', 'mi');
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    // Verifica se o usuário pode editar o imóvel
    $check_user_permition = mi_check_edit_imovel_user_permition($user_id, $post_id);

    if (!$check_user_permition) {
        $_SESSION['mi_imovel_error_message'] = __('Você não possui permissão para editar este imóvel.', 'mi');
        wp_safe_redirect($meus_imoveis_link);
        exit;
    }

    // dados do form #1
    $dados_form_1 = mi_dados_imovel_form_1();

    // Verificações de erro
    foreach ($dados_form_1 as $name => $dados_array) {
        if (!isset($dados_array['status']) || !$dados_array['status']) {

            $_SESSION['mi_imovel_error_message'] = $dados_array['message'];
            wp_safe_redirect($edit_novo_imovel_link);
            exit;
        }
    }

    $tipo_term_id = (int)$dados_form_1['tipo-terms']['value'];
    $operacao_term_id = (int)$dados_form_1['operacao-term']['value'];
    $tipo_term_id = (int)$dados_form_1['tipo-terms']['value'];

    $args = [];

    if ($post_id) {
        // se existir o post, define como publicado
        $post_data = get_post($post_id);
        $tipo = get_term($tipo_term_id, 'tipo');
        $tipo_nome = !is_wp_error($tipo) ? $tipo->name : __('Imóvel', 'mi');
        $args['ID'] = $post_id;
        $args['post_title'] = sprintf(__('%s em %s, %s', 'mi'), $tipo_nome, $dados_form_1['imovel_cidade']['value'], $dados_form_1['imovel_estado']['value']);
        $args['post_content'] = get_post_field('post_content', $post_id);
        $args['post_status'] = 'publish';
        $args['post_author'] = $post_data->post_author;
    } else {
        // senão, define como rascunho
        $args['post_status'] = 'draft';
        $args['post_author'] = $user_id;
        $args['post_title'] = sprintf(__('Rascunho para o imóvel %s', 'mi'), wp_strip_all_tags($_POST['search']));
        $args['post_content'] = '';
        $args['post_excerpt'] = '';
    }
    $args['post_type'] = 'imovel';

    $meta_input = [];
    $meta_input['imovel_rua'] = $dados_form_1['imovel_rua']['value'];
    $meta_input['imovel_numero'] = $dados_form_1['imovel_numero']['value'];
    $meta_input['imovel_codigo_postal'] = $dados_form_1['imovel_codigo_postal']['value'];
    $meta_input['imovel_cidade'] = $dados_form_1['imovel_cidade']['value'];
    $meta_input['imovel_estado'] = $dados_form_1['imovel_estado']['value'];
    $meta_input['imovel_rua'] = $dados_form_1['imovel_rua']['value'];

    $imovel_valor = mi_format_number($dados_form_1['imovel_price']['value']);
    $meta_input['imovel_valor'] = $imovel_valor;

    $meta_input['imovel_lat'] = $dados_form_1['lat']['value'];
    $meta_input['imovel_lng'] = $dados_form_1['lng']['value'];
    $args['meta_input'] = $meta_input;

    $update_imovel_id = wp_insert_post($args, true);
    if (is_wp_error($update_imovel_id)) {
        $error_message = $update_imovel_id->get_error_message();
        $_SESSION['mi_imovel_error_message'] = $error_message;
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    $update_operacao = wp_set_post_terms($update_imovel_id, array($operacao_term_id), 'operacao');
    if (is_wp_error($update_operacao) || !$update_operacao) {
        $error_message = is_wp_error($update_operacao) ? $update_operacao->get_error_message() : __('Ocorreu um erro ao salvar a operação do imóvel');
        $_SESSION['mi_imovel_error_message'] = $error_message;
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    $update_tipo = wp_set_post_terms($update_imovel_id, array($tipo_term_id), 'tipo');
    if (is_wp_error($update_tipo) || !$update_tipo) {
        $error_message = is_wp_error($update_tipo) ? $update_tipo->get_error_message() : __('Ocorreu um erro ao salvar o tipo de imóvel');
        $_SESSION['mi_imovel_error_message'] = $error_message;
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }
    if ($update_imovel_id) {
        $edit_novo_imovel_link = remove_query_arg('imovel_id', $edit_novo_imovel_link);
        $edit_novo_imovel_link = add_query_arg('imovel_id', $update_imovel_id, $edit_novo_imovel_link);
    }
    $edit_novo_imovel_link = remove_query_arg('step', $edit_novo_imovel_link);
    $edit_novo_imovel_link = add_query_arg('step', $next_step, $edit_novo_imovel_link);
    wp_safe_redirect($edit_novo_imovel_link);
    exit;
}
