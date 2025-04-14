<?php
$post_id = get_the_ID();
$side_image = get_post_meta($post_id, 'mi_side_image', true);
$redirect_to = get_home_url();
$mi_add_form_lostpassword_nonce = wp_create_nonce('mi_form_lostpassword_nonce');
$contact_id = mi_get_option('mi_contact', false, 'mi_site_pages_options');
?>

<?php do_action('login_announces'); ?>

<div class="static-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="flat-account">
                <?php if ($side_image) { ?>
                    <div class="banner-account">
                        <img src="<?php echo $side_image; ?>" alt="banner">
                    </div>
                <?php } ?>
                <form class="form-account needs-validation" name="lostpassword-form" id="lostpassword-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" novalidate>
                    <div class="title-box">
                        <h4><?php the_title(); ?></h4>
                    </div>
                    <div class="box">
                        <fieldset class="box-fieldset">
                            <label for="user_login"><?php _e('E-mail', 'mi'); ?></label>
                            <div class="ip-field">
                                <svg class="icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.4869 14.0435C12.9628 13.3497 12.2848 12.787 11.5063 12.3998C10.7277 12.0126 9.86989 11.8115 9.00038 11.8123C8.13086 11.8115 7.27304 12.0126 6.49449 12.3998C5.71594 12.787 5.03793 13.3497 4.51388 14.0435M13.4869 14.0435C14.5095 13.1339 15.2307 11.9349 15.5563 10.6056C15.8818 9.27625 15.7956 7.87934 15.309 6.60014C14.8224 5.32093 13.9584 4.21986 12.8317 3.44295C11.7049 2.66604 10.3686 2.25 9 2.25C7.63137 2.25 6.29508 2.66604 5.16833 3.44295C4.04158 4.21986 3.17762 5.32093 2.69103 6.60014C2.20443 7.87934 2.11819 9.27625 2.44374 10.6056C2.76929 11.9349 3.49125 13.1339 4.51388 14.0435M13.4869 14.0435C12.2524 15.1447 10.6546 15.7521 9.00038 15.7498C7.3459 15.7523 5.74855 15.1448 4.51388 14.0435M11.2504 7.31228C11.2504 7.90902 11.0133 8.48131 10.5914 8.90327C10.1694 9.32523 9.59711 9.56228 9.00038 9.56228C8.40364 9.56228 7.83134 9.32523 7.40939 8.90327C6.98743 8.48131 6.75038 7.90902 6.75038 7.31228C6.75038 6.71554 6.98743 6.14325 7.40939 5.72129C7.83134 5.29933 8.40364 5.06228 9.00038 5.06228C9.59711 5.06228 10.1694 5.29933 10.5914 5.72129C11.0133 6.14325 11.2504 6.71554 11.2504 7.31228Z" stroke="#A3ABB0" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <input type="text" class="form-control" id="user_login" name="user_login" placeholder="<?php _e('Seu e-mail', 'mi'); ?>" required>
                                <div class="invalid-feedback ps-5"><?php _e('Campo obrigatório', 'mi'); ?></div>
                            </div>

                            <?php if (mi_get_page_id('newuser') && mi_get_page_id('login')) { ?>
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <a href="<?php echo mi_get_page_url('newuser'); ?>"><?php _e('Cadastre-se', 'mi'); ?></a>
                                    <a href="<?php echo mi_get_page_url('login'); ?>"><?php _e('Entrar', 'mi'); ?></a>
                                </div>
                            <?php } ?>
                        </fieldset>
                    </div>
                    <div class="box box-btn">

                        <button type="submit" class="tf-btn primary w-100"><?php _e('Obter nova senha', 'mi'); ?></a>

                    </div>

                    <div class="box text-center caption-2"><?php the_content(); ?></div>

                    <input type="hidden" name="mi_form_lostpassword_nonce" value="<?php echo $mi_add_form_lostpassword_nonce ?>" />
                    <input type="hidden" value="mi_lostpassword_form" name="action">
                </form>

            </div>
        </div>
    </div>
</div>
<?php if ($contact_id) {
    $url = get_the_permalink($contact_id); ?>
    <div class="d-flex align-items-center justify-content-center mt-5 text">
        <p><?php printf(__('Queres ser nosso parceiro? <strong class="fw-bold">Entra em <a href="%s">contacto</a> connosco aqui.</strong>', 'mi'), $url); ?></p>
    </div>

<?php } ?>