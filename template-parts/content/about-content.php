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
                <div class="page-content ps-md-3">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <?php echo mi_faq($faq_terms_id);  ?>
    </div>
</section>