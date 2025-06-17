<?php

/**
 * mi_show_login_cmb_options
 *
 * @param  object $cmb
 * @return boolean
 */
function mi_show_login_cmb_options($cmb)
{
    $show = false;
    $login_page_id = mi_get_option('mi_login_page', false, 'mi_site_pages_options');
    $new_user_page_id = mi_get_option('mi_new_user_page', false, 'mi_site_pages_options');
    $lostpassword_page_id = mi_get_option('mi_lostpassword_page', false, 'mi_site_pages_options');
    $resetpassword_page_id = mi_get_option('mi_resetpassword_page', false, 'mi_site_pages_options');
    switch ($cmb->object_id) {
        case $login_page_id:
        case $new_user_page_id:
        case $lostpassword_page_id:
        case $resetpassword_page_id:
            $show = true;
            break;

        default:
            $show = false;
            break;
    }
    return $show;
}

/**
 * mi_show_edit_imovel_cmb_options
 *
 * @param  object $cmb
 * @return boolean
 */
function mi_show_edit_imovel_cmb_options($cmb)
{
    $show = false;
    $edit_imovel_page_id = mi_get_option('mi_edit_imovel_page', false, 'mi_dashboard_pages_options');
    switch ($cmb->object_id) {
        case $edit_imovel_page_id:
            $show = true;
            break;

        default:
            $show = false;
            break;
    }
    return $show;
}

/**
 * mi_show_home_cmb_options
 *
 * @param  object $cmb
 * @return boolean
 */
function mi_show_home_cmb_options($cmb)
{
    $home_page_id = get_option('page_on_front');
    return $cmb->object_id === $home_page_id;
}

function mi_show_about_cmb_options($cmb)
{
    $page_template = get_page_template_slug();
    return $page_template === 'page-about.php';
}

function mi_show_contact_cmb_options($cmb)
{
    $page_template = get_page_template_slug();
    return $page_template === 'page-contact.php';
}

function mi_show_anuncie_cmb_options($cmb)
{
    $page_template = get_page_template_slug();
    return $page_template === 'page-anuncie.php';
}

function mi_show_simulador_credito_habitacao_cmb_options($cmb)
{
    $page_template = get_page_template_slug();
    return $page_template === 'page-simulador-credito.php';
}

/**
 * mi_text_without_sanitization
 *
 * @param  string $value
 * @param  array $field_args
 * @param  object $field
 * @return string
 */
function mi_text_without_sanitization($value, $field_args, $field)
{
    return $value; // Unsanitized value.
}

function mi_faq_cat()
{
    $args = [
        'taxonomy'   => 'faq-cat',
        'hide_empty' => false,
    ];
    $terms = get_terms($args);
    $options = [];
    if ($terms) {
        foreach ($terms as $term) {
            $options[$term->term_id] = $term->name;
        }
    }
    return $options;
}
