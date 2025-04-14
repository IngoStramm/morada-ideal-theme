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
    $random_post_thumbnail = get_the_post_thumbnail_url($random_post->ID, 'full');
}
?>
<section class="flat-slider home-1" style="background-image: url(<?php echo $random_post_thumbnail; ?>);">
    <div class="container relative">
        <div class="row">
            <div class="col-lg-12">
                <div class="slider-content">
                    <div class="flat-tab flat-tab-form">
                        <div class="tab-content">
                            <div class="tab-pane active show" role="tabpanel">
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