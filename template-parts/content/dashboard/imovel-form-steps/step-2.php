<?php
$curr_step = $args['step'];
$post_id = $args['post_id'];
$user_id = $args['user_id'];
$redirect_to = $args['redirect_to'];

$mi_add_form_new_imovel_step_2_nonce = wp_create_nonce('mi_form_imovel_step_2_nonce');

$caracteristica_geral_terms = get_terms(array(
    'taxonomy'   => 'caracteristica-geral',
    'hide_empty' => false,
));
$caracteristica_geral_post_terms = $post_id ? get_the_terms($post_id, 'caracteristica-geral') : array();
$current_caracteristica_geral_terms = $caracteristica_geral_post_terms && count($caracteristica_geral_post_terms) > 0 ? $caracteristica_geral_post_terms : null;

$tipologia_terms = get_terms(array(
    'taxonomy'   => 'tipologia',
    'hide_empty' => false,
));
$tipologia_post_terms = $post_id ? get_the_terms($post_id, 'tipologia') : array();
$current_tipologia_term = $tipologia_post_terms && count($tipologia_post_terms) > 0 ? $tipologia_post_terms[0] : null;


$outras_denominacoes_terms = get_terms(array(
    'taxonomy'   => 'outras-denominacoes',
    'hide_empty' => false,
));
$outras_denominacoes_post_terms = $post_id ? get_the_terms($post_id, 'outras-denominacoes') : array();
$current_outras_denominacoes_terms = $outras_denominacoes_post_terms && count($outras_denominacoes_post_terms) > 0 ? $outras_denominacoes_post_terms : null;

$casas_de_banho_terms = get_terms(array(
    'taxonomy'   => 'casas-de-banho',
    'hide_empty' => false,
));
$casas_de_banho_post_terms = $post_id ? get_the_terms($post_id, 'casas-de-banho') : array();
$current_casas_de_banho_term = $casas_de_banho_post_terms && count($casas_de_banho_post_terms) > 0 ? $casas_de_banho_post_terms[0] : null;

$estado_terms = get_terms(array(
    'taxonomy'   => 'estado',
    'hide_empty' => false,
));
$estado_post_terms = $post_id ? get_the_terms($post_id, 'estado') : array();
$current_estado_term = $estado_post_terms && count($estado_post_terms) > 0 ? $estado_post_terms[0] : null;


$filtro_terms = get_terms(array(
    'taxonomy'   => 'filtro',
    'hide_empty' => false,
));
$filtro_post_terms = $post_id ? get_the_terms($post_id, 'filtro') : array();
$current_filtro_terms = $filtro_post_terms && count($filtro_post_terms) > 0 ? $filtro_post_terms : null;

$andar_terms = get_terms(array(
    'taxonomy'   => 'andar',
    'hide_empty' => false,
));
$andar_post_terms = $post_id ? get_the_terms($post_id, 'andar') : array();
$current_andar_term = $andar_post_terms && count($andar_post_terms) > 0 ? $andar_post_terms[0] : null;

$imovel_area_util = get_post_meta($post_id, 'imovel_area_util', true);
$imovel_area_bruta = get_post_meta($post_id, 'imovel_area_bruta', true);
$imovel_ano = get_post_meta($post_id, 'imovel_ano', true);
$current_garagem = get_post_meta($post_id, 'imovel_garagens', true);
$garagens_options = mi_garagens_options();
$current_certificado_energetico = get_post_meta($post_id, 'imovel_certificado_energetico', true);
$certificado_energetico_options = mi_certificado_energetico_options();
$caracteristicas_especificas = $post_id ? get_post_meta($post_id, 'imovel_caracteristicas_especificas', true) : array();

?>
<form name="new-imovel-form" id="new-imovel-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="needs-validation new-imovel-form" enctype="multipart/form-data" novalidate>

    <div class="box">
        <fieldset class="box-fieldset">
            <label for="imovel_content">
                <?php _e('Comentário sobre o imóvel', 'mi'); ?><span class="text-danger" data-bs-toggle="tooltip" data-bs-title="<?php _e('Campo obrigatório.', 'mi'); ?>">*</span>
            </label>
            <textarea name="imovel-content" id="imovel-content" class="form-control" required><?php echo get_the_content(null, false, $post_id); ?></textarea>
            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
        </fieldset>
    </div>

    <div class="box grid-3 gap-30">
        <fieldset class="box-fieldset">
            <label for="imovel_area_bruta">
                <?php _e('Área bruta (m²)', 'mi'); ?>
            </label>
            <input type="text" name="imovel_area_bruta" id="imovel_area_bruta" class="form-control" value="<?php echo $imovel_area_bruta; ?>" required>
            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
        </fieldset>

        <fieldset class="box-fieldset">
            <label for="imovel_area_util">
                <?php _e('Área útil (m²)', 'mi'); ?>
            </label>
            <input type="text" name="imovel_area_util" id="imovel_area_util" class="form-control" value="<?php echo $imovel_area_util; ?>" required>
            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
        </fieldset>

        <fieldset class="box-fieldset">
            <label for="imovel_ano">
                <?php _e('Ano de construção', 'mi'); ?>
            </label>
            <input type="text" name="imovel_ano" id="imovel_ano" class="form-control" value="<?php echo $imovel_ano; ?>" required>
            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
        </fieldset>
    </div>


    <div class="box grid-2 gap-30">
        <fieldset class="box-fieldset">
            <label><?php _e('Garagens', 'mi'); ?>:
            </label>
            <div class="form-style select-list">
                <div class="group-select">
                    <div class="nice-select" tabindex="0"><span class="current"><?php echo $current_garagem ? $current_garagem : __('Selecione', 'mi'); ?></span>
                        <ul class="list">
                            <?php foreach ($garagens_options as $option) { ?>
                                <?php $active = $option === $current_garagem ? 'selected' : ''; ?>
                                <li data-value="<?php echo $option ?>" data-term-id="<?php echo $option ?>" class="option <?php echo $active; ?>"><?php echo $option; ?></li>
                            <?php } ?>
                        </ul>
                    </div>

                    <input type="hidden" name="imovel_garagens" data-select-list-value="<?php echo $current_garagem ? $current_garagem : ''; ?>" value="<?php echo $current_garagem ? $current_garagem : ''; ?>" required>
                    <div class="invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
                </div>
            </div>
        </fieldset>
        <fieldset class="box-fieldset">
            <label><?php _e('Certificado energético', 'mi'); ?>:
            </label>
            <div class="form-style select-list">
                <div class="group-select">
                    <div class="nice-select" tabindex="0"><span class="current"><?php echo $current_certificado_energetico ? $current_certificado_energetico : __('Selecione', 'mi'); ?></span>
                        <ul class="list">
                            <?php foreach ($certificado_energetico_options as $option) { ?>
                                <?php // Apenas pega 
                                ?>
                                <?php $active = $option === $current_certificado_energetico ? 'selected' : ''; ?>
                                <li data-value="<?php echo $option ?>" data-term-id="<?php echo $option ?>" class="option <?php echo $active; ?>"><?php echo $option; ?></li>
                            <?php } ?>
                        </ul>
                    </div>

                    <input type="hidden" name="imovel_certificado_energetico" data-select-list-value="<?php echo $current_certificado_energetico ? $current_certificado_energetico : ''; ?>" value="<?php echo $current_certificado_energetico ? $current_certificado_energetico : ''; ?>" required>
                    <div class="invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="box grid-2 gap-30">
        <?php echo mi_checkbox_widget(__('Características gerais', 'mi'), 'caracteristicas-gerais-terms[]', $caracteristica_geral_terms, $current_caracteristica_geral_terms); ?>

        <?php echo mi_radio_widget(__('Tipologia', 'mi'), 'tipologia-term', $tipologia_terms, $current_tipologia_term, true); ?>
    </div>

    <div class="box grid-2 gap-30">
        <?php echo mi_checkbox_widget(__('Outras denominações', 'mi'), 'outras-denominacoes-terms[]', $outras_denominacoes_terms, $current_outras_denominacoes_terms); ?>

        <?php echo mi_radio_widget(__('Casas de banho', 'mi'), 'casas-de-banho-term', $casas_de_banho_terms, $current_casas_de_banho_term, true); ?>
    </div>

    <div class="box grid-2 gap-30">
        <?php echo mi_radio_widget(__('Condição', 'mi'), 'estado-terms[]', $estado_terms, $current_estado_term); ?>

        <?php echo mi_radio_widget(__('Andar', 'mi'), 'andar-term', $andar_terms, $current_andar_term, true); ?>
    </div>

    <div class="box grid-2 gap-30">

        <?php echo mi_checkbox_widget(__('Mais filtros', 'mi'), 'filtro-terms[]', $filtro_terms, $current_filtro_terms); ?>

        <div>
            <h6 class="text-btn mb-3"><?php _e('Adiciona características específicas', 'mi'); ?></h6>
            <div class="mi-repeater">
                <div class="repeater-group">
                    <?php if ($caracteristicas_especificas) { ?>
                        <?php foreach ($caracteristicas_especificas as $k => $caracteristica) { ?>
                            <div class="caracteristica-group repeater-group-list">
                                <fieldset class="box box-fieldset">
                                    <label for="característica-<?php echo $k + 1; ?>"><span class="caracteristica-number"><?php echo $k + 1; ?></span></label>
                                    <div class="input-icon-group">
                                        <input id="característica-<?php echo $k + 1; ?>" type="text" class="form-control style-1" name="caracteristicas-especificas[]" value="<?php echo $caracteristica; ?>">
                                        <a href="#" class="delete-item icon-link"><span class="icon icon-trash"></span></a>
                                    </div>
                                </fieldset>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="caracteristica-group repeater-group-list">
                            <fieldset class="box box-fieldset">
                                <label for="característica-1"><span class="caracteristica-number">1</span></label>
                                <div class="input-icon-group">
                                    <input id="característica-1" type="text" class="form-control style-1" name="caracteristicas-especificas[]" value="">
                                    <a href="#" class="delete-item icon-link"><span class="icon icon-trash"></span></a>
                                </div>
                            </fieldset>
                        </div>
                    <?php } ?>
                </div>
                <div class="text-center">
                    <a href="#" class="btn-add-floor add-group"><span class="icon icon-plus"></span></a>
                </div>

            </div>
        </div>
    </div>

    <div class="box-btn">
        <button type="submit" name="previous-step" class="tf-btn secondary"><?php _e('Voltar para a etapa anterior', 'mi'); ?></button>
        <button id="new-imovel-form-btn" name="next-step" type="submit" class="tf-btn primary"><?php _e('Salvar e avançar', 'mi'); ?></button>

    </div>

    <input type="hidden" name="mi_form_imovel_step_2_nonce" value="<?php echo $mi_add_form_new_imovel_step_2_nonce ?>" />
    <input type="hidden" value="mi_imovel_form_step_2" name="action">
    <input type="hidden" value="<?php echo $curr_step; ?>" name="step">
    <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
    <input type="hidden" value="<?php echo $post_id; ?>" name="imovel_id">
    <input type="hidden" value="<?php echo esc_attr($redirect_to); ?>" name="redirect_to">
</form>