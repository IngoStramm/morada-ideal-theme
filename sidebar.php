<?php
$sort_params = mi_sort_params();
$filter_params =  mi_filters_params();
// $full_url = $_SERVER['HTTP_REFERER'];
$full_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$has_params = parse_url($full_url, PHP_URL_QUERY);
$reset_url = mi_remove_url_parameters($full_url, $filter_params);
$reset_url = mi_remove_url_parameters($reset_url, array('view'));
$reset_url = explode('page/', $reset_url);
$reset_url = $reset_url[0];
$mapa_view_url = $has_params ? $full_url . '&view=map' : $full_url . '?view=map';
$lista_view_url = mi_remove_url_parameters($full_url, array('view'));
$operacao_terms = get_terms(array(
    'taxonomy'   => 'operacao',
    'hide_empty' => false,
));
$selected_operacao_term_id = isset($_GET['operacao-term']) && $_GET['operacao-term'] ? $_GET['operacao-term'] : null;
?>

<?php
$mapstatic_key = mi_get_option('mapstatic_key', false, 'mi_google_keys_options');
$imovel_lat = isset($_GET['lat']) && $_GET['lat'] ? $_GET['lat'] : null;
$imovel_lng = isset($_GET['lng']) && $_GET['lng'] ? $_GET['lng'] : null;
if ($mapstatic_key && $imovel_lat && $imovel_lng) {
    if (!isset($_GET['view']) || $_GET['view'] !== 'map') { ?>
        <div class="static-map-container widget-sidebar mb-4">
            <?php
            $static_img_src = "
            https://maps.googleapis.com/maps/api/staticmap?size=400x400&center=$imovel_lat,$imovel_lng&zoom=12&format=png&maptype=roadmap&language=pt&key=$mapstatic_key";
            ?>
            <div class="widget-filter-search widget-box position-relative">
                <img class="img-fluid static-map" src="<?php echo $static_img_src; ?>" />
                <a href="<?php echo $mapa_view_url; ?>" class="tf-btn btn-view primary hover-btn-view btn-toggle-map-view"><?php _e('Ver no mapa', 'mi'); ?>
                    <span class="icon icon-arrow-right2"></span>
                </a>
            </div>
        </div>
    <?php } else { ?>
        <a href="<?php echo $lista_view_url; ?>" class="tf-btn btn-view primary hover-btn-view w-100 btn-toggle-map-view mb-4"><?php _e('Ver lista', 'mi'); ?> <span class="icon icon-arrow-right2"></span></a>
    <?php } ?>
<?php } ?>

<div class="widget-sidebar">
    <div class="flat-tab flat-tab-form widget-filter-search widget-box">
        <form role="filter" method="get" name="filter-imoveis" action="<?php echo $reset_url; ?>">
            <?php if ($operacao_terms) { ?>
                <div class="list-btns">
                    <ul class="nav-tab-form" id="operacao-filter">
                        <li class="nav-tab-item">
                            <a href="#" class="nav-link-item <?php echo !$selected_operacao_term_id ? 'active' : ''; ?>" data-term-id=""><?php _e('Todos', 'mi'); ?></a>
                        </li>
                        <?php foreach ($operacao_terms as $term) { ?>
                            <?php $active = $term->term_id === (int)$selected_operacao_term_id ? 'active' : ''; ?>
                            <li class="nav-tab-item">
                                <a href="#" class="nav-link-item <?php echo $active; ?>" data-term-id="<?php echo $term->term_id ?>"><?php echo $term->name; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <input type="hidden" name="operacao-term" id="operacao-term" value="<?php echo $selected_operacao_term_id; ?>">
                </div>
            <?php } ?>
            <div class="wd-filter-select">
                <div class="inner-group">
                    <div class="box">
                        <?php
                        $tipo_terms = get_terms(array(
                            'taxonomy'   => 'tipo',
                            'hide_empty' => false,
                        ));
                        $selected_tipo_term_id = isset($_GET['tipo-terms']) && $_GET['tipo-terms'] ? $_GET['tipo-terms'] : null;
                        ?>
                        <?php if ($tipo_terms) { ?>

                            <div class="form-style select-list">

                                <div class="group-select">
                                    <div class="nice-select" tabindex="0"><span class="current"><?php _e('Tipo de imóvel', 'mi'); ?></span>
                                        <ul class="list">
                                            <li data-value="" data-term-id="" class="option"><?php _e('Tipo de imóvel', 'mi'); ?></li>
                                            <?php foreach ($tipo_terms as $term) { ?>
                                                <li data-value="<?php echo $term->name; ?>" data-term-id="<?php echo $term->term_id; ?>" class="option"><?php echo $term->name; ?></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="tipo-terms" data-select-list-value value="<?php echo $selected_tipo_term_id; ?>">
                                </div>
                            </div>
                        <?php } ?>
                        <?php echo mi_autocomplete_search_input(); ?>
                    </div>
                    <div class="box">

                        <?php echo mi_range_widget('slider-range', __('Preço', 'mi'), mi_get_min_prices(), mi_get_max_prices(), 'preco-min', 'preco-max'); ?>

                        <?php echo mi_range_widget('slider-range2', __('Área', 'mi'), mi_get_min_area(), mi_get_max_area(), 'metragem-imovel-min', 'metragem-imovel-max'); ?>

                    </div>

                    <?php
                    $tipologia_terms = get_terms(array(
                        'taxonomy'   => 'tipologia',
                        'hide_empty' => false,
                    ));
                    $selected_tipologia_term_id = isset($_GET['tipologia-term']) && $_GET['tipologia-term'] ? $_GET['tipologia-term'] : null;
                    ?>

                    <?php if (count($tipologia_terms) > 0) {
                        echo mi_radio_list(__('Tipologia', 'mi'), $tipologia_terms, $selected_tipologia_term_id, 'tipologia');
                    } ?>

                    <?php
                    $caracteristica_geral_terms = get_terms(array(
                        'taxonomy'   => 'caracteristica-geral',
                        'hide_empty' => false,
                    ));
                    $selected_caracteristica_geral_terms_id = isset($_GET['caracteristica-geral-terms']) && $_GET['caracteristica-geral-terms'] ? $_GET['caracteristica-geral-terms'] : null;
                    ?>

                    <?php if (count($caracteristica_geral_terms) > 0) {
                        echo mi_radio_list(__('Características Gerais', 'mi'), $caracteristica_geral_terms, $selected_caracteristica_geral_terms_id, 'caracteristica-geral', false, true);
                    } ?>

                    <?php
                    echo mi_add_query_params_as_inputs($sort_params);
                    // echo mi_search_params();
                    ?>

                    <div class="form-style">
                        <button type="submit" class="tf-btn btn-view primary hover-btn-view"><?php _e('Filtrar', 'mi'); ?> <span class="icon icon-arrow-right2"></span></button>
                    </div>

                    <div class="form-style">
                        <a class="tf-btn btn-view secondary hover-btn-view" href="<?php echo $reset_url; ?>"><?php _e('Resetar filtro', ' mi') ?> <span class="icon icon-close2"></span></a>
                    </div>
                </div>
            </div>
            <?php if (isset($_GET['view']) && $_GET['view']) { ?>
                <input type="hidden" name="view" value="<?php echo $_GET['view']; ?>">
            <?php } ?>
        </form>
    </div>
</div>