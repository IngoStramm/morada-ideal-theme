<?php

add_action('header_dashboard', function () {
    echo mi_control_dashboard_access();
});

/**
 * mi_control_dashboard_access
 *
 * @return string
 */
function mi_control_dashboard_access()
{
    $login_page_id = mi_get_page_id('login');
    if (!is_user_logged_in() && $login_page_id) {
        $post_id = get_the_ID();
        $curr_page_url = get_permalink();
        $_SESSION['mi_login_error_message'] = __('É preciso estar logado para acessar esta área.', 'mi');
        $login_page_url = mi_get_page_url('login');
        $output = '';
        $output .= '
        <script>
        window.location = "' . $login_page_url . '?redirect_to=' . urlencode($curr_page_url) . '";
        </script>
        ';
        return $output;
    }
}

add_action('send_headers', 'mi_edit_imovel_access');

function mi_edit_imovel_access()
{
    $post_id = get_the_ID();
    $edit_imovel_page_id = mi_get_page_id('editimovel');
    if ((int)$post_id !== (int)$edit_imovel_page_id) {
        return;
    }
    $meus_imoveis_url = mi_get_page_url('myimoveis');
    $user_id = get_current_user_id();
    $check_user_permition = mi_check_edit_imovel_user_permition($user_id, $post_id);
    if (!$check_user_permition) {
        $_SESSION['mi_permisssion_error_message'] = __('Você não possui permissão para editar este imóvel.', 'mi');
        wp_safe_redirect($meus_imoveis_url);
        exit;
    }
}
