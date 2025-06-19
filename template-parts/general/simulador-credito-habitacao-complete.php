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

                <div class="box-amenities-property half-width">
                    <div class="box-amenities">
                        <div class="title-amenities text-btn"><?php _e('Tipos de casa', 'mi'); ?></div>
                        <div class="list-amenities inline-list">
                            <fieldset class="amenities-item">
                                <input type="checkbox" class="tf-checkbox style-1" id="tipo-casa-principal" checked>
                                <label for="tipo-casa-principal" class="text-cb-amenities"><?php _e('Principal', 'mi'); ?></label>
                            </fieldset>
                            <fieldset class="amenities-item">
                                <input type="checkbox" class="tf-checkbox style-1" id="tipo-casa-secundaria" checked>
                                <label for="tipo-casa-secundaria" class="text-cb-amenities"><?php _e('Secundária', 'mi'); ?></label>
                            </fieldset>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="widget-box-2 widget-box-secondary w-100 mb-30">
                <h6 class="prestacao-titulo"><?php _e('A tua prestação mensal', 'mi'); ?></h6>
                <div class="prestacao-mensal"><span class="prestacao-mensal-valor">443</span> €</div>
                <ul class="simulador-lista-info mb-20">
                    <li>
                        <span>
                            <?php _e('Valor crédito habitação', 'mi'); ?>
                            <a href="#"
                                data-bs-toggle="tooltip"
                                data-bs-custom-class="mi-tooltip"
                                data-bs-html="true"
                                data-bs-title="
                                    <div class='container'>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <div class='custo-total'>126.22 €</div>
                                                <p><?php _e('Custo total do imóvel', 'mi'); ?></p>
                                            </div>
                                            <div class='col-md-6'>
                                                <div class='poupanca-disponivel'>938.14 €</div>
                                                <p><?php _e('A tua poupança disponível', 'mi'); ?></p>
                                            </div>
                                        </div>
                                    </div>">
                                <?php echo mi_get_icon('info'); ?>
                            </a>
                        </span>
                        <span>136.868 €</span>
                    </li>
                    <li>
                        <span>
                            <?php _e('Percentagem de financiamento', 'mi'); ?>
                            <a href="#"
                                data-bs-toggle="tooltip"
                                data-bs-custom-class="mi-tooltip"
                                data-bs-html="true"
                                data-bs-title="<?php _e('Os bancos não costumam financiar mais de 80% do preço de compra, embora em alguns casos cheguem aos 90%, ou mesmo aos 100% se se apresentam mais garantias.', 'mi'); ?>">
                                <?php echo mi_get_icon('info'); ?>
                            </a>
                        </span>
                        <span>68 %</span>
                    </li>
                </ul>
            </div>

            <div class="widget-box-2 w-100">
                <ul class="simulador-lista-info mb-20">
                    <li>
                        <span class="d-flex align-items-center justify-content-start gap-2">
                            <span class="square-block square-block-secondary-lighter"></span>
                            <?php _e('Preço do imóvel', 'mi'); ?>
                        </span>
                        <span>200.000 €</span>
                    </li>
                    <li>
                        <span class="d-flex align-items-center justify-content-start gap-2">
                            <span class="square-block square-block-secondary"></span>
                            <?php _e('Impostos e despesas da compra', 'mi'); ?>
                            <a href="#">
                                <?php echo mi_get_icon('info'); ?>
                            </a>
                        </span>
                        <span>6.868 €</span>
                    </li>
                    <li>
                        <h4><?php _e('Custo total do imóvel', 'mi'); ?></h4>
                        <h4>206.868 €</h4>
                    </li>
                </ul>
                <div class="charts-result mt-2 mb-4">
                    <div class="bar" id="bar-expenses">
                        <div id="total-expenses" class="bar-segment" style="left: 0; width: 30%;"></div>
                        <div id="total-prices" class="bar-segment" style="left: 30%; width: 40%;"></div>
                    </div>
                    <div class="bar" id="bar-amounts">
                        <div id="total-savings" class="bar-segment" style="left: 0; width: 12%;" data-line="saving-line"></div>
                        <div id="total-mortgage" class="bar-segment" style="left: 12%; width: 59%;"></div>
                        <div id="total-interest" class="bar-segment" style="left: 59%; width: 41%;"></div>
                    </div>
                    <div class="saving-line" style="left: 0; width: 12%;"></div>
                    <div class="bar-legends" data-bar="bar-amounts">
                        <div class="bar-legend" data-segment="total-savings" style="left: 0; width: 12%;"><?php _e('A tua poupança disponível', 'mi'); ?></div>
                        <div class="bar-legend" data-segment="total-mortgage" style="left: 12%; width: 59%;"><?php _e('Crédito à Habitação', 'mi'); ?></div>
                        <div class="bar-legend" data-segment="total-interest" style="left: 59%; width: 41%;"><?php _e('Juro', 'mi'); ?></div>
                    </div>
                </div>
                <ul class="simulador-lista-info mb-20">
                    <li>
                        <span class="d-flex align-items-center justify-content-start gap-2">
                            <span class="square-block square-block-primary-lighter"></span>
                            <?php _e('Poupanças', 'mi'); ?>
                        </span>
                        <span>70.000 €</span>
                    </li>
                    <li>
                        <span class="d-flex align-items-center justify-content-start gap-2">
                            <span class="square-block square-block-primary"></span>
                            <?php _e('Valor crédito habitação', 'mi'); ?>
                        </span>
                        <span>136.868 €</span>
                    </li>
                    <li>
                        <span class="d-flex align-items-center justify-content-start gap-2">
                            <span class="square-block square-block-primary-darker"></span>
                            <?php _e('Juros crédito habitação', 'mi'); ?>
                        </span>
                        <span>283.046 €</span>
                    </li>
                    <li>
                        <h4><?php _e('Valor total com crédito habitação', 'mi'); ?></h4>
                        <h4>283.046 €</h4>
                    </li>
                </ul>
                <button type="submit" class="tf-btn secondary mt-30" disabled><?php _e('Encontrar crédito habitação', 'mi'); ?></button>
            </div>
        </div>
    </div>
</form>