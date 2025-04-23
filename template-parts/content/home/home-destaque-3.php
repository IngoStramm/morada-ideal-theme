<?php
$post_id = get_the_ID();
$destaque_3_title = get_post_meta($post_id, 'home_destaque_3_title', true);
$destaque_3_content = get_post_meta($post_id, 'home_destaque_3_content', true);
$destaque_3_image = get_post_meta($post_id, 'home_destaque_3_image', true);
$destaque_3_btn = get_post_meta($post_id, 'home_destaque_3_btn', true);
$destaque_3_icon = get_post_meta($post_id, 'home_destaque_3_icon', true);
$destaque_3_url = get_post_meta($post_id, 'home_destaque_3_url', true);
?>
<section class="destaque">
    <div class="container">
        <div class="row">
            <div class="col-md-6 destaque-text-col">
                <?php if ($destaque_3_title) { ?>
                    <h4 class="destaque-title"><?php echo $destaque_3_title; ?></h4>
                <?php } ?>
                <?php if ($destaque_3_content) { ?>
                    <div class="destaque-content"><?php echo wpautop($destaque_3_content); ?></div>
                <?php } ?>
                <?php if ($destaque_3_url && $destaque_3_btn) { ?>
                    <a href="<?php echo $destaque_3_url; ?>" class="destaque-btn tf-btn secondary">
                        <?php if ($destaque_3_icon) { ?>
                            <img src="<?php echo $destaque_3_icon; ?>" class="destaque-btn-icon" />
                        <?php } ?>
                        <?php echo $destaque_3_btn; ?>
                    </a>
                <?php } ?>
            </div>
            <div class="col-md-6 destaque-image-col">
                <?php if ($destaque_3_image) { ?>
                    <img class="destaque-image" src="<?php echo $destaque_3_image; ?>">
                <?php } ?>
            </div>
        </div>
    </div>
</section>