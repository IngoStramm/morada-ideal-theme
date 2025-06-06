<?php

add_shortcode('mi_editor', 'mi_editor');

function mi_editor($atts)
{
    $a = shortcode_atts(array(
        'name' => 'mi_editor',
        'tabindex' => -1,
        'post_id' => ''
    ), $atts);
    $editor_id = 'mi_editor';
    $content = $a['post_id'] ? get_the_content(null, null, $a['post_id']) : null;
    $args = array(
        'media_buttons'     => false, // This setting removes the media button.
        'textarea_name'     => $a['name'], // Set custom name.
        'textarea_rows'     => get_option('default_post_edit_rows', 10), //Determine the number of rows.
        'quicktags'         => false, // Remove view as HTML button.
        'tabindex'          => $a['tabindex'],
        'required'          => true,
        'teeny'             => false,
        'tinymce'           => array(
            'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,undo,redo',
            'toolbar2'      => '',
            'toolbar3'      => '',
        ),
    );
    return wp_editor($content, $editor_id, $args);
}

add_shortcode('contact_form', 'mi_contact_form_shortcode');

function mi_contact_form_shortcode($atts)
{
    $a = shortcode_atts(array(
        'name' => 'mi_editor',
        'tabindex' => -1,
        'post_id' => ''
    ), $atts);
    $nome = '';
    $email = '';
    $phone = '';
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        $nome = $user->first_name && $user->last_name ?
            $user->first_name . ' ' . $user->last_name :
            $user->display_name;
        $email = $user->user_email;
        $phone = get_user_meta($user->id, 'mi_user_phone', true);
    }
    $mi_add_contact_form_nonce = wp_create_nonce('mi_contact_form_nonce');
    $form = '';
    $form .=
        '
        <div class="flat-contact">
            <div class="contact-content">
                <form class="mi-contact-form needs-validation form-contact mb-4" role="search" action="' . esc_url(admin_url('admin-post.php')) . '" method="post" id="mi-contact-form" novalidate>

                    <div class="box grid-2">
                        <fieldset>
                            <label for="nome" class="form-label">' . __('Nome', 'mi') . '</label>
                            <input type="text" class="form-control" name="nome" id="nome" value ="' . $nome . '" autocomplete="off" aria-autocomplete="list" aria-label="' . __('Nome', 'mi') . '" tabindex="1" placeholder="-" required>
                            <div class="invalid-feedback">' . __('Campo obrigatório', 'mi') . '</div>
                        </fieldset>

                        <fieldset>
                            <label for="email" class="form-label">' . __('E-mail', 'mi') . '</label>
                            <input type="text" class="form-control" name="email" id="email" value="' . $email . '" autocomplete="off" aria-autocomplete="list" aria-label="' . __('E-mail', 'mi') . '" tabindex="2" placeholder="@" required>
                            <div class="invalid-feedback">' . __('Campo obrigatório', 'mi') . '</div>
                        </fieldset>
                    </div>
                    <div class="box grid-2">

                        <fieldset>
                            <label for="phone" class="form-label">' . __('Telefone', 'mi') . '</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="' . $phone . '" autocomplete="off" aria-autocomplete="list" aria-label="' . __('Telefone', 'mi') . '" tabindex="3" placeholder="+351" required>
                            <div class="invalid-feedback">' . __('Campo obrigatório', 'mi') . '</div>
                        </fieldset>

                        <fieldset>
                            <label for="subject" class="form-label">' . __('Assunto', 'mi') . '</label>

                            <div class="form-style select-list">
                                <div class="group-select">
                                    <div class="nice-select" tabindex="4"><span class="current">' . __('Selecionar', 'mi') . '</span>
                                        <ul class="list">

                                            <li data-value="" data-term-id="" class="option">' . __('Selecionar', 'mi') . '</li>

                                            <li data-value="' . __('Sugestão', 'mi') . '" data-term-id="' . __('Sugestão', 'mi') . '" class="option">' . __('Sugestão', 'mi') . '</li>
                                            
                                            <li data-value="' . __('Problema ou queixa', 'mi') . '" data-term-id="' . __('Problema ou queixa', 'mi') . '" class="option">' . __('Problema ou queixa', 'mi') . '</li>

                                            <li data-value="' . __('Reportar conteúdo ilegal ou inapropriado', 'mi') . '" data-term-id="' . __('Reportar conteúdo ilegal ou inapropriado', 'mi') . '" class="option">' . __('Reportar conteúdo ilegal ou inapropriado', 'mi') . '</li>

                                        </ul>
                                    </div>

                                    <input type="hidden" name="subject" id="subject" data-select-list-value="" value="" required>
                                    <div class="invalid-feedback">' . __('Campo obrigatório', 'mi') . '</div>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                        <fieldset class="mb-20">
                            <label for="mensagem" class="form-label">' . __('Mensagem', 'mi') . '</label>
                            <textarea class="form-control" name="mensagem" id="mensagem" rows="5" aria-autocomplete="list" aria-label="' . __('Mensagem', 'mi') . '" tabindex="5" placeholder="' . __('Escreva aqui a sua mensagem.', 'mi') . '" required></textarea>
                            <div class="invalid-feedback">' . __('Campo obrigatório', 'mi') . '</div>
                        </fieldset>

                        <div class="send-wrap">
                            <button type="submit" class="tf-btn primary size-1 w-auto" tabindex="6">' . __('Enviar', 'mi') . '</button>
                        </div>


                    <input type="hidden" name="mi_contact_form_nonce" value="' . $mi_add_contact_form_nonce . '" />
                    <input type="hidden" value="mi_contact_form" name="action">

                </form>
                <div id="contact-form-alert-placeholder"></div>
            </div>
        </div>';

    return $form;
}

add_shortcode('newsletter_form', 'mi_newsletter_form_shortcode');

function mi_newsletter_form_shortcode($atts)
{
    $a = shortcode_atts(array(
        'name' => 'mi_editor',
        'tabindex' => -1,
        'post_id' => ''
    ), $atts);
    $email = '';
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        $email = $user->user_email;
    }
    $mi_add_newsletter_form_nonce = wp_create_nonce('mi_newsletter_form_nonce');
    $form = '';
    $form .=
        '<form class="mi-newsletter-form needs-validation mt-12" action="' . esc_url(admin_url('admin-post.php')) . '" method="post" id="mi-newsletter-form" novalidate>

                <input type="email" class="newsletter-input" name="email" id="email" value="' . $email . '" placeholder="' . __('Seu endereço de email', 'mi') . '" autocomplete="off" aria-autocomplete="list" aria-label="' . __('E-mail', 'mi') . '" required>

                <button type="submit">
                    <svg class="icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.00044 9.99935L2.72461 2.60352C8.16867 4.18685 13.3024 6.68806 17.9046 9.99935C13.3027 13.3106 8.16921 15.8118 2.72544 17.3952L5.00044 9.99935ZM5.00044 9.99935H11.2504" stroke="#1563DF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <div class="invalid-feedback">' . __('Campo obrigatório', 'mi') . '</div>

            <input type="hidden" name="mi_newsletter_form_nonce" value="' . $mi_add_newsletter_form_nonce . '" />
            <input type="hidden" value="mi_newsletter_form" name="action">

        </form>
        <div id="newsletter-form-alert-placeholder"></div>';

    return $form;
}

add_shortcode('anunciante_contact_form', 'mi_anunciante_contact_form_shortcode');

function mi_anunciante_contact_form_shortcode($atts)
{
    $a = shortcode_atts(array(
        'post_id' => '',
        'author_id' => ''
    ), $atts);
    $nome = '';
    $email = '';
    $phone = '';
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        $nome = $user->first_name && $user->last_name ?
            $user->first_name . ' ' . $user->last_name :
            $user->display_name;
        $email = $user->user_email;
        $phone = get_user_meta($user->ID, 'mi_user_phone', true);
    }
    $mi_add_anunciante_contact_form_nonce = wp_create_nonce('mi_anunciante_contact_form_nonce');
    $form = '';
    $form .=
        '<form class="contact-form mi-anunciante-contact-form needs-validation" role="search" action="' . esc_url(admin_url('admin-post.php')) . '" method="post" id="mi-anunciante-contact-form" novalidate>

                <div class="ip-group">
                    <input type="text" class="form-control" name="nome" id="nome" value ="' . $nome . '" autocomplete="off" aria-autocomplete="list" aria-label="' . __('Nome', 'mi') . '" tabindex="1" placeholder="' . __('Nome', 'mi') . '" required>
                    <div class="invalid-feedback">' . __('Campo obrigatório', 'mi') . '</div>
                </div>

                <div class="ip-group">
                    <input type="tel" class="form-control" name="phone" id="phone" value="' . $phone . '" autocomplete="off" aria-autocomplete="list" aria-label="' . __('Telefone', 'mi') . '" tabindex="2" placeholder="' . __('Telefone', 'mi') . '" required>
                    <div class="invalid-feedback">' . __('Campo obrigatório', 'mi') . '</div>
                </div>

                <div class="ip-group">
                    <input type="text" class="form-control" name="email" id="email" value="' . $email . '" autocomplete="off" aria-autocomplete="list" aria-label="' . __('E-mail', 'mi') . '" tabindex="2" placeholder="' . __('E-mail', 'mi') . '" required>
                    <div class="invalid-feedback">' . __('Campo obrigatório', 'mi') . '</div>
                </div>

                <div class="ip-group">
                    <textarea name="mensagem" id="mensagem" rows="4" aria-autocomplete="list" aria-label="' . __('Mensagem', 'mi') . '" tabindex="3" placeholder="' . __('Mensagem', 'mi') . '" required></textarea>
                    <div class="invalid-feedback">' . __('Campo obrigatório', 'mi') . '</div>
                </div>

                <div class="ip-group">
                    <button type="submit" class="tf-btn btn-view secondary hover-btn-view w-100" tabindex="4">' . __('Enviar mensagem', 'mi') . '<span class="icon icon-arrow-right2"></span></button>
                </div>

            <input type="hidden" name="mi_anunciante_contact_form_nonce" value="' . $mi_add_anunciante_contact_form_nonce . '" />
            <input type="hidden" value="mi_anunciante_contact_form" name="action">
            <input type="hidden" value="' . $a['author_id'] . '" name="author_id">
            <input type="hidden" value="' . $a['post_id'] . '" name="post_id">

        </form>
        <div id="anunciante-contact-form-alert-placeholder"></div>';

    return $form;
}
