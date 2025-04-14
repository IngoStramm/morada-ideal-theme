<?php

add_action('wp_ajax_nopriv_mi_anunciante_contact_form', 'mi_anunciante_contact_form');
add_action('wp_ajax_mi_anunciante_contact_form', 'mi_anunciante_contact_form');

function mi_anunciante_contact_form()
{
    if (!isset($_POST['mi_anunciante_contact_form_nonce']) || !wp_verify_nonce($_POST['mi_anunciante_contact_form_nonce'], 'mi_anunciante_contact_form_nonce')) {
        wp_send_json_error(array('msg' => __('Não foi possível validar a requisição.', 'mi')), 200);
    }

    $fields = array('nome', 'phone', 'email', 'mensagem', 'author_id', 'post_id');
    $data = [];
    foreach ($fields as $name) {
        $data[$name] = mi_get_field_value($name);
    }

    $to_user = new WP_User($data['author_id']);
    $to = $to_user->user_email;

    $post_id = $data['post_id'];
    $imovel_title = get_the_title($post_id);
    $imovel_url = esc_url(get_permalink($post_id));
    $subject = sprintf(__('Novo contato para o anúncio "%s" | %s', 'mi'), $imovel_title, get_bloginfo('name'));
    $body = '';
    $body .= '<p>' . sprintf(__('Nome: "%s"', 'mi'), $data['nome']) . '</p>';
    $body .= '<p>' . sprintf(__('Telefone: "%s"', 'mi'), $data['phone']) . '</p>';
    $body .= '<p>' . sprintf(__('Email: "%s"', 'mi'), $data['email']) . '</p>';
    $body .= '<p>' . sprintf(__('Mensagem: "%s"', 'mi'), $data['mensagem']) . '</p>';
    $body .= '<p>' . sprintf(__('Anúncio: <a href="%s">%s</a>', 'mi'), $imovel_url, $imovel_title) . '</p>';
    $send_email_notification = mi_mail($to, $subject, $body);

    if (!$send_email_notification) {
        wp_send_json_error(array('msg' => __('Ocorreu um erro ao tentar enviar a sua mensagem.', 'mi')), 200);
    }

    $response = array(
        'msg'                   => __('Mensagem enviada com sucesso!', 'mi'),
    );

    wp_send_json_success($response);
}
