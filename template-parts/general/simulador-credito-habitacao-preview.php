<?php
$user = wp_get_current_user();
$user_id = $user->get('id');
$redirect_to = mi_get_page_url('simuladorcredito');
$mi_add_form_simulador_credito_habitacao_nonce = wp_create_nonce('mi_form_simulador_credito_habitacao_nonce');
?>
<div class="widget-box-2 w-100">
    <form name="simulador-credito-habitacao-form" id="simulador-credito-habitacao-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>

        <fieldset class="box box-fieldset">
            <label for="imovel_price_simulador"><?php _e('Preço do imóvel', 'mi'); ?></label>
            <input type="text" value="0" class="form-control style-1" id="imovel_price_simulador" name="imovel_price_simulador">
            <input type="range" value="0" min="0" max="1000000" step="1000" class="form-range range-input" id="imovel_range_price" name="imovel_range_price" data-label="imovel_price_simulador">
            <?php echo mi_invalid_feedback(); ?>
        </fieldset>

        <fieldset class="box box-fieldset">
            <label for="poupanca"><?php _e('Poupanças', 'mi'); ?></label>
            <input type="text" value="0" class="form-control style-1" id="poupanca" name="poupanca">
            <input type="range" value="0" min="0" max="100000" step="1000" class="form-range range-input style-1" id="poupancas_range" name="poupancas_range" data-label="poupanca">
            <?php echo mi_invalid_feedback(); ?>
        </fieldset>

        <div class="box">
            <button type="submit" class="tf-btn secondary" disabled><?php _e('Calcular crédito habitação*', 'mi'); ?></button>
        </div>
        <input type="hidden" name="mi_form_simulador_credito_habitacao_nonce" value="<?php echo $mi_add_form_simulador_credito_habitacao_nonce ?>" />
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