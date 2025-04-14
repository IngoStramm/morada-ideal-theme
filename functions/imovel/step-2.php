<?php

add_action('admin_post_mi_imovel_form_step_2', 'mi_imovel_form_step_2_handle');
add_action('admin_post_nopriv_mi_imovel_form_step_2', 'mi_imovel_form_step_2_handle');

function mi_imovel_form_step_2_handle()
{
    nocache_headers();
    $previous_step = 1;
    $curr_step = 2;
    $next_step = 3;
    $edit_novo_imovel_link = mi_get_page_url('editimovel');
    $meus_imoveis_link = mi_get_page_url('myimoveis');
    $edit_novo_imovel_link = add_query_arg('step', $curr_step, $edit_novo_imovel_link);

    unset($_SESSION['mi_imovel_error_message']);

    // Verifica se o ID do imóvel foi passado
    if (!isset($_POST['imovel_id']) || !$_POST['imovel_id']) {

        $_SESSION['mi_imovel_error_message'] = __('Não foi possível identificar o imóvel.', 'mi');
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }
    $post_id = wp_strip_all_tags($_REQUEST['imovel_id']);

    // Atualiza o imovel_id na url
    $edit_novo_imovel_link = remove_query_arg('imovel_id', $edit_novo_imovel_link);
    $edit_novo_imovel_link = add_query_arg('imovel_id', $post_id, $edit_novo_imovel_link);

    // Verifica se está voltando para a etapa anterior
    if (isset($_POST['previous-step'])) {
        $edit_novo_imovel_link = remove_query_arg('step', $edit_novo_imovel_link);
        $edit_novo_imovel_link = add_query_arg('step', $previous_step, $edit_novo_imovel_link);
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }
    // Então está avançando para a próxima etapa

    // Atualiza a url com a etapa atual para a verificação de erros
    $edit_novo_imovel_link = remove_query_arg('step', $edit_novo_imovel_link);
    $edit_novo_imovel_link = add_query_arg('step', $curr_step, $edit_novo_imovel_link);

    // Verificações de segurança

    // Verifica se o nonce foi passado e se é o nonce correto
    if (!isset($_POST['mi_form_imovel_step_2_nonce']) || !wp_verify_nonce($_POST['mi_form_imovel_step_2_nonce'], 'mi_form_imovel_step_2_nonce')) {

        $_SESSION['mi_imovel_error_message'] = __('Não foi possível validar a requisição.', 'mi');
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    // Verifica se o action foi passado (por input, não o action do form)
    if (!isset($_POST['action']) || $_POST['action'] !== 'mi_imovel_form_step_2') {

        $_SESSION['mi_imovel_error_message'] = __('Formulário inválido.', 'mi');
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    // Verifica se a etapa foi passada
    if (!isset($_REQUEST['step']) || (!$_REQUEST['step'] || (int)$_REQUEST['step'] !== $curr_step)) {
        $_SESSION['mi_imovel_error_message'] = __('Etapa do formulário inválida.', 'mi');
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    // Verifica se o ID do usuário foi passado
    if (!isset($_POST['user_id']) || !$_POST['user_id']) {
        $_SESSION['mi_imovel_error_message'] = __('ID do usuário inválido.', 'mi');
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }
    $user_id = wp_strip_all_tags($_POST['user_id']);

    // Verifica se o usuário existe
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

    // Fim das verificações de segurança

    // dados do form #2
    $dados_form_2 = mi_dados_imovel_form_2();

    // Verificações de erro
    foreach ($dados_form_2 as $name => $dados_array) {
        if (!isset($dados_array['status']) || !$dados_array['status']) {

            $_SESSION['mi_imovel_error_message'] = $dados_array['message'];
            // wp_safe_redirect($edit_novo_imovel_link);
            // exit;
        }
    }

    $edit_novo_imovel_link = remove_query_arg('step', $edit_novo_imovel_link);
    $edit_novo_imovel_link = add_query_arg('step', $next_step, $edit_novo_imovel_link);

    $args = [];

    $args['post_content'] = $dados_form_2['imovel-content']['value'];
    $args['ID'] = $post_id;

    $meta_input = [];
    $meta_input['imovel_area_bruta'] = $dados_form_2['imovel_area_bruta']['value'];
    $meta_input['imovel_area_util'] = $dados_form_2['imovel_area_util']['value'];
    $meta_input['imovel_ano'] = $dados_form_2['imovel_ano']['value'];
    $meta_input['imovel_garagens'] = $dados_form_2['imovel_garagens']['value'];
    $meta_input['imovel_certificado_energetico'] = $dados_form_2['imovel_certificado_energetico']['value'];
    $meta_input['imovel_caracteristicas_especificas'] = $dados_form_2['caracteristicas-especificas']['value'];
    $args['meta_input'] = $meta_input;

    $update_imovel_id = wp_update_post($args, true);
    if (is_wp_error($update_imovel_id)) {
        $error_message = $update_imovel_id->get_error_message();
        $_SESSION['mi_imovel_error_message'] = $error_message;
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    $caracteristicas_gerais_terms_id = $dados_form_2['caracteristicas-gerais-terms']['value'];
    $tipologia_term_id = (int)$dados_form_2['tipologia-term']['value'];
    $outras_denominacoes_terms_id = $dados_form_2['outras-denominacoes-terms']['value'];
    $casas_de_banho_term_id = (int)$dados_form_2['casas-de-banho-term']['value'];
    $estado_terms_id = $dados_form_2['estado-terms']['value'];
    $andar_term_id = (int)$dados_form_2['andar-term']['value'];
    $filtro_terms_id = $dados_form_2['filtro-terms']['value'];

    $caracteristicas_gerais_terms_id = array_map('intval', $caracteristicas_gerais_terms_id);
    $update_caracteristicas_gerais = wp_set_post_terms($update_imovel_id, $caracteristicas_gerais_terms_id, 'caracteristica-geral');
    if (is_wp_error($update_caracteristicas_gerais) || !$update_caracteristicas_gerais) {
        $error_message = is_wp_error($update_caracteristicas_gerais) ? $update_caracteristicas_gerais->get_error_message() : __('Ocorreu um erro ao salvar as características gerais do imóvel');
        $_SESSION['mi_imovel_error_message'] = $error_message;
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    $update_tipologia = wp_set_post_terms($update_imovel_id, array($tipologia_term_id), 'tipologia');
    if (is_wp_error($update_tipologia) || !$update_tipologia) {
        $error_message = is_wp_error($update_tipologia) ? $update_tipologia->get_error_message() : __('Ocorreu um erro ao salvar as casas de banho do imóvel');
        $_SESSION['mi_imovel_error_message'] = $error_message;
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    $outras_denominacoes_terms_id = array_map('intval', $outras_denominacoes_terms_id);
    $update_outras_denominacoes = wp_set_post_terms($update_imovel_id, $outras_denominacoes_terms_id, 'outras-denominacoes');
    if (is_wp_error($update_outras_denominacoes) || !$update_outras_denominacoes) {
        $error_message = is_wp_error($update_outras_denominacoes) ? $update_outras_denominacoes->get_error_message() : __('Ocorreu um erro ao salvar as outras denominações do imóvel');
        $_SESSION['mi_imovel_error_message'] = $error_message;
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    $update_casas_de_banho = wp_set_post_terms($update_imovel_id, array($casas_de_banho_term_id), 'casas-de-banho');
    if (is_wp_error($update_casas_de_banho) || !$update_casas_de_banho) {
        $error_message = is_wp_error($update_casas_de_banho) ? $update_casas_de_banho->get_error_message() : __('Ocorreu um erro ao salvar as casas de banho do imóvel');
        $_SESSION['mi_imovel_error_message'] = $error_message;
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    $estado_terms_id = array_map('intval', $estado_terms_id);
    $update_estado = wp_set_post_terms($update_imovel_id, $estado_terms_id, 'estado');
    if (is_wp_error($update_estado) || !$update_estado) {
        $error_message = is_wp_error($update_estado) ? $update_estado->get_error_message() : __('Ocorreu um erro ao salvar o estado do imóvel');
        $_SESSION['mi_imovel_error_message'] = $error_message;
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    $update_andar = wp_set_post_terms($update_imovel_id, array($andar_term_id), 'andar');
    if (is_wp_error($update_andar) || !$update_andar) {
        $error_message = is_wp_error($update_andar) ? $update_andar->get_error_message() : __('Ocorreu um erro ao salvar o andar do imóvel');
        $_SESSION['mi_imovel_error_message'] = $error_message;
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    $filtro_terms_id = array_map('intval', $filtro_terms_id);
    $update_filtro = wp_set_post_terms($update_imovel_id, $filtro_terms_id, 'filtro');
    if (is_wp_error($update_filtro) || !$update_filtro) {
        $error_message = is_wp_error($update_filtro) ? $update_filtro->get_error_message() : __('Ocorreu um erro ao salvar os filtros do imóvel');
        $_SESSION['mi_imovel_error_message'] = $error_message;
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    // Atualiza a url com a próxima etapa
    $edit_novo_imovel_link = remove_query_arg('step', $edit_novo_imovel_link);
    $edit_novo_imovel_link = add_query_arg('step', $next_step, $edit_novo_imovel_link);

    wp_safe_redirect($edit_novo_imovel_link);
    exit;
}
