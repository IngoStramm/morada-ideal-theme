<?php

add_action('wp_ajax_nopriv_mi_toggle_favorite_form', 'mi_toggle_favorite_form');
add_action('wp_ajax_mi_toggle_favorite_form', 'mi_toggle_favorite_form');

function mi_toggle_favorite_form()
{
    if (!isset($_POST['mi_toggle_favorite_form_nonce']) || !wp_verify_nonce($_POST['mi_toggle_favorite_form_nonce'], 'mi_toggle_favorite_form_nonce')) {
        wp_send_json_error(array('msg' => __('Não foi possível validar a requisição.', 'mi')), 200);
    }

    if (!isset($_POST['post_id']) || !$_POST['post_id']) {
        wp_send_json_error(array('msg' => __('Imóvel não encontrado.', 'mi')), 200);
    }

    if (!isset($_POST['user_id']) || !$_POST['user_id']) {
        wp_send_json_error(array('msg' => __('É necessário estar logado para adicionar um imóvel como favorito.', 'mi')), 200);
    }

    $post_id = (int)$_POST['post_id'];
    $user_id = (int)$_POST['user_id'];
    $favorite_status = 'added';

    // pegar os favoritos do usuário
    // se o usuário ainda não possuir nenhum favorito:
    //      apenas adicionar o id passado ao favorito
    // se já possuir algum favorito
    //      verificar se o id passado já existe nos favoritos
    //          se existir, remover dos favoritos
    //          se não existir, adicionar aos favoritos
    // retornar se o favorito foi adicionado ou removido

    $user_favorites = get_user_meta($user_id, '_user_favorites', true);
    if (!$user_favorites) {
        $user_favorites = array();
        $user_favorites[] = $post_id;
        $update_favorites = update_user_meta($user_id, '_user_favorites', $user_favorites);
        if (!$update_favorites) {
            wp_send_json_error(array('msg' => __('Não foi possível atualizar os favoritos do usuário.', 'mi')), 200);
        }
    } else {
        $favorited = in_array($post_id, $user_favorites);
        if ($favorited) {
            if (($key = array_search($post_id, $user_favorites)) !== false) {
                unset($user_favorites[$key]);
            }
            $favorite_status = '';
        } else {
            $user_favorites[] = $post_id;
        }
        $update_favorites = update_user_meta($user_id, '_user_favorites', $user_favorites);
        if (!$update_favorites) {
            wp_send_json_error(array('msg' => __('Não foi possível atualizar os favoritos do usuário.', 'mi')), 200);
        }
    }

    $response = array(
        'msg'           => __('Favorito atualizado!', 'mi'),
        'status'        => $favorite_status
    );

    wp_send_json_success($response);
}
