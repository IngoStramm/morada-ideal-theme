<?php
$post_id = get_the_ID();
$destaque_1_title = get_post_meta($post_id, 'home_destaque_1_title', true);
$destaque_1_content = get_post_meta($post_id, 'home_destaque_1_content', true);
$destaque_1_image = get_post_meta($post_id, 'home_destaque_1_image', true);
$destaque_1_btn = get_post_meta($post_id, 'home_destaque_1_btn', true);
$destaque_1_icon = get_post_meta($post_id, 'home_destaque_1_icon', true);
$destaque_1_url = get_post_meta($post_id, 'home_destaque_1_url', true);
?>
<section class="destaque">
    <div class="container">
        <div class="row">
            <div class="col-md-6 destaque-image-col">
                <?php if ($destaque_1_image) { ?>
                    <img class="destaque-image" src="<?php echo $destaque_1_image; ?>">
                <?php } ?>
            </div>
            <div class="col-md-6 destaque-text-col">
                <?php if ($destaque_1_title) { ?>
                    <h4 class="destaque-title"><?php echo $destaque_1_title; ?></h4>
                <?php } ?>
                <?php if ($destaque_1_content) { ?>
                    <div class="destaque-content"><?php echo wpautop($destaque_1_content); ?></div>
                <?php } ?>
                <?php if ($destaque_1_url && $destaque_1_btn) { ?>
                    <a href="<?php echo $destaque_1_url; ?>" class="destaque-btn tf-btn secondary">
                        <?php if ($destaque_1_icon) { ?>
                            <img src="<?php echo $destaque_1_icon; ?>" class="destaque-btn-icon" />
                        <?php } ?>
                        <?php echo $destaque_1_btn; ?>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</section>