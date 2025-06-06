<?php get_sidebar('dashboard'); ?>

<?php
$user = wp_get_current_user();
$user_id = $user->get('id');
$user_avatar_url = get_user_meta($user_id, 'mi_user_avatar', true);
$user_phone = get_user_meta($user_id, 'mi_user_phone', true);
$account_page_id = mi_get_option('mi_account_page');
$redirect_to = $account_page_id ? get_page_link($account_page_id) : get_home_url();
$mi_add_form_update_user_nonce = wp_create_nonce('mi_form_update_user_nonce');
?>

<div class="main-content">
    <div class="main-content-inner wrap-dashboard-content-2">
        <?php get_template_part('template-parts/content/dashboard/dashboard-inner', 'top'); ?>
        <div class="widget-box-2">
            <form name="update-user-form" id="update-user-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                <div class="box">
                    <h4 class="title"><?php echo sprintf(__('Olá, %s %s!'), $user->first_name, $user->last_name); ?></h4>
                    <p><?php _e('Nesta página você pode alterar os seus dados pessoais.', 'mi') ?></p>
                </div>
                <h5 class="title"><?php the_title(); ?></h5>
                <div class="box grid-2 gap-30">

                    <div class="box-fieldset">
                        <label for="user_name"><?php _e('Nome', 'mi'); ?><span>*</span></label>
                        <input type="text" value="<?php echo $user->get('first_name'); ?>" class="form-control style-1" id="user_name" name="user_name" required>
                        <?php echo mi_invalid_feedback(); ?>
                    </div>

                    <div class="box-fieldset">
                        <label for="user_surname"><?php _e('Sobrenome', 'mi'); ?><span>*</span></label>
                        <input type="text" value="<?php echo $user->get('last_name'); ?>" class="form-control style-1" id="user_surname" name="user_surname" required>
                        <?php echo mi_invalid_feedback(); ?>
                    </div>

                </div>
                <div class="box grid-2 gap-30">
                    <div class="box-fieldset">
                        <label for="user_email"><?php _e('E-mail', 'mi') ?>:<span>*</span></label>
                        <input type="email" value="<?php echo $user->get('user_email'); ?>" class="form-control style-1" id="user_email" name="user_email" required>
                        <?php echo mi_invalid_feedback(); ?>
                    </div>
                    <div class="box-fieldset">
                        <label for="user_phone"><?php _e('Telefone de Contacto', 'mi') ?>:<span>*</span></label>
                        <input type="text" placeholder="+351" value="<?php echo $user_phone; ?>" class="form-control style-1" id="user_phone" name="user_phone" required>
                        <?php echo mi_invalid_feedback(); ?>
                    </div>
                </div>
                <div class="box grid-2 gap-30">
                    <div class="box-fieldset">
                        <h5 class="title"><?php _e('Alterar palavra-passe', 'mi'); ?></h5>
                        <label for="user_pass"><?php _e('Palavra-passe', 'mi'); ?>:<span>*</span></label>
                        <div class="box-password">
                            <input type="password" class="form-contact style-1 password-field" placeholder="<?php _e('Palavra-passe', 'mi'); ?>" name="user_pass" id="user_pass" autocomplete="off" aria-autocomplete="list" aria-label="<?php _e('Palavra-passe', 'mi'); ?>" aria-describedby="passwordHelp">
                            <span class="show-pass">
                                <i class="icon-pass icon-eye"></i>
                                <i class="icon-pass icon-eye-off"></i>
                            </span>
                            <?php echo mi_invalid_feedback(); ?>
                            <div class="password-meter">
                                <div class="meter-section rounded me-2"></div>
                                <div class="meter-section rounded me-2"></div>
                                <div class="meter-section rounded me-2"></div>
                                <div class="meter-section rounded"></div>
                            </div>
                            <div id="passwordHelp" class="form-text text-muted"><?php _e('Use 8 ou mais carateres com uma mistura de letras, números e símbolos.', 'mi'); ?></div>
                        </div>
                    </div>
                    <div class="box-fieldset mi-file-image-preview">
                        <h5 class="title"><?php _e('Imagem', 'mi') ?></h5>
                        <div class="box-agent-avt">
                            <div>
                                <div class="img-poster user-avatar-preview images-preview">
                                    <?php if ($user_avatar_url) { ?>
                                        <img class="image-preview" src="<?php echo $user_avatar_url; ?>" loading="lazy">
                                    <?php } ?>
                                </div>
                                <a class="remove-file item btn-clear-image mt-1" <?php echo $user_avatar_url ? '' : 'style="display: none;"'; ?>>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.82667 6.00035L9.596 12.0003M6.404 12.0003L6.17333 6.00035M12.8187 3.86035C13.0467 3.89501 13.2733 3.93168 13.5 3.97101M12.8187 3.86035L12.1067 13.1157C12.0776 13.4925 11.9074 13.8445 11.63 14.1012C11.3527 14.3579 10.9886 14.5005 10.6107 14.5003H5.38933C5.0114 14.5005 4.64735 14.3579 4.36999 14.1012C4.09262 13.8445 3.92239 13.4925 3.89333 13.1157L3.18133 3.86035M12.8187 3.86035C12.0492 3.74403 11.2758 3.65574 10.5 3.59568M3.18133 3.86035C2.95333 3.89435 2.72667 3.93101 2.5 3.97035M3.18133 3.86035C3.95076 3.74403 4.72416 3.65575 5.5 3.59568M10.5 3.59568V2.98501C10.5 2.19835 9.89333 1.54235 9.10667 1.51768C8.36908 1.49411 7.63092 1.49411 6.89333 1.51768C6.10667 1.54235 5.5 2.19901 5.5 2.98501V3.59568M10.5 3.59568C8.83581 3.46707 7.16419 3.46707 5.5 3.59568" stroke="#A3ABB0" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <?php _e('Remover Imagem', 'mi'); ?></a>

                            </div>
                            <input type="hidden" name="changed-thumbnail" value="false">
                            <div class="content uploadfile">
                                <p><?php _e('Escolher um arquivo', 'mi'); ?></p>
                                <div class="box-ip">
                                    <input type="file" class="ip-file" accept=".jpg,.jpeg,.png" name="user_avatar">
                                </div>
                                <?php echo mi_invalid_feedback(); ?>
                                <span><?php _e('Arquivos aceitos: ".jpg" e ".png". Tamanho máximo permitido: 2MB. Tamanho: 110px x 25px'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <button type="submit" class="tf-btn primary"><?php _e('Salvar', 'mi'); ?></button>
                </div>
                <input type="hidden" name="mi_form_update_user_nonce" value="<?php echo $mi_add_form_update_user_nonce ?>" />
                <input type="hidden" value="mi_update_user_form" name="action">
                <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
                <input type="hidden" value="<?php echo esc_attr($redirect_to); ?>" name="redirect_to">
            </form>
        </div>
    </div>
    <?php echo mi_dashboard_footer(); ?>
</div>

<div class="overlay-dashboard"></div>