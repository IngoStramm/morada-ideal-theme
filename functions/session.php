<?php
add_action('init', 'mi_init_session');

function mi_init_session()
{
    if (!session_id()) {
        session_start();
    }
}

// add_action('wp_head', 'mi_edit_imovel_session');

function mi_edit_imovel_session()
{
    $post_id = get_the_ID();
    $imovel_id = isset($_REQUEST['imovel_id']) && $_REQUEST['imovel_id'] ? $_REQUEST['imovel_id'] : null;
    $session_id = $imovel_id ? $imovel_id : 'new-post';
    $edit_imovel_page_id = mi_get_page_id('editimovel');
    if ((int)$post_id !== (int)$edit_imovel_page_id) {
        unset($_SESSION['imovel_data']);
        mi_debug('limpou imovel_data');
    }
}
