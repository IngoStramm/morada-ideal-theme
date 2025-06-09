<?php
add_action('admin_post_mi_remove_favorite_form', 'mi_remove_favorite_form');
add_action('admin_post_nopriv_mi_remove_favorite_form', 'mi_remove_favorite_form');

function mi_remove_favorite_form()
{
    nocache_headers();
    $redirect_to = mi_get_page_url('favorites');

    unset($_SESSION['mi_favorite_error_message']);

    if (!isset($_POST['mi_remove_favorite_form_nonce']) || !wp_verify_nonce($_POST['mi_remove_favorite_form_nonce'], 'mi_remove_favorite_form_nonce')) {

        $_SESSION['mi_favorite_error_message'] = __('Não foi possível validar a requisição.', 'mi');
        wp_safe_redirect($redirect_to);
        exit;
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'mi_remove_favorite_form') {

        $_SESSION['mi_favorite_error_message'] = __('Formulário inválido.', 'mi');
        wp_safe_redirect($redirect_to);
        exit;
    }

    if (!isset($_POST['user_id']) || !$_POST['user_id']) {

        $_SESSION['mi_favorite_error_message'] = __('ID do usuário inválido.', 'mi');
        wp_safe_redirect($redirect_to);
        exit;
    }

    $user_id = wp_strip_all_tags($_POST['user_id']);
    $check_user_exists = get_user_by('id', $user_id);
    if (!$check_user_exists) {

        $_SESSION['mi_favorite_error_message'] = __('Usuário inválido.', 'mi');
        wp_safe_redirect($redirect_to);
        exit;
    }
    $user_id = (int)$user_id;

    if (!isset($_POST['post_id']) || !$_POST['post_id']) {

        $_SESSION['mi_favorite_error_message'] = __('ID do imóvel inválido.', 'mi');
        wp_safe_redirect($redirect_to);
        exit;
    }
    $post_id = (int)$_POST['post_id'];
    $user_favorites = get_user_meta($user_id, '_user_favorites', true);
    $nout_found_msg = __('Imóvel não encontrado nos favoritos do usuário.', 'mi');

    if ($user_favorites) {
        $favorited = in_array($post_id, $user_favorites);
        if ($favorited) {
            if (($key = array_search($post_id, $user_favorites)) !== false) {
                unset($user_favorites[$key]);
                $update_favorites = update_user_meta($user_id, '_user_favorites', $user_favorites);
                if ($update_favorites) {
                    $_SESSION['mi_favorite_success_message'] = __('Favorito removido.', 'mi');
                } else {
                    $_SESSION['mi_favorite_error_message'] = __('Não foi possível remover o favorito.', 'mi');
                }
            } else {
                $_SESSION['mi_favorite_warning_message'] = 1 . ' ' . $nout_found_msg;
            }
        } else {
            $_SESSION['mi_favorite_warning_message'] = 2 . ' ' . $nout_found_msg;
        }
    } else {
        $_SESSION['mi_favorite_warning_message'] = 3 . ' ' . $nout_found_msg;
    }
    wp_safe_redirect($redirect_to);
    exit;
}
