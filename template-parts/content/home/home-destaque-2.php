<?php
$args = array(
    'post_type'                 => 'imovel',
    'orderby'                   => 'rand',
    'posts_per_page'             => 12,
);
$imoveis_em_destaque = new WP_Query($args);
$grid_content_args = array(
    'container_class'       => 'swiper-slide'
);
?>
<?php if ($imoveis_em_destaque->have_posts()) { ?>
    <section class="home-imoveis-em-destaque pb-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="home-imoveis-em-destaque-title"><?php _e('Publicados recentes', 'mi'); ?></h3>
                        <a class="home-imoveis-em-destaque-link" href="<?php echo get_site_url(null, '/imovel/'); ?>"><?php _e('Todos os imóveis', 'mi'); ?><span class="icon icon-arrow-right2"></span></a>
                    </div>
                    <div class="swiper home-destaque-swiper home-imoveis-em-destaque-carousel">
                        <div class="swiper-wrapper">
                            <?php foreach ($imoveis_em_destaque as $imovel) {
                                while ($imoveis_em_destaque->have_posts()) {
                                    $imoveis_em_destaque->the_post();
                                    get_template_part('template-parts/archive/archive', 'grid-content', $grid_content_args);
                                }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }
wp_reset_postdata(); ?>