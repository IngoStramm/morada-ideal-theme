<?php
add_action('wp_head', 'mi_alert_draft_imovel');

function mi_alert_draft_imovel($wp_query)
{
    if (!is_singular('imovel')) {
        return;
    }
    $post_id = get_the_ID();
    $post = get_post($post_id);
    if ($post->post_status === 'draft') {
        $_SESSION['mi_imovel_warn_message'] = __('Este imóvel ainda não foi publicado, ele só pode ser visualizado pelo dono do imóvel.', 'mi');
    }
}
