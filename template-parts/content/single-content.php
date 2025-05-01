<?php
$post_id = get_the_ID();
$imovel_thumbnail = has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, 'full') : mi_get_option('mi_anuncio_default_image');
$imovel_operacao = wp_get_post_terms($post_id, 'operacao');
$imovel_valor = get_post_meta($post_id, 'imovel_valor', true);
$imovel_lat = get_post_meta($post_id, 'imovel_lat', true);
$imovel_lng = get_post_meta($post_id, 'imovel_lng', true);
$imovel_area_bruta = get_post_meta($post_id, 'imovel_area_bruta', true);
$imovel_area_util = get_post_meta($post_id, 'imovel_area_util', true);
$imovel_ano = get_post_meta($post_id, 'imovel_ano', true);
$imovel_garagens = get_post_meta($post_id, 'imovel_garagens', true);
$valor_por_metro = mi_calcula_valor_por_metro($imovel_valor, $imovel_area_bruta);
$imovel_galeria = get_post_meta($post_id, 'imovel_galeria', true);
$imovel_galeria_id = get_post_meta($post_id, '_imovel_galeria_id', true);
$imovel_caracteristicas_especificas = get_post_meta($post_id, 'imovel_caracteristicas_especificas', true);
$imovel_certificado_energetico = get_post_meta($post_id, 'imovel_certificado_energetico', true);
$imovel_rua = get_post_meta($post_id, 'imovel_rua', true);
$imovel_numero = get_post_meta($post_id, 'imovel_numero', true);
$imovel_codigo_postal = get_post_meta($post_id, 'imovel_codigo_postal', true);
$imovel_cidade = get_post_meta($post_id, 'imovel_cidade', true);
$operacao_term = get_the_terms($post_id, 'operacao');
$tipo_terms = wp_get_post_terms($post_id, 'tipo');
$regiao_terms = get_the_terms($post_id, 'regiao');
$caracteristica_geral_terms = get_the_terms($post_id, 'caracteristica-geral');
$outras_denominacoes_terms = get_the_terms($post_id, 'outras-denominacoes');
$imovel_estado = get_post_meta($post_id, 'imovel_estado', true);
$filtro_terms = get_the_terms($post_id, 'filtro');
$andar_terms = get_the_terms($post_id, 'andar');
$user_id = get_current_user_id();
$user_permition = $user_id ? mi_check_edit_imovel_user_permition($user_id, $post_id) : null;
$check_imovel_date = mi_check_imovel_date($post_id);
$imovel_tipologia_terms = get_the_terms($post_id, 'tipologia');
$imovel_tipologia = isset($imovel_tipologia_terms[0]) ? $imovel_tipologia_terms[0]->name : null;
$imovel_casas_banho_terms = wp_get_post_terms($post_id, 'casas-de-banho');
$imovel_casas_banho = isset($imovel_casas_banho_terms[0]) ? $imovel_casas_banho_terms[0]->name : null;
$author_id = get_the_author_meta('ID');
$author_email = get_the_author_meta('email');
$author_name = get_the_author();
$author_avatar = get_user_meta($author_id, 'mi_user_avatar', true);
$author_phone = get_user_meta($author_id, 'mi_user_phone', true);
?>
<?php do_action('imovel_single_announces'); ?>
<div class="flat-section-v4">
    <div class="container">
        <div class="header-property-detail">
            <div class="content-top d-flex justify-content-between align-items-center">
                <h3 class="title link fw-8"><?php the_title(); ?></h3>
                <div class="box-price d-flex align-items-end">
                    <h3 class="fw-8">
                        <?php echo mi_format_money($imovel_valor); ?> €
                    </h3>
                    <?php echo $imovel_operacao[0]->name === 'Arrendar' ? '<span class="body-1 text-variant-1">/' . __('mês', 'mi') . '</span>' : ''; ?>
                </div>
            </div>
            <div class="content-bottom">
                <div class="box-left">
                    <div class="info-box">
                        <div class="label"><?php _e('Características', 'mi'); ?></div>
                        <ul class="meta">
                            <li class="meta-item">
                                <i class="icon icon-bed"></i>
                                <span class="text-variant-1"><?php _e('Tipologia', 'mi'); ?>:</span>
                                <span class="fw-6"><?php echo $imovel_tipologia; ?></span>
                            </li>
                            <li class="meta-item">
                                <i class="icon icon-bath"></i>
                                <span class="text-variant-1"><?php _e('Casas de banho', 'mi'); ?>:</span>
                                <span class="fw-6"><?php echo $imovel_casas_banho; ?></span>
                            </li>
                            <li class="meta-item">
                                <i class="icon icon-sqft"></i>
                                <span class="text-variant-1"><?php _e('Área', 'mi'); ?>:</span>
                                <span class="fw-6"><?php echo $imovel_area_bruta; ?>m²</span>
                            </li>
                        </ul>
                    </div>
                    <div class="info-box">
                        <div class="label"><?php _e('Localização', 'mi'); ?></div>
                        <p class="meta-item"><span class="icon icon-mapPin"></span><span class="text-variant-1">
                                <?php
                                if ($imovel_estado) {
                                    echo $imovel_estado;
                                }
                                if ($imovel_estado) {
                                    echo ', ';
                                }
                                if ($imovel_cidade) {
                                    echo $imovel_cidade;
                                }
                                ?>
                            </span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="flat-section-v3 flat-property-detail">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7">

                <div id="preview-return-point"></div>

                <?php if ($imovel_thumbnail || $imovel_galeria) { ?>
                    <div class="single-property-gallery mb-5">
                        <div class="position-relative">
                            <div dir="ltr" class="swiper sw-single">
                                <div class="swiper-wrapper">
                                    <?php if ($imovel_thumbnail) { ?>
                                        <div class="swiper-slide">
                                            <div class="image-sw-single">
                                                <img src="<?php echo $imovel_thumbnail; ?>" alt="images">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ($imovel_galeria) { ?>
                                        <?php foreach ($imovel_galeria as $image) { ?>
                                            <div class="swiper-slide">
                                                <div class="image-sw-single">
                                                    <img src="<?php echo $image; ?>" alt="images">
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="box-navigation">
                                <div class="navigation swiper-nav-next nav-next-single"><span class="icon icon-arr-l"></span></div>
                                <div class="navigation swiper-nav-prev nav-prev-single"><span class="icon icon-arr-r"></span></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="single-property-element single-property-desc">
                    <h5 class="fw-6 title"><?php _e('Descrição do imóvel', 'mi'); ?></h5>
                    <div class="toogle-preview mb-3">
                        <div class="toogle-preview-content">
                            <div class="imovel-content"><?php the_content(); ?></div>
                        </div>
                        <a href="#" class="toogle-preview-btn" data-text="<?php _e('Ver menos', 'mi'); ?>" data-anchor="preview-return-point"><span class="text"><?php _e('Ver mais', 'mi'); ?></span> </a>
                    </div>
                </div>
                <div class="single-property-element single-property-overview">
                    <h6 class="title fw-6">Overview</h6>
                    <ul class="info-box">
                        <li class="item">
                            <a href="#" class="box-icon w-52"><i class="icon icon-house-line"></i></a>
                            <div class="content">
                                <span class="label">ID:</span>
                                <span><?php echo $post_id; ?></span>
                            </div>
                        </li>

                        <?php if ($tipo_terms && count($tipo_terms) > 0) {
                            echo mi_overview_list_item_term($tipo_terms, 'icon-sliders-horizontal', __('Tipo', 'mi'));
                        } ?>

                        <?php if ($imovel_garagens) {
                            echo mi_overview_list_item_text($imovel_garagens, 'icon-garage', __('Garagens', 'mi'));
                        } ?>

                        <?php if ($imovel_tipologia) {
                            echo mi_overview_list_item_text($imovel_tipologia, 'icon-bed1', __('Tipologia', 'mi'));
                        } ?>

                        <?php if ($imovel_casas_banho) {
                            echo mi_overview_list_item_text($imovel_casas_banho, 'icon-bathtub', __('Casas de banho', 'mi'));
                        } ?>

                        <?php if ($imovel_area_bruta) {
                            echo mi_overview_list_item_text($imovel_area_bruta . ' m²', 'icon-crop', __('Área bruta', 'mi'));
                        } ?>

                        <?php if ($imovel_ano) {
                            echo mi_overview_list_item_text($imovel_ano, 'icon-hammer', __('Construção', 'mi'));
                        } ?>

                        <?php if ($imovel_area_util) {
                            echo mi_overview_list_item_text($imovel_area_util . ' m²', 'icon-ruler', __('Área útil', 'mi'));
                        } ?>

                    </ul>
                </div>
                <div class="single-property-element single-property-feature">
                    <h5 class="title fw-6"><?php _e('Comodidades e características', 'mi'); ?></h5>
                    <div class="wrap-feature">
                        <div class="box-feature">
                            <ul>
                                <?php if ($imovel_caracteristicas_especificas && count($imovel_caracteristicas_especificas) > 0) { ?>
                                    <?php foreach ($imovel_caracteristicas_especificas as $item) { ?>
                                        <?php if (!empty($item) && !is_null($item)) { ?>
                                            <li><?php echo $item; ?></li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

                                <?php if ($caracteristica_geral_terms && count($caracteristica_geral_terms) > 0) { ?>
                                    <?php foreach ($caracteristica_geral_terms as $term) { ?>
                                        <li><?php echo $term->name; ?></li>
                                    <?php } ?>
                                <?php } ?>

                                <?php if ($outras_denominacoes_terms && count($outras_denominacoes_terms) > 0) { ?>
                                    <?php foreach ($outras_denominacoes_terms as $term) { ?>
                                        <li><?php echo $term->name; ?></li>
                                    <?php } ?>
                                <?php } ?>

                                <?php if ($filtro_terms && count($filtro_terms) > 0) { ?>
                                    <?php foreach ($filtro_terms as $term) { ?>
                                        <li><?php echo $term->name; ?></li>
                                    <?php } ?>
                                <?php } ?>

                                <?php if ($andar_terms && count($andar_terms) > 0) { ?>
                                    <?php foreach ($andar_terms as $term) { ?>
                                        <li><?php echo $term->name; ?></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if ($imovel_certificado_energetico) { ?>
                    <div class="single-property-element single-property-feature">
                        <h5 class="title fw-6"><?php _e('Certificado energético', 'mi'); ?></h5>
                        <div class="wrap-feature">
                            <div class="box-feature">
                                <ul>
                                    <li><?php echo $imovel_certificado_energetico; ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="single-property-element single-property-map">
                    <h5 class="title fw-6"><?php _e('Localização', 'mi') ?></h5>
                    <div id="map" class="top-map" data-map-zoom="15" data-map-scroll="true" style="height: 478px;"></div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="single-sidebar fixed-sidebar">
                    <div class="widget-box single-property-contact">
                        <h5 class="title fw-6"><?php _e('Contacte o anunciante', 'mi'); ?></h5>
                        <div class="box-avatar">
                            <div class="info">
                                <h6 class="name"><?php echo $author_name; ?></h6>
                                <ul class="list">
                                    <?php if ($author_phone) { ?>
                                        <li class="d-flex align-items-center gap-4 text-variant-1"><i class="icon icon-phone"></i><?php echo $author_phone; ?></li>
                                    <?php } ?>
                                    <?php if ($author_email) { ?>
                                        <li class="d-flex align-items-center gap-4 text-variant-1"><i class="icon icon-mail"></i><?php echo $author_email; ?></li>
                                    <?php } ?>
                                    <?php if ($author_avatar) { ?>
                                        <li class="d-flex align-items-center gap-4 text-variant-1 mt-3"><img src="<?php echo $author_avatar; ?>" class="user-avatar" alt="avatar"></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <?php echo do_shortcode('[anunciante_contact_form author_id="' . $author_id . '" post_id="' . $post_id . '"]'); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>