<?php

add_action('admin_post_mi_update_user_form', 'mi_update_user_form_handle');
add_action('admin_post_nopriv_mi_update_user_form', 'mi_update_user_form_handle');

/**
 * mi_update_user_handle
 *
 * @return void
 */
function mi_update_user_form_handle()
{
    nocache_headers();
    $account_page_id = mi_get_option('mi_account_page');
    $account_page_url = $account_page_id ? get_page_link($account_page_id) : get_home_url();
    unset($_SESSION['mi_update_user_error_message']);

    if (!isset($_POST['mi_form_update_user_nonce']) || !wp_verify_nonce($_POST['mi_form_update_user_nonce'], 'mi_form_update_user_nonce')) {

        $_SESSION['mi_update_user_error_message'] = __('Não foi possível validar a requisição.', 'mi');
        wp_safe_redirect($account_page_url);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'mi_update_user_form') {

        $_SESSION['mi_update_user_error_message'] = __('Formulário inválido.', 'mi');
        wp_safe_redirect($account_page_url);
        exit;
    }

    if (!isset($_POST['user_id']) || !$_POST['user_id']) {

        $_SESSION['mi_update_user_error_message'] = __('ID do usuário inválido.', 'mi');
        wp_safe_redirect($account_page_url);
        exit;
    }
    $user_id = $_POST['user_id'];

    $check_user_exists = get_user_by('id', $user_id);
    if (!$check_user_exists) {

        $_SESSION['mi_update_user_error_message'] = __('Usuário inválido.', 'mi');
        wp_safe_redirect($account_page_url);
        exit;
    }

    $user_name = (isset($_POST['user_name']) && $_POST['user_name']) ? sanitize_text_field($_POST['user_name']) : null;

    $user_surname = (isset($_POST['user_surname']) && $_POST['user_surname']) ? sanitize_text_field($_POST['user_surname']) : null;

    $user_email = (isset($_POST['user_email']) && $_POST['user_email']) ? sanitize_email($_POST['user_email']) : null;

    $user_password = (isset($_POST['user_pass']) && $_POST['user_pass']) ? $_POST['user_pass'] : null;

    $user_phone = (isset($_POST['user_phone']) && $_POST['user_phone']) ? $_POST['user_phone'] : null;

    $user_avatar = isset($_FILES['user_avatar']) && $_FILES['user_avatar'] && isset($_FILES['user_avatar']['name']) && $_FILES['user_avatar']['name'] ? $_FILES['user_avatar'] : null;

    $changed_thumbnail = (isset($_POST['changed-thumbnail']) && $_POST['changed-thumbnail'] && $_POST['changed-thumbnail'] === 'true') ? $_POST['changed-thumbnail'] : null;

    $userdata = array();
    $userdata['ID'] = $user_id;

    if ($user_name) {
        $userdata['user_nicename'] = $user_name;
        $userdata['display_name'] = $user_name;
        $userdata['nickname'] = $user_name;
        $userdata['first_name'] = $user_name;
    }

    if ($user_surname) {
        $userdata['last_name'] = $user_surname;
    }

    if ($user_email) {
        $userdata['user_email'] = $user_email;
    }

    if ($user_password) {
        $userdata['user_pass'] = $user_password;
    }

    $update_user_result = wp_update_user($userdata);

    if (is_wp_error($update_user_result)) {
        $error_string = $update_user_result->get_error_message() ? $update_user_result->get_error_message() : __('Ocorreu um erro ao tentar atualizar os dados do usuário. Revise os dados inseridos e tente novamente.', 'mi');
        $_SESSION['mi_update_user_error_message'] = $error_string;
        wp_safe_redirect($account_page_url);
        exit;
    }

    if ($user_phone) {
        $updated_user_phone = update_user_meta($update_user_result, 'mi_user_phone', $user_phone);
    }

    if ($user_avatar) {
        $file = $user_avatar;
        $filename = $file['name'];
        $file_size = $file['size'];
        $file_tmp_name = $file['tmp_name'];
        $user_avatar_url = '';
        if ($file_size > 2097152) {
            $_SESSION['mi_update_user_error_message'] = sprintf(__('O arquivo %s é muito pesado, o tamanho máximo permitido é de 2MB..', 'mi'), $filename);
            wp_safe_redirect($account_page_url);
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

                $user_avatar_url = wp_get_attachment_url($attach_id);

                update_user_meta($update_user_result, 'mi_user_avatar_id', $attach_id);
            } else {
                $_SESSION['mi_update_user_error_message'] = $attach_id->get_error_message();
                wp_safe_redirect($account_page_url);
                exit;
            }
        } else {
            $_SESSION['mi_update_user_error_message'] = sprintf(__('Ocorreu um erro ao tentar fazer o upload do arquivo %s.', 'mi'), $filename);
            wp_safe_redirect($account_page_url);
            exit;
        }
        $updated_user_avatar = update_user_meta($update_user_result, 'mi_user_avatar', $user_avatar_url);
        if (!$updated_user_avatar) {
            $_SESSION['mi_update_user_error_message'] = __('Ocorreu um erro ao tentar atualizar o avatar do usuário.', 'mi');
            wp_safe_redirect($account_page_url);
            exit;
        }
    } else if ($changed_thumbnail) {
        $deleted_user_avatar = true;
        $deleted_user_avatar_id = true;

        $user_avatar_id = get_user_meta($update_user_result, 'mi_user_avatar_id', true);
        if ($user_avatar_id) {
            $deleted_user_avatar_id = delete_user_meta($update_user_result, 'mi_user_avatar_id');
        }

        $user_avatar = get_user_meta($update_user_result, 'mi_user_avatar', true);
        if ($user_avatar) {
            $deleted_user_avatar = delete_user_meta($update_user_result, 'mi_user_avatar');
        }

        if (!$deleted_user_avatar || !$deleted_user_avatar_id) {
            $_SESSION['mi_update_user_error_message'] = __('Ocorreu um erro ao tentar remover o avatar atual usuário.', 'mi');
            wp_safe_redirect($account_page_url);
            exit;
        }

        if ($user_avatar_id) {
            $delete_user_avatar_attachment = wp_delete_attachment($user_avatar_id);
            if (!$delete_user_avatar_attachment) {
                $_SESSION['mi_update_user_error_message'] = __('Ocorreu um erro ao tentar remover o arquivo do servidor, porém mesmo assim o avatar foi removido do perfil do usuário.', 'mi');
                wp_safe_redirect($account_page_url);
                exit;
            }
        }
    }

    $user = get_user_by('id', $update_user_result);

    $_SESSION['mi_update_user_success_message'] = wp_sprintf(__('Dados do usuário %s atualizados com sucesso!', 'mi'), $user->display_name);

    echo '<h3>' . __('Dados do usuário atualizados com sucesso! Por favor, aguarde enquanto está sendo redicionando...', 'mi') . '</p>';

    wp_safe_redirect($account_page_url);
    exit;
}
