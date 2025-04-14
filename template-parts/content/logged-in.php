<?php
$post_id = get_the_ID();
$side_image = get_post_meta($post_id, 'mi_side_image', true);
$current_user = wp_get_current_user();
$account_page_ul = mi_get_page_url('dashboard');
?>
<div class="static-modal" id="modalLogin">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="flat-account">
                <?php if ($side_image) { ?>
                    <div class="banner-account">
                        <img src="<?php echo $side_image; ?>" alt="banner">
                    </div>
                <?php } ?>
                <div class="form-account">
                    <div class="title-box">
                        <h4><?php _e('Você já está logado!', 'mi'); ?></h4>
                    </div>
                    <div class="box d-flex flex-column align-items-start justify-content-start gap-3">
                        <?php if ($account_page_ul) { ?>

                            <a class="tf-btn primary" href="<?php echo $account_page_ul; ?>"><?php _e('Acesse a sua conta', 'mi'); ?></a>

                        <?php } ?>

                        <a class="tf-btn" href="<?php echo wp_logout_url(get_permalink()); ?>"><?php _e('Sair', 'mi'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>