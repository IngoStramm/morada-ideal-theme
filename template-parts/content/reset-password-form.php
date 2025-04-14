<?php
$post_id = get_the_ID();
$redirect_to = get_home_url();
$mi_add_form_resetpassword_nonce = wp_create_nonce('mi_form_resetpassword_nonce');
$login = isset($_REQUEST['login']) ? $_REQUEST['login'] : null;
$key = isset($_REQUEST['key']) ? $_REQUEST['key'] : null;
$side_image = get_post_meta($post_id, 'mi_side_image', true);
$contact_id = mi_get_option('mi_contact', false, 'mi_site_pages_options');

if (!$login) {
    $_SESSION['mi_resetpassword_error_message'] = __('Usuário ausente. Utilize o link enviado por e-mail para acessar esta página.', 'mi');
}

if (!$key) {
    $_SESSION['mi_resetpassword_error_message'] = __('Chave de redefinição de senha ausente. Utilize o link enviado por e-mail para acessar esta página.', 'mi');
}

do_action('login_announces');
?>

<div class="static-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="flat-account">
                <?php if ($side_image) { ?>
                    <div class="banner-account">
                        <img src="<?php echo $side_image; ?>" alt="banner">
                    </div>
                <?php } ?>
                <form class="form-account needs-validation" name="resetpassword-form" id="resetpassword-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" novalidate>
                    <div class="title-box">
                        <h4><?php the_title(); ?></h4>
                    </div>
                    <div class="box">
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

                    <input type="hidden" name="mi_form_resetpassword_nonce" value="<?php echo $mi_add_form_resetpassword_nonce ?>" />
                    <input type="hidden" name="user_login" value="<?php echo $login; ?>" />
                    <input type="hidden" name="key" value="<?php echo $key; ?>" />
                    <input type="hidden" value="mi_resetpassword_form" name="action">
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