<?php
$curr_step = $args['step'];
$post_id = $args['post_id'];
$user_id = $args['user_id'];
$redirect_to = $args['redirect_to'];
$is_required = $post_id ? false : true;

$mi_add_form_new_imovel_step_1_nonce = wp_create_nonce('mi_form_imovel_step_1_nonce');

// Tipo de imóvel

$tipo_terms = get_terms(array(
    'taxonomy'   => 'tipo',
    'hide_empty' => false,
));

$tipo_post_terms = $post_id ? get_the_terms($post_id, 'tipo') : array();
$current_tipo_term = null;
if (is_array($tipo_post_terms)) {
    foreach ($tipo_post_terms as $post_term) {
        if ($post_term->parent !== 0) {
            $current_tipo_term = $post_term;
        }
    }
}

// Aluguel ou venda de imóvel (operação)
$operacao_terms = get_terms(array(
    'taxonomy'   => 'operacao',
    'hide_empty' => false,
));
$operacao_post_terms = $post_id ? get_the_terms($post_id, 'operacao') : array();
$current_operacao_term = count($operacao_post_terms) > 0 ? $operacao_post_terms[0] : null;

$imovel_rua = $post_id ? get_post_meta($post_id, 'imovel_rua', true) : null;
$imovel_lat = $post_id ? get_post_meta($post_id, 'imovel_lat', true) : null;
$imovel_lng = $post_id ? get_post_meta($post_id, 'imovel_lng', true) : null;
$imovel_numero = $post_id ? get_post_meta($post_id, 'imovel_numero', true) : null;
$imovel_codigo_postal = $post_id ? get_post_meta($post_id, 'imovel_codigo_postal', true) : null;
$imovel_cidade = $post_id ? get_post_meta($post_id, 'imovel_cidade', true) : null;
$imovel_estado = $post_id ? get_post_meta($post_id, 'imovel_estado', true) : null;
$price = $post_id ? get_post_meta($post_id, 'imovel_valor', true) : null;

?>
<form name="new-imovel-form" id="new-imovel-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="needs-validation new-imovel-form" enctype="multipart/form-data" novalidate>
    <div class="box grid-2 gap-30">
        <fieldset class="box-fieldset">
            <label><?php _e('Escolhe o tipo de imóvel', 'mi'); ?>:<span>*</span>
            </label>
            <div class="form-style select-list">
                <div class="group-select">
                    <div class="nice-select" tabindex="0"><span class="current"><?php echo $current_tipo_term ? $current_tipo_term->name : __('Selecione', 'mi'); ?></span>
                        <ul class="list">
                            <?php foreach ($tipo_terms as $term) { ?>
                                <?php // Apenas pega 
                                ?>
                                <?php if ($term->parent !== 0) { ?>
                                    <?php $active = isset($current_tipo_term) && $current_tipo_term && (int)$current_tipo_term->term_id === (int)$term->term_id ? 'selected' : ''; ?>
                                    <li data-value="<?php echo $term->name ?>" data-term-id="<?php echo $term->term_id ?>" class="option <?php echo $active; ?>"><?php echo $term->name; ?></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>

                    <input type="hidden" name="tipo-terms" data-select-list-value="<?php echo $current_tipo_term ? $current_tipo_term->term_id : ''; ?>" value="<?php echo $current_tipo_term ? $current_tipo_term->term_id : ''; ?>" required>
                    <div class="ms-2 invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
                </div>
            </div>
        </fieldset>
        <div class="box-radio-check">
            <label class="mb-3"><?php _e('Operação', 'mi'); ?></label>
            <?php foreach ($operacao_terms as $term) { ?>
                <?php $checked = isset($current_operacao_term) && $current_operacao_term && (int)$current_operacao_term->term_id === (int)$term->term_id ? 'checked' : ''; ?>
                <fieldset class="fieldset-radio">
                    <input type="radio" class="tf-checkbox style-1" id="term-<?php echo $term->term_id; ?>" name="operacao-term" value="<?php echo $term->term_id; ?>" <?php echo $checked; ?> required>
                    <label for="term-<?php echo $term->term_id; ?>" class="text-radio"><?php echo $term->name; ?></label>
                </fieldset>
            <?php } ?>
            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
        </div>
    </div>
    <fieldset class="box box-fieldset mt-20">
        <label>
            <?php _e('Localização do imóvel', 'mi'); ?>:<span>*</span>
        </label>
        <?php echo mi_autocomplete_search_input($imovel_lat, $imovel_lng, false, $is_required, false, true); ?>
    </fieldset>

    <div class="box grid-2 gap-30">
        <fieldset class="box-fieldset">
            <label for="imovel_rua">
                <?php _e('Rua', 'mi'); ?><span class="text-danger" data-bs-toggle="tooltip" data-bs-title="<?php _e('Campo obrigatório.', 'mi'); ?>">*</span>
            </label>
            <input name="imovel_rua" id="imovel_rua" value="<?php echo $imovel_rua; ?>" type="text" class="form-control" readonly>
            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
        </fieldset>
        <fieldset class="box-fieldset">
            <label for="imovel_numero">
                <?php _e('Número', 'mi'); ?><span class="text-danger" data-bs-toggle="tooltip" data-bs-title="<?php _e('Campo obrigatório.', 'mi'); ?>">*</span>
            </label>
            <input type="text" name="imovel_numero" id="imovel_numero" class="form-control" value="<?php echo $imovel_numero; ?>" required>
            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
        </fieldset>
    </div>

    <div class="box grid-2 gap-30">
        <fieldset class="box-fieldset">
            <label for="imovel_codigo_postal">
                <?php _e('Código Postal', 'mi'); ?><span class="text-danger" data-bs-toggle="tooltip" data-bs-title="<?php _e('Campo obrigatório.', 'mi'); ?>">*</span>
            </label>
            <input type="text" name="imovel_codigo_postal" id="imovel_codigo_postal" class="form-control" value="<?php echo $imovel_codigo_postal; ?>" readonly>
            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
        </fieldset>
        <fieldset class="box-fieldset">
            <label for="imovel_cidade">
                <?php _e('Cidade', 'mi'); ?><span class="text-danger" data-bs-toggle="tooltip" data-bs-title="<?php _e('Campo obrigatório.', 'mi'); ?>">*</span>
            </label>
            <input name="imovel_cidade" id="imovel_cidade" value="<?php echo $imovel_cidade; ?>" type="text" class="form-control" readonly>
            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
        </fieldset>
    </div>

    <div class="box grid-2 gap-30">
        <fieldset class="box-fieldset">
            <label for="imovel_estado">
                <?php _e('Estado', 'mi'); ?><span class="text-danger" data-bs-toggle="tooltip" data-bs-title="<?php _e('Campo obrigatório.', 'mi'); ?>">*</span>
            </label>
            <input type="text" name="imovel_estado" id="imovel_estado" class="form-control" value="<?php echo $imovel_estado; ?>" readonly>
            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
        </fieldset>
        <fieldset class="box-fieldset">
            <label for="imovel_price">
                <?php _e('Preço', 'mi'); ?><span class="text-danger" data-bs-toggle="tooltip" data-bs-title="<?php _e('Campo obrigatório.', 'mi'); ?>">*</span>
            </label>
            <input name="imovel_price" id="imovel_price" value="<?php echo $price; ?>" type="text" class="form-control" required>
            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
        </fieldset>
    </div>

    <div class="box-btn">
        <button id="new-imovel-form-btn" type="submit" href="#" class="tf-btn primary"><?php _e('Salvar e avançar', 'mi'); ?></button>

    </div>

    <input type="hidden" name="mi_form_imovel_step_1_nonce" value="<?php echo $mi_add_form_new_imovel_step_1_nonce ?>" />
    <input type="hidden" value="mi_imovel_form_step_1" name="action">
    <input type="hidden" value="<?php echo $curr_step; ?>" name="step">
    <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
    <input type="hidden" value="<?php echo $post_id; ?>" name="imovel_id">
    <input type="hidden" value="<?php echo esc_attr($redirect_to); ?>" name="redirect_to">
</form>