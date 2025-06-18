<?php
$post_id = get_the_ID();
$banner_image = get_post_meta($post_id, 'banner_image', true);
$banner_title = get_post_meta($post_id, 'banner_title', true);
$banner_subtitle = get_post_meta($post_id, 'banner_subtitle', true);
$faq_terms_id = get_post_meta($post_id, 'faq_group', true);
$depoimentos = get_post_meta($post_id, 'depoimentos_group', true);
?>
<section class="flat-title-page page-banner-with-text">
    <div class="container">
        <div class="row">
            <?php if ($banner_image) { ?>
                <img class="banner-user-image" src="<?php echo $banner_image; ?>" />
            <?php } ?>
            <div class="col-lg-6 offset-lg-6">
                <h2 class="banner-title"><?php echo $banner_title; ?></h2>
                <h5 class="banner-subtitle"><?php echo $banner_subtitle; ?></h5>
            </div>
        </div>
    </div>
</section>
<section class="flat-section">
    <div class="container"><?php get_template_part('template-parts/general/simulador', 'credito-habitacao-complete'); ?></div>
</section>
<?php if ($depoimentos && count($depoimentos) > 0) { ?>
    <section class="flat-section">
        <div class="container">
            <div class="box-title px-15">
                <div class="text-center wow fadeInUpSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
                    <h3 class="title mt-4"><?php _e('Opiniões sobre hipotecas', 'mi'); ?></h3>
                </div>
            </div>
            <div dir="ltr" class="swiper tf-sw-testimonial" data-preview="3" data-tablet="2" data-mobile-sm="1" data-mobile="1" data-space="15" data-space-md="30" data-space-lg="30" data-centered="false" data-loop="false">
                <div class="swiper-wrapper">
                    <?php foreach ($depoimentos as $depoimento) { ?>
                        <div class="swiper-slide">
                            <div class="box-tes-item style-2 wow fadeIn" data-wow-delay=".2s" data-wow-duration="2000ms">
                                <span class="icon icon-quote"></span>
                                <p class="note body-2"><?php echo $depoimento['depoimento_text']; ?></p>
                                <div class="box-avt d-flex align-items-center gap-12">
                                    <div class="avatar avt-60 round">
                                        <img src="<?php echo $depoimento['depoimento_avatar']; ?>" alt="avatar">
                                    </div>
                                    <div class="info">
                                        <h6><?php echo $depoimento['depoimento_nome']; ?></h6>
                                        <ul class="list-star">
                                            <?php
                                            $total = intval($depoimento['depoimento_rating']);
                                            for ($i = 0; $i < $total; $i++) {
                                                echo '<li class="icon icon-star"></li>';
                                            } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="sw-pagination sw-pagination-testimonial text-center"></div>
            </div>
        </div>
    </section>
<?php } ?>

<section class="flat-section pt-0">
    <div class="container">
        <?php echo mi_faq($faq_terms_id); ?>
    </div>
</section>