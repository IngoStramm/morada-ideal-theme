<?php
$post_id = get_the_ID();
$side_image = get_post_meta($post_id, 'mi_side_image', true);
$redirect_to = get_home_url();
$mi_add_form_register_new_user_nonce = wp_create_nonce('mi_form_register_new_user_nonce');
$contact_id = mi_get_option('mi_contact', false, 'mi_site_pages_options');
?>

<?php do_action('login_announces'); ?>

<div class="static-modal" id="modalLogin">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="flat-account">
                <?php if ($side_image) { ?>
                    <div class="banner-account">
                        <img src="<?php echo $side_image; ?>" alt="banner">
                    </div>
                <?php } ?>
                <form class="form-account needs-validation" name="register-new-user-form" id="register-new-user-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" novalidate>
                    <div class="title-box">
                        <h4><?php the_title(); ?></h4>
                    </div>
                    <div class="box">
                        <fieldset class="box-fieldset">
                            <label for="user_name"><?php _e('Nome', 'mi'); ?></label>
                            <div class="ip-field">
                                <svg class="icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.4869 14.0435C12.9628 13.3497 12.2848 12.787 11.5063 12.3998C10.7277 12.0126 9.86989 11.8115 9.00038 11.8123C8.13086 11.8115 7.27304 12.0126 6.49449 12.3998C5.71594 12.787 5.03793 13.3497 4.51388 14.0435M13.4869 14.0435C14.5095 13.1339 15.2307 11.9349 15.5563 10.6056C15.8818 9.27625 15.7956 7.87934 15.309 6.60014C14.8224 5.32093 13.9584 4.21986 12.8317 3.44295C11.7049 2.66604 10.3686 2.25 9 2.25C7.63137 2.25 6.29508 2.66604 5.16833 3.44295C4.04158 4.21986 3.17762 5.32093 2.69103 6.60014C2.20443 7.87934 2.11819 9.27625 2.44374 10.6056C2.76929 11.9349 3.49125 13.1339 4.51388 14.0435M13.4869 14.0435C12.2524 15.1447 10.6546 15.7521 9.00038 15.7498C7.3459 15.7523 5.74855 15.1448 4.51388 14.0435M11.2504 7.31228C11.2504 7.90902 11.0133 8.48131 10.5914 8.90327C10.1694 9.32523 9.59711 9.56228 9.00038 9.56228C8.40364 9.56228 7.83134 9.32523 7.40939 8.90327C6.98743 8.48131 6.75038 7.90902 6.75038 7.31228C6.75038 6.71554 6.98743 6.14325 7.40939 5.72129C7.83134 5.29933 8.40364 5.06228 9.00038 5.06228C9.59711 5.06228 10.1694 5.29933 10.5914 5.72129C11.0133 6.14325 11.2504 6.71554 11.2504 7.31228Z" stroke="#A3ABB0" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <input type="text" class="form-control" id="user_name" name="user_name" placeholder="<?php _e('Nome', 'mi'); ?>" required>
                                <div class="invalid-feedback ps-5"><?php _e('Campo obrigatório', 'mi'); ?></div>
                            </div>
                        </fieldset>
                        <fieldset class="box-fieldset">
                            <label for="user_surname"><?php _e('Sobrenome', 'mi'); ?></label>
                            <div class="ip-field">
                                <svg class="icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.4869 14.0435C12.9628 13.3497 12.2848 12.787 11.5063 12.3998C10.7277 12.0126 9.86989 11.8115 9.00038 11.8123C8.13086 11.8115 7.27304 12.0126 6.49449 12.3998C5.71594 12.787 5.03793 13.3497 4.51388 14.0435M13.4869 14.0435C14.5095 13.1339 15.2307 11.9349 15.5563 10.6056C15.8818 9.27625 15.7956 7.87934 15.309 6.60014C14.8224 5.32093 13.9584 4.21986 12.8317 3.44295C11.7049 2.66604 10.3686 2.25 9 2.25C7.63137 2.25 6.29508 2.66604 5.16833 3.44295C4.04158 4.21986 3.17762 5.32093 2.69103 6.60014C2.20443 7.87934 2.11819 9.27625 2.44374 10.6056C2.76929 11.9349 3.49125 13.1339 4.51388 14.0435M13.4869 14.0435C12.2524 15.1447 10.6546 15.7521 9.00038 15.7498C7.3459 15.7523 5.74855 15.1448 4.51388 14.0435M11.2504 7.31228C11.2504 7.90902 11.0133 8.48131 10.5914 8.90327C10.1694 9.32523 9.59711 9.56228 9.00038 9.56228C8.40364 9.56228 7.83134 9.32523 7.40939 8.90327C6.98743 8.48131 6.75038 7.90902 6.75038 7.31228C6.75038 6.71554 6.98743 6.14325 7.40939 5.72129C7.83134 5.29933 8.40364 5.06228 9.00038 5.06228C9.59711 5.06228 10.1694 5.29933 10.5914 5.72129C11.0133 6.14325 11.2504 6.71554 11.2504 7.31228Z" stroke="#A3ABB0" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <input type="text" class="form-control" id="user_surname" name="user_surname" placeholder="<?php _e('Sobrenome', 'mi'); ?>" required>
                                <div class="invalid-feedback ps-5"><?php _e('Campo obrigatório', 'mi'); ?></div>
                            </div>
                        </fieldset>
                        <fieldset class="box-fieldset">
                            <label for="user_email"><?php _e('E-mail', 'mi'); ?></label>
                            <div class="ip-field">
                                <i class="icon icon-mail fs-20 text-variant-2"></i>
                                <input type="email" class="form-control" id="user_email" name="user_email" placeholder="<?php _e('E-mail', 'mi'); ?>" required>
                                <div class="invalid-feedback ps-5"><?php _e('Campo obrigatório', 'mi'); ?></div>
                            </div>
                        </fieldset>
                        <fieldset class="box-fieldset">
                            <label for="user_pass"><?php _e('Senha', 'mi'); ?></label>
                            <div class="ip-field">
                                <svg class="icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.375 7.875V5.0625C12.375 4.16739 12.0194 3.30895 11.3865 2.67601C10.7535 2.04308 9.89511 1.6875 9 1.6875C8.10489 1.6875 7.24645 2.04308 6.61351 2.67601C5.98058 3.30895 5.625 4.16739 5.625 5.0625V7.875M5.0625 16.3125H12.9375C13.3851 16.3125 13.8143 16.1347 14.1307 15.8182C14.4472 15.5018 14.625 15.0726 14.625 14.625V9.5625C14.625 9.11495 14.4472 8.68573 14.1307 8.36926C13.8143 8.05279 13.3851 7.875 12.9375 7.875H5.0625C4.61495 7.875 4.18573 8.05279 3.86926 8.36926C3.55279 8.68573 3.375 9.11495 3.375 9.5625V14.625C3.375 15.0726 3.55279 15.5018 3.86926 15.8182C4.18573 16.1347 4.61495 16.3125 5.0625 16.3125Z" stroke="#A3ABB0" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <input type="password" class="form-control" id="user_pass" name="user_pass" placeholder="<?php _e('Senha', 'mi'); ?>" required>
                                <div class="invalid-feedback ps-5"><?php _e('Campo obrigatório', 'mi'); ?></div>
                                <div class="password-meter">
                                    <div class="meter-section rounded me-2"></div>
                                    <div class="meter-section rounded me-2"></div>
                                    <div class="meter-section rounded me-2"></div>
                                    <div class="meter-section rounded"></div>
                                </div>
                                <div id="passwordHelp" class="form-text text-muted"><?php _e('Use 8 ou mais caracteres com uma mistura de letras, números e símbolos.', 'mi'); ?></div>
                            </div>

                            <?php if (mi_get_page_id('login') && mi_get_page_id('lostpassword')) { ?>
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <a href="<?php echo mi_get_page_url('login'); ?>"><?php echo get_the_title(mi_get_page_id('login')); ?></a>
                                    <a href="<?php echo mi_get_page_url('lostpassword'); ?>"><?php echo get_the_title(mi_get_page_id('lostpassword')); ?></a>
                                </div>
                            <?php } ?>
                        </fieldset>
                    </div>
                    <div class="box box-btn">

                        <button type="submit" class="tf-btn primary w-100"><?php _e('Cadastrar', 'mi'); ?></a>

                    </div>

                    <div class="box text-center caption-2"><?php the_content(); ?></div>

                    <input type="hidden" name="mi_form_register_new_user_nonce" value="<?php echo $mi_add_form_register_new_user_nonce ?>" />
                    <input type="hidden" value="mi_register_new_user_form" name="action">
                    <input type="hidden" value="<?php echo esc_attr($redirect_to); ?>" name="redirect_to">
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