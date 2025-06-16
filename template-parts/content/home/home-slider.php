<?php
// Random Post
$args = array(
    'post_type'     => 'imovel',
    'order'         => 'ASC',
    'orderby'       => 'rand',
    'posts_per_page'        => 1
);
$random_posts = get_posts($args);
$random_post = is_array($random_posts) && count($random_posts) > 0 ? $random_posts[0] : null;
wp_reset_postdata();
$random_post_thumbnail = '';
if ($random_post) {
    $random_post_thumbnail = has_post_thumbnail($random_post->ID) ? get_the_post_thumbnail_url($random_post->ID, 'full') : mi_get_option('mi_anuncio_default_image');
}
?>
<section class="flat-title-page" style="background-image: url(<?php echo $random_post_thumbnail; ?>);">
    <div class="container relative">
        <?php if ($random_post) { ?>
            <div class="home-slider-random-post">
                <a href="<?php echo get_post_permalink($random_post->ID); ?>">
                    <?php echo get_the_title($random_post->ID); ?>
                </a>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="slider-content">
                    <div class="flat-tab flat-tab-form home-slider-form-container">
                        <div class="tab-content">
                            <div class="tab-pane active show" role="tabpanel">
                                <?php do_action('home_filter_announces'); ?>
                                <h4 class="home-slider-form-title"><?php _e('A casa ideal está aqui! O próximo passo é torna-la tua!', 'mi'); ?></h4>
                                <?php get_template_part('template-parts/content/home/home', 'filter-form'); ?>
                                <div class="form-sl">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="overlay"></div>
</section>