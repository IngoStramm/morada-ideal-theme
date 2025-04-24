<?php
$curr_step = $args['step'];
$post_id = $args['post_id'];
$user_id = $args['user_id'];
$redirect_to = $args['redirect_to'];
$mi_add_form_new_imovel_step_3_nonce = wp_create_nonce('mi_form_imovel_step_3_nonce');
$imovel_thumbnail = get_the_post_thumbnail_url($post_id, 'full');
$imovel_galeria = get_post_meta($post_id, 'imovel_galeria', true);
$default_image = mi_get_option('mi_anuncio_default_image');
$max_img_qty = mi_get_option('mi_anuncio_max_image_qty');
$curr_img_qty = $imovel_galeria ? count($imovel_galeria) : 0;
$imovel_thumbnail = get_the_post_thumbnail_url($post_id, 'full');
$post_status = get_post_status($post_id);
?>
<form name="new-imovel-form" id="new-imovel-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="needs-validation new-imovel-form" enctype="multipart/form-data" novalidate>

    <div class="box-fieldset mi-file-image-preview mb-5">
        <h5 class="title"><?php _e('Imagem principal', 'mi') ?></h5>
        <div class="box-agent-avt">
            <div>
                <div class="img-poster images-preview">
                    <?php if ($imovel_thumbnail) { ?>
                        <img class="image-preview" src="<?php echo $imovel_thumbnail; ?>" loading="lazy">
                    <?php } ?>
                    <a class="remove-file item btn-clear-image mt-1" <?php echo $imovel_thumbnail ? '' : 'style="display: none;"'; ?>>
                        <span class="icon icon-trash"></span>
                    </a>
                </div>
            </div>
            <input type="hidden" name="changed-thumbnail" value="false">
            <div class="content uploadfile">
                <p><?php _e('Escolher um ficheiro', 'mi'); ?></p>
                <div class="box-ip">
                    <input type="file" class="ip-file" accept=".jpg,.jpeg,.png" name="imovel_thumbnail">
                </div>
                <?php echo mi_invalid_feedback(); ?>
                <span><?php _e('Arquivos aceitos: ".jpg" e ".png". Tamanho máximo permitido: 2MB.'); ?></span>
            </div>
        </div>
    </div>

    <h5 class="title"><?php _e('Galeria de imagens do imóvel', 'mi') ?></h5>
    <p class="mb-3"><?php printf(__('Você está a utilizar <strong>%s imagens</strong> do total disponível de <strong>%s imagens</strong>.', 'mi'), $curr_img_qty, $max_img_qty); ?></p>
    <?php if (!$imovel_galeria) { ?>
        <p class="mb-2"><?php _e('Este imóvel ainda não tem qualquer imagem.', 'mi'); ?></p>
    <?php } ?>
    <div class="box-img-upload galeria-imovel-management mb-5 drag-container">
        <?php if ($imovel_galeria) { ?>
            <?php foreach ($imovel_galeria as $attach_id => $image_url) { ?>
                <div class="item-upload galeria-imovel-item draggable-item">
                    <img src="<?php echo $image_url ?>" alt="img">
                    <a href="#" class="remove-galeria-imovel-item"><span class="icon icon-trash"></span></a>
                    <input type="hidden" name="imovel_galeria_ids[]" value="<?php echo $attach_id; ?>">
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="item-upload">
                <img src="<?php echo $default_image ?>">
            </div>
        <?php } ?>
    </div>

    <h5 class="title"><?php _e('Fazer o upload de novas imagens', 'mi') ?></h5>
    <div class="galeria-preview">
        <div class="box-uploadfile text-center">
            <div class="uploadfile" id="uploadfile">
                <div class="btn-upload tf-btn primary">
                    <label for="imovel_galeria">
                        <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.625 14.375V17.1875C13.625 17.705 13.205 18.125 12.6875 18.125H4.5625C4.31386 18.125 4.0754 18.0262 3.89959 17.8504C3.72377 17.6746 3.625 17.4361 3.625 17.1875V6.5625C3.625 6.045 4.045 5.625 4.5625 5.625H6.125C6.54381 5.62472 6.96192 5.65928 7.375 5.72834M13.625 14.375H16.4375C16.955 14.375 17.375 13.955 17.375 13.4375V9.375C17.375 5.65834 14.6725 2.57417 11.125 1.97834C10.7119 1.90928 10.2938 1.87472 9.875 1.875H8.3125C7.795 1.875 7.375 2.295 7.375 2.8125V5.72834M13.625 14.375H8.3125C8.06386 14.375 7.8254 14.2762 7.64959 14.1004C7.47377 13.9246 7.375 13.6861 7.375 13.4375V5.72834M17.375 11.25V9.6875C17.375 8.94158 17.0787 8.22621 16.5512 7.69876C16.0238 7.17132 15.3084 6.875 14.5625 6.875H13.3125C13.0639 6.875 12.8254 6.77623 12.6496 6.60041C12.4738 6.4246 12.375 6.18614 12.375 5.9375V4.6875C12.375 4.31816 12.3023 3.95243 12.1609 3.6112C12.0196 3.26998 11.8124 2.95993 11.5512 2.69876C11.2901 2.4376 10.98 2.23043 10.6388 2.08909C10.2976 1.94775 9.93184 1.875 9.5625 1.875H8.625" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <?php _e('Selecionar imagens', 'mi') ?>
                    </label>
                    <input type="file" class="ip-file" id="imovel_galeria" name="imovel_galeria[]" accept=".jpg,.jpeg,.png" data-img-qty="<?php echo $curr_img_qty; ?>" data-max-img-qty="<?php echo $max_img_qty; ?>" multiple>
                </div>
                <p class="file-name fw-5"><?php _e('Nenhum ficheiro selecionado.', 'mi'); ?></p>
            </div>
        </div>
        <div class="box-img-upload">
        </div>
        <div class="d-flex align-items-center justify-content-center mt-3">
            <a href="#" class="tf-btn danger btn-clear-file-upload"><?php _e('Eliminar imagens selecionadas', 'mi'); ?><span class="icon icon-trash"></span></a>
        </div>
    </div>


    <div class="box-btn mt-5">
        <button type="submit" name="previous-step" class="tf-btn secondary"><?php _e('Voltar para a etapa anterior', 'mi'); ?></button>

        <?php if ($post_status === 'draft') { ?>
            <button id="new-imovel-form-btn" name="draft" type="submit" class="tf-btn outline"><?php _e('Guardar sem publicar', 'mi'); ?></button>
        <?php } ?>

        <button id="new-imovel-form-btn" name="publish" type="submit" class="tf-btn primary"><?php _e('Guardar e publicar', 'mi'); ?></button>

    </div>
    <input type="hidden" name="mi_form_imovel_step_3_nonce" value="<?php echo $mi_add_form_new_imovel_step_3_nonce ?>" />
    <input type="hidden" value="mi_imovel_form_step_3" name="action">
    <input type="hidden" value="<?php echo $curr_step; ?>" name="step">
    <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
    <input type="hidden" value="<?php echo $post_id; ?>" name="imovel_id">
    <input type="hidden" value="<?php echo esc_attr($redirect_to); ?>" name="redirect_to">

</form>