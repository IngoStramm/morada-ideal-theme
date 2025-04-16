<?php

add_action('cmb2_admin_init', 'mi_register_faq_metabox');
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function mi_register_faq_metabox()
{

    /**
     * Registers options page menu item and form.
     */
    $cmb = new_cmb2_box(array(
        'id'           => 'mi_faq_metabox',
        'title'        => esc_html__('Opções', 'mi'),
        'object_types' => array('faq'),
    ));

    $cmb->add_field(array(
        'name'                      => esc_html__('Categoria de FAQ', 'mi'),
        'id'                        => 'faq_cat',
        'type'                      => 'taxonomy_radio',
        'taxonomy'                  => 'faq-cat',
        'show_option_none'          => false,
    ));
}
