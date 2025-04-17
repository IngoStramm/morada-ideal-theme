<?php
$post_id = get_the_ID();
$image = get_post_meta($post_id, 'image', true);
$subtitle = get_post_meta($post_id, 'subtitle', true);
$faq_terms_id = get_post_meta($post_id, 'faq_group', true);
?>
<section class="page">
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="page-content">
                    <?php if ($subtitle) { ?><h3 class="wp-block-heading"><?php echo $subtitle; ?></h3><?php } ?>
                    <div class="page-content mb-5"><?php the_content(); ?></div>
                    <?php echo do_shortcode('[contact_form]'); ?>
                </div>
            </div>
            <div class="col-md-6">
                <?php if ($image) { ?><img class="img-fluid w-100 mx-auto page-side-image" src="<?php echo $image; ?>"><?php } ?>
            </div>
        </div>
    </div>
    <div class="container pt-5">
        <?php echo mi_faq($faq_terms_id, false);  ?>
    </div>
</section>