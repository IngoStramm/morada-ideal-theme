<?php
$post_id = get_the_ID();
$banner = get_post_meta($post_id, 'banner', true);
$image = get_post_meta($post_id, 'image', true);
$faq_terms_id = get_post_meta($post_id, 'faq_group', true);
?>
<section class="page">
    <?php if ($banner) { ?>
        <img class="page-banner" src="<?php echo $banner; ?>">
    <?php } ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?php if ($image) { ?>
                    <img class="img-fluid w-100 mx-auto page-side-image" src="<?php echo $image; ?>" alt="<?php the_title(); ?>">
                <?php } ?>
            </div>
            <div class="col-md-6 d-md-flex flex-md-column align-items-md-start justify-content-md-center">
                <div class="page-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <?php if ($faq_terms_id) { ?>
            <div class="row mt-5">
                <div class="col-md-12">
                    <?php foreach ($faq_terms_id as $item_arr) {
                        $term_id = $item_arr['faq_cat'];
                        $args = [

                            'post_type' => 'faq',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'faq-cat',
                                    'field' => 'term_id',
                                    'terms' => $term_id,
                                ),
                            ),
                            'posts_per_page'        => -1,
                            'order'                 => 'ASC',
                            'orderby'               => 'menu_order'
                        ];
                        $term_posts = get_posts($args);
                        $term = get_term($term_id);
                        if ($term_posts) { ?>
                            <div class="tf-faq">
                                <h3 class="fw-8 text-center title"><?php echo $term->name; ?></h3>
                                <ul class="box-faq" id="wrapper-faq-<?php echo $term_id; ?>">
                                    <?php foreach ($term_posts as $term_post) {
                                        $term_post_id = $term_post->ID;
                                    ?>
                                        <li class="faq-item">
                                            <a href="#accordion-faq-<?php echo $term_id . '-' . $term_post_id; ?>" class="faq-header collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="accordion-faq-<?php echo $term_id . '-' . $term_post_id; ?>">
                                                <?php echo get_the_title($term_post_id); ?>
                                            </a>
                                            <div id="accordion-faq-<?php echo $term_id . '-' . $term_post_id; ?>" class="collapse" data-bs-parent="#wrapper-faq-<?php echo $term_id; ?>">
                                                <div class="faq-body">
                                                    <?php echo get_the_content(null, null, $term_post_id); ?>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                    <?php   }
                    } ?>
                </div>
            </div>
        <?php } ?>

    </div>
</section>