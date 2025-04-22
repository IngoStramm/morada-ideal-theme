<?php
$post_id = get_the_ID();
$destaque_title = get_post_meta($post_id, 'destaque_title', true);
$destaque_content = get_post_meta($post_id, 'destaque_content', true);
$destaque_image = get_post_meta($post_id, 'destaque_image', true);
$destaque_btn = get_post_meta($post_id, 'destaque_btn', true);
$destaque_icon = get_post_meta($post_id, 'destaque_icon', true);
$destaque_url = get_post_meta($post_id, 'destaque_url', true);
$destaque_text_after_btn = get_post_meta($post_id, 'destaque_text_after_btn', true);
?>
<section class="destaque">
    <div class="container">
        <div class="row">
            <div class="col-md-6 destaque-image-col">
                <?php if ($destaque_image) { ?>
                    <img class="destaque-image" src="<?php echo $destaque_image; ?>">
                <?php } ?>
            </div>
            <div class="col-md-6 destaque-text-col">
                <?php if ($destaque_title) { ?>
                    <h4 class="destaque-title"><?php echo $destaque_title; ?></h4>
                <?php } ?>
                <?php if ($destaque_content) { ?>
                    <div class="destaque-content"><?php echo wpautop($destaque_content); ?></div>
                <?php } ?>
                <?php if ($destaque_url && $destaque_btn) { ?>
                    <a href="<?php echo $destaque_url; ?>" class="destaque-btn tf-btn secondary">
                        <?php if ($destaque_icon) { ?>
                            <img src="<?php echo $destaque_icon; ?>" class="destaque-btn-icon" />
                        <?php } ?>
                        <?php echo $destaque_btn; ?>
                    </a>
                <?php } ?>
                <?php if ($destaque_text_after_btn) { ?>
                    <div class="destaque-text-after-btn"><?php echo wpautop($destaque_text_after_btn); ?></div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<section class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12 page-content"><?php the_content(); ?></div>
        </div>
    </div>
</section>