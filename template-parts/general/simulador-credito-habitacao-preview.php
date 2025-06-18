<?php
$user = wp_get_current_user();
$user_id = $user->get('id');
$redirect_to = mi_get_page_url('simuladorcredito');
$mi_add_form_simulador_credito_habitacao_preview_nonce = wp_create_nonce('mi_form_simulador_credito_habitacao_preview_nonce');
?>
<div class="widget-box-2 w-100">
    <form name="simulador-credito-habitacao-preview-form" id="simulador-credito-habitacao-preview-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">

        <?php echo mi_simulador_credito_habitacao_show_campos(); ?>

        <div class="box">
            <button type="submit" class="tf-btn secondary" disabled><?php _e('Calcular crédito habitação*', 'mi'); ?></button>
        </div>
        <input type="hidden" name="mi_form_simulador_credito_habitacao_nonce" value="<?php echo $mi_add_form_simulador_credito_habitacao_preview_nonce ?>" />
        <input type="hidden" value="mi_simulador_credito_habitacao_form" name="action">
        <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
        <input type="hidden" value="<?php echo esc_attr($redirect_to); ?>" name="redirect_to">
    </form>
</div>
<p class="simulador-info">
    <?php echo mi_get_icon('info'); ?>
    <strong><?php _e('Lembra-te que os bancos normalmente pedem uma contribuição mínima de 10%.', 'mi'); ?></strong>
</p>
<p class="fs-12 ps-4"><?php _e('(*) Em desenvolvimento', 'mi'); ?></p>