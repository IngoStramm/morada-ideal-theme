<?php

add_action('admin_post_mi_imovel_form_step_3', 'mi_imovel_form_step_3_handle');
add_action('admin_post_nopriv_mi_imovel_form_step_3', 'mi_imovel_form_step_3_handle');

function mi_imovel_form_step_3_handle()
{
    nocache_headers();
    $previous_step = 2;
    $curr_step = 3;
    $next_step = 4;
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

    // Verifica se o nonce foi passado e se é o nonce correto
    if (!isset($_POST['mi_form_imovel_step_3_nonce']) || !wp_verify_nonce($_POST['mi_form_imovel_step_3_nonce'], 'mi_form_imovel_step_3_nonce')) {

        $_SESSION['mi_imovel_error_message'] = __('Não foi possível validar a requisição.', 'mi');
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    // Verifica se o action foi passado (por input, não o action do form)
    if (!isset($_POST['action']) || $_POST['action'] !== 'mi_imovel_form_step_3') {

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

    // Atualiza o imovel_id na url
    $edit_novo_imovel_link = remove_query_arg('imovel_id', $edit_novo_imovel_link);
    $edit_novo_imovel_link = add_query_arg('imovel_id', $post_id, $edit_novo_imovel_link);


    // Imagem destacada

    $imovel_thumbnail = isset($_FILES['imovel_thumbnail']) && $_FILES['imovel_thumbnail'] && isset($_FILES['imovel_thumbnail']['name']) && $_FILES['imovel_thumbnail']['name'] ? $_FILES['imovel_thumbnail'] : null;

    $changed_thumbnail = (isset($_POST['changed-thumbnail']) && $_POST['changed-thumbnail'] && $_POST['changed-thumbnail'] === 'true') ? $_POST['changed-thumbnail'] : null;

    if ($imovel_thumbnail) {
        $file = $imovel_thumbnail;
        $filename = $file['name'];
        $file_size = $file['size'];
        $file_tmp_name = $file['tmp_name'];
        $imovel_thumbnail_url = '';
        if ($file_size > 2097152) {
            $_SESSION['mi_update_user_error_message'] = sprintf(__('O arquivo %s é muito pesado, o tamanho máximo permitido é de 2MB..', 'mi'), $filename);
            wp_safe_redirect($edit_novo_imovel_link);
            exit;
        }
        $upload_file = wp_upload_bits($filename, null, @file_get_contents($file_tmp_name));
        // exit;
        if (!$upload_file['error']) {
            // Check the type of file. We'll use this as the 'post_mime_type'.
            $filetype = wp_check_filetype($filename, null);

            // Get the path to the upload directory.
            $wp_upload_dir = wp_upload_dir();

            // Prepare an array of post data for the attachment.
            $attachment = array(
                'post_mime_type' => $filetype['type'],
                'post_title'     => preg_replace('/\.[^.]+$/', '', $filename),
                'post_content'   => '',
                'post_status'    => 'inherit',
            );

            // Insert the attachment.
            $attach_id = wp_insert_attachment($attachment, $upload_file['file']);

            if (!is_wp_error($attach_id)) {
                // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                require_once(ABSPATH . 'wp-admin/includes/image.php');

                // Generate the metadata for the attachment, and update the database record.
                $attach_data = wp_generate_attachment_metadata($attach_id, $upload_file['file']);
                wp_update_attachment_metadata($attach_id, $attach_data);
            } else {
                $_SESSION['mi_update_user_error_message'] = $attach_id->get_error_message();
                wp_safe_redirect($edit_novo_imovel_link);
                exit;
            }
        } else {
            $_SESSION['mi_update_user_error_message'] = sprintf(__('Ocorreu um erro ao tentar fazer o upload do arquivo %s.', 'mi'), $filename);
            wp_safe_redirect($edit_novo_imovel_link);
            exit;
        }
        $updated_thumbnail = set_post_thumbnail($post_id, $attach_id);
        if (!$updated_thumbnail) {
            $_SESSION['mi_update_user_error_message'] = __('Ocorreu um erro ao atualizar a imagem principal do imóvel', 'mi');
            wp_safe_redirect($edit_novo_imovel_link);
            exit;
        }
    } else if ($changed_thumbnail) {
        $deleted_imovel_thumbnail_id = true;

        $imovel_thumbnail_id = get_post_meta($post_id, '_thumbnail_id', true);
        if ($imovel_thumbnail_id) {
            $deleted_imovel_thumbnail_id = delete_post_meta($post_id, '_thumbnail_id');
        }

        if (!$deleted_imovel_thumbnail_id) {
            $_SESSION['mi_update_user_error_message'] = __('Ocorreu um erro ao tentar remover a imagem principal do imóvel.', 'mi');
            wp_safe_redirect($edit_novo_imovel_link);
            exit;
        }

        if ($imovel_thumbnail_id) {
            $delete_imovel_thumbnail_attachment = wp_delete_attachment($imovel_thumbnail_id);
            if (!$delete_imovel_thumbnail_attachment) {
                $_SESSION['mi_update_user_error_message'] = __('Ocorreu um erro ao tentar remover o arquivo do servidor, porém mesmo assim o avatar foi removido do perfil do usuário.', 'mi');
                wp_safe_redirect($edit_novo_imovel_link);
                exit;
            }
        }
    }

    // Galeria de Imagens

    // Galeria de imagens existentes no post (imóvel)
    $imovel_galeria = get_post_meta($post_id, 'imovel_galeria', true);
    $attach_ids_to_delete = [];
    $imovel_galeria_ids = isset($_POST['imovel_galeria_ids']) && $_POST['imovel_galeria_ids'] ? $_POST['imovel_galeria_ids'] : array();

    // Se já existir uma galeria de imagens para o post
    if ($imovel_galeria) {
        foreach ($imovel_galeria as $item_id => $img_url) {
            $attach_exists = in_array($item_id, $imovel_galeria_ids);
            // Verifica se alguma imagem existente foi removida
            mi_debug($attach_exists);
            if (!$attach_exists) {
                // Salva no array os IDs dos attachments a serem removidos
                $attach_ids_to_delete[] = $item_id;
            }
        }
    }


    // Apaga as imagens que não estão mais na galeria
    foreach ($attach_ids_to_delete as $attach_id) {
        // Remove imagem do array da galeria do post
        $item_id = (int)$attach_id;
        unset($imovel_galeria[$item_id]);
        $delete_gallery_image_attachment = wp_delete_attachment($item_id);
        if (!$delete_gallery_image_attachment) {
            $_SESSION['mi_imovel_error_message'] = __('Ocorreu um erro ao tentar remover o arquivo do servidor.', 'mi');
            wp_safe_redirect($edit_novo_imovel_link);
            exit;
        }
    }
    // Remove as imagens apagadas do cmb galeria
    $update_imovel_galeria = update_post_meta($post_id, 'imovel_galeria', $imovel_galeria);
    // atualiza a variável $imovel_galeria
    $imovel_galeria = get_post_meta($post_id, 'imovel_galeria', true);

    $max_img_qty = mi_get_option('mi_anuncio_max_image_qty');
    $curr_img_qty = $imovel_galeria ? count($imovel_galeria) : 0;

    // Verifica se o limite atual de imagens para o imóvel
    if ((int)$curr_img_qty >= (int)$max_img_qty) {
        $_SESSION['mi_imovel_error_message'] = __('Você já atingiu o limite de imagens para o imóvel.', 'mi');
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    // Arquivos que estão sendo feito o upload
    $imovel_galeria_upload = $_FILES['imovel_galeria'];

    // Verifica o limite do imóvel com as imagens que o usuário está sunindo
    if (((int)$curr_img_qty + count($imovel_galeria_upload['tmp_name'])) > (int)$max_img_qty) {
        $_SESSION['mi_imovel_error_message'] = __('Seu limite de imagens para o imóvel não permite subir as imagens selecionadas.', 'mi');
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    // post gallery upload
    if ($imovel_galeria_upload['tmp_name'][0]) {

        $count = 0;
        $imovel_galeria_urls = array();
        foreach ($imovel_galeria_upload['tmp_name'] as $tmp_name) {
            $file = $imovel_galeria_upload;
            $filename = $file['name'][$count];
            $file_size = $file['size'][$count];
            $file_tmp_name = $file['tmp_name'][$count];

            if ($file_size > 2097152) {
                $_SESSION['mi_imovel_error_message'] = sprintf(__('O arquivo %s é muito pesado, o tamanho máximo permitido é de 2MB..', 'mi'), $filename);
                wp_safe_redirect($edit_novo_imovel_link);
                exit;
            }

            $upload_file = wp_upload_bits($filename, null, @file_get_contents($file_tmp_name));
            // exit;
            if ($upload_file['error']) {
                $_SESSION['mi_imovel_error_message'] = sprintf(__('Ocorreu um erro ao tentar fazer o upload do arquivo %s.', 'mi'), $filename);
                wp_safe_redirect($edit_novo_imovel_link);
                exit;
            } else {
                // Check the type of file. We'll use this as the 'post_mime_type'.
                $filetype = wp_check_filetype($filename, null);

                // Get the path to the upload directory.
                $wp_upload_dir = wp_upload_dir();

                // Prepare an array of post data for the attachment.
                $attachment = array(
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => preg_replace('/\.[^.]+$/', '', $filename),
                    'post_content'   => '',
                    'post_status'    => 'inherit',
                    'post_parent'    => $post_id
                );

                // Insert the attachment.
                $attach_id = wp_insert_attachment($attachment, $upload_file['file'], $post_id);

                if (is_wp_error($attach_id)) {
                    $_SESSION['mi_imovel_error_message'] = $attach_id->get_error_message();
                    wp_safe_redirect($edit_novo_imovel_link);
                    exit;
                } else {
                    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                    require_once(ABSPATH . 'wp-admin/includes/image.php');

                    // Generate the metadata for the attachment, and update the database record.
                    $attach_data = wp_generate_attachment_metadata($attach_id, $upload_file['file']);
                    wp_update_attachment_metadata($attach_id, $attach_data);

                    $imovel_galeria_urls[$attach_id] = wp_get_attachment_url($attach_id);
                }
            }
            $count++;
        }
        $new_imovel_galeria_urls = [];
        foreach ($imovel_galeria as $id => $url) {
            $new_imovel_galeria_urls[$id] = $url;
        }
        foreach ($imovel_galeria_urls as $id => $url) {
            $new_imovel_galeria_urls[$id] = $url;
        }
        $updated_gallery = update_post_meta($post_id, 'imovel_galeria', $new_imovel_galeria_urls);
        if (!$updated_gallery) {
            $_SESSION['mi_imovel_error_message'] = __('Ocorreu um erro ao tentar atualizar a galeria de imagens.', 'mi');
            wp_safe_redirect($edit_novo_imovel_link);
            exit;
        }
    }

    $_SESSION['mi_imovel_success_message'] = __('Imóvel atualizado com sucesso!', 'mi');
    if (isset($_POST['draft'])) {
        $meus_imoveis_link = remove_query_arg('step', $meus_imoveis_link);
        $meus_imoveis_link = remove_query_arg('imovel_id', $meus_imoveis_link);
        wp_safe_redirect($meus_imoveis_link);
        exit;
    }

    $args = [
        'ID'            => $post_id,
        'post_status'   => 'publish'
    ];
    $update_imovel_id = wp_update_post($args, true);
    if (is_wp_error($update_imovel_id)) {
        $error_message = $update_imovel_id->get_error_message();
        $_SESSION['mi_imovel_error_message'] = $error_message;
        wp_safe_redirect($edit_novo_imovel_link);
        exit;
    }

    $imovel_url = get_post_permalink($post_id);
    $imovel_url = remove_query_arg('step', $imovel_url);
    $imovel_url = remove_query_arg('imovel_id', $imovel_url);

    wp_safe_redirect($imovel_url);
    exit;
}
