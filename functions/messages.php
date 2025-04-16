<?php
add_action('login_announces', 'mi_login_error_message');

/**
 * mi_login_error_message
 *
 * @return void
 */
function mi_login_error_message()
{
    // Mensagens de erro de login 
    if (isset($_SESSION['mi_login_error_message']) && $_SESSION['mi_login_error_message']) {
        echo mi_dismissible_alert($_SESSION['mi_login_error_message'], 'danger');
        unset($_SESSION['mi_login_error_message']);
    }

    // Mensagens de erro de reset password 
    if (isset($_SESSION['mi_resetpassword_error_message']) && $_SESSION['mi_resetpassword_error_message']) {
        echo mi_dismissible_alert($_SESSION['mi_resetpassword_error_message'], 'danger');
        unset($_SESSION['mi_resetpassword_error_message']);
    }

    // Mensagens de successo de senha perdida
    if (isset($_SESSION['mi_lostpassword_success_message']) && $_SESSION['mi_lostpassword_success_message']) {
        echo mi_dismissible_alert($_SESSION['mi_lostpassword_success_message'], 'success');
        unset($_SESSION['mi_lostpassword_success_message']);
    }

    // Mensagens de successo de redefinição senha
    if (isset($_SESSION['mi_resetpassword_success_message']) && $_SESSION['mi_resetpassword_success_message']) {
        echo mi_dismissible_alert($_SESSION['mi_resetpassword_success_message'], 'success');
        unset($_SESSION['mi_resetpassword_success_message']);
    }
}

add_action('login_announces', 'mi_lostpassword_error_message');

/**
 * mi_lostpassword_error_message
 *
 * @return void
 */
function mi_lostpassword_error_message()
{
    if (isset($_SESSION['mi_lostpassword_error_message']) && $_SESSION['mi_lostpassword_error_message']) {
        echo mi_dismissible_alert($_SESSION['mi_lostpassword_error_message'], 'alert');
        unset($_SESSION['mi_lostpassword_error_message']);
    }
}

add_action('login_announces', 'mi_new_user_error_message');

/**
 * mi_new_user_error_message
 *
 * @return void
 */
function mi_new_user_error_message()
{
    // Mensagens de erro de registro de novo usuário
    if (isset($_SESSION['mi_register_new_user_error_message']) && $_SESSION['mi_register_new_user_error_message']) {
        echo mi_dismissible_alert($_SESSION['mi_register_new_user_error_message'], 'danger');
        unset($_SESSION['mi_register_new_user_error_message']);
    }
}
add_action('login_announces', 'mi_reset_password_error_message');

/**
 * mi_reset_password_error_message
 *
 * @return void
 */
function mi_reset_password_error_message()
{
    // Mensagens de erro de redefinição de senha 
    if (isset($_SESSION['mi_resetpassword_error_message']) && $_SESSION['mi_resetpassword_error_message']) {
        echo mi_dismissible_alert($_SESSION['mi_resetpassword_error_message'], 'danger');
        unset($_SESSION['mi_resetpassword_error_message']);
    }
}

add_action('dashboard_announces', 'mi_update_user_error_message');

/**
 * mi_update_user_error_message
 *
 * @return void
 */
function mi_update_user_error_message()
{
    // Mensagens de erro de atualização do usuário
    if (isset($_SESSION['mi_update_user_error_message']) && $_SESSION['mi_update_user_error_message']) {
        echo mi_dismissible_alert($_SESSION['mi_update_user_error_message'], 'danger');
        unset($_SESSION['mi_update_user_error_message']);
    }
}

add_action('dashboard_announces', 'mi_update_user_success_message');

/**
 * mi_update_user_success_message
 *
 * @return void
 */
function mi_update_user_success_message()
{
    // Mensagens de successo de atualização do usuário
    if (isset($_SESSION['mi_update_user_success_message']) && $_SESSION['mi_update_user_success_message']) {
        echo mi_dismissible_alert($_SESSION['mi_update_user_success_message'], 'success');
        unset($_SESSION['mi_update_user_success_message']);
    }
}

add_action('dashboard_announces', 'mi_update_imovel_success_dasboard_message');

/**
 * mi_update_imovel_success_dasboard_message
 *
 * @return void
 */
function mi_update_imovel_success_dasboard_message()
{
    if (isset($_SESSION['mi_imovel_success_message']) && $_SESSION['mi_imovel_success_message']) {
        echo mi_dismissible_alert($_SESSION['mi_imovel_success_message']);
        unset($_SESSION['mi_imovel_success_message']);
    }
}

add_action('imovel_single_announces', 'mi_update_imovel_success_single_message');

function mi_update_imovel_success_single_message()
{
    $output = '';
    if (isset($_SESSION['mi_imovel_success_message']) && $_SESSION['mi_imovel_success_message']) {
        $output .= '<div class="container mt-5"><div class="row"><div class="col-md-12">';
        $output .= mi_dismissible_alert($_SESSION['mi_imovel_success_message']);
        $output .= '</div></div></div>';
        echo $output;
        unset($_SESSION['mi_imovel_success_message']);
    }
}

add_action('imovel_single_announces', 'mi_update_imovel_warn_single_message');

function mi_update_imovel_warn_single_message()
{
    $output = '';
    if (isset($_SESSION['mi_imovel_warn_message']) && $_SESSION['mi_imovel_warn_message']) {
        $output .= '<div class="container mt-5"><div class="row"><div class="col-md-12">';
        $output .= mi_dismissible_alert($_SESSION['mi_imovel_warn_message'], 'warning');
        $output .= '</div></div></div>';
        echo $output;
        unset($_SESSION['mi_imovel_warn_message']);
    }
}

add_action('dashboard_announces', 'mi_update_imovel_error_message');

/**
 * mi_update_imovel_error_message
 *
 * @return void
 */
function mi_update_imovel_error_message()
{
    if (isset($_SESSION['mi_imovel_error_message']) && $_SESSION['mi_imovel_error_message']) {
        echo mi_dismissible_alert($_SESSION['mi_imovel_error_message'], 'danger');
        unset($_SESSION['mi_imovel_error_message']);
    }
}

add_action('dashboard_announces', 'mi_permission_imovel_error_message');

/**
 * mi_permission_imovel_error_message
 *
 * @return void
 */
function mi_permission_imovel_error_message()
{
    if (isset($_SESSION['mi_permisssion_error_message']) && $_SESSION['mi_permisssion_error_message']) {
        echo mi_dismissible_alert($_SESSION['mi_permisssion_error_message'], 'danger');
        unset($_SESSION['mi_permisssion_error_message']);
    }
}

add_action('home_filter_announces', 'mi_home_filter_error_message');

/**
 * mi_home_filter_error_message
 *
 * @return void
 */
function mi_home_filter_error_message()
{
    if (isset($_SESSION['mi_home_filter_error_message']) && $_SESSION['mi_home_filter_error_message']) {
        $output = '';
        $output .= mi_dismissible_alert($_SESSION['mi_home_filter_error_message'], 'danger');
        echo $output;
        unset($_SESSION['mi_home_filter_error_message']);
    }
}
