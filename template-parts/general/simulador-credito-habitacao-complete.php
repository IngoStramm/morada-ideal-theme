<?php
$user = wp_get_current_user();
$user_id = $user->get('id');
$redirect_to = mi_get_page_url('simuladorcredito');
$mi_add_form_simulador_credito_habitacao_complete_nonce = wp_create_nonce('mi_form_simulador_credito_habitacao_complete_nonce');
?>
<form name="simulador-credito-habitacao-complete-form" id="simulador-credito-habitacao-complete-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
    <div class="row">
        <div class="col-md-6">
            <h3><?php _e('Simulador do crédito habitação', 'mi'); ?></h3>
            <div class="widget-box-2 w-100 mb-20">
                <?php echo mi_simulador_credito_habitacao_show_campos(); ?>
            </div>
            <p class="simulador-info">
                <?php echo mi_get_icon('info'); ?>
                <strong><?php _e('Lembra-te que os bancos normalmente pedem uma contribuição mínima de 10%.', 'mi'); ?></strong>
            </p>
            <div class="widget-box-2 w-100 mb-20">
                <fieldset class="box box-fieldset">
                    <label for="prazo_anos_simulador"><?php _e('Prazo em anos', 'mi'); ?></label>
                    <input type="text" value="0" class="form-control style-1" id="prazo_anos_simulador" name="prazo_anos_simulador">
                    <input type="range" value="0" min="0" max="80" step="1" class="form-range range-input" id="imovel_range_price" name="imovel_range_price" data-label="prazo_anos_simulador">
                </fieldset>

                <div class="box-amenities-property half-width">
                    <div class="box-amenities">
                        <div class="title-amenities text-btn"><?php _e('Tipo de taxa de juros', 'mi'); ?></div>
                        <div class="list-amenities inline-list">
                            <fieldset class="amenities-item">
                                <input type="checkbox" class="tf-checkbox style-1" id="taxa-fixa" checked>
                                <label for="taxa-fixa" class="text-cb-amenities"><?php _e('Fixa', 'mi'); ?></label>
                            </fieldset>
                            <fieldset class="amenities-item">
                                <input type="checkbox" class="tf-checkbox style-1" id="taxa-variavel" checked>
                                <label for="taxa-variavel" class="text-cb-amenities"><?php _e('Variável', 'mi'); ?></label>
                            </fieldset>
                        </div>
                    </div>
                    <div class="box-amenities">
                        <div class="input-number-group">
                            <a href="#" class="input-number-group-btn" data-btn-type="-">-</a>
                            <span class="input-number-group-field-wrapper">
                                <input type="text" data-min="0.00" data-max="100" name="pct-taxa" id="pct-taxa" step="0.01" min="0" class="input-number-group-field" value="0.00">
                                <span class="input-number-group-symbol">%</span>
                            </span>
                            <a href="#" class="input-number-group-btn" data-btn-type="+">+</a>
                        </div>
                    </div>
                </div>

                <fieldset class="box box-fieldset mt-20">
                    <label><?php _e('Localização do imóvel', 'mi'); ?>:
                    </label>
                    <div class="form-style select-list">
                        <div class="group-select">
                            <div class="nice-select" tabindex="0"><span class="current"><?php _e('Selecione', 'mi'); ?></span>
                                <ul class="list">
                                    <?php
                                    $locations = mi_calculadora_locations();
                                    foreach ($locations as $k => $location) { ?>
                                        <li data-value="<?php echo $location ?>" data-term-id="location-<?php echo $k ?>" class="option"><?php echo $location; ?></li>
                                    <?php } ?>
                                </ul>
                            </div>

                            <input type="hidden" name="locations" data-select-list-value="" value="" required>
                            <div class="invalid-feedback"><?php _e('Campo obrigatório', 'mi'); ?></div>
                        </div>
                    </div>
                </fieldset>

            </div>
        </div>
        <div class="col-md-6"></div>
    </div>
</form>