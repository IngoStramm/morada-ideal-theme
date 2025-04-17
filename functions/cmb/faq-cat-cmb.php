<?php

add_action('cmb2_admin_init', 'mi_register_faq_cat_metabox');
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function mi_register_faq_cat_metabox()
{

    /**
     * Registers options page menu item and form.
     */
    $cmb = new_cmb2_box(array(
        'id'           => 'mi_faq_cat_metabox',
        'title'        => esc_html__('Opções', 'mi'),
        'object_types'     => array('term'), // Tells CMB2 to use term_meta vs post_meta
        'taxonomies'       => array('category', 'faq-cat'),
    ));

    $cmb->add_field(array(
        'name'                      => esc_html__('Texto após o FAQ', 'mi'),
        'id'                        => 'text_after',
        'type'                      => 'textarea',
        'attributes'                => array(
            'rows'                   => 4
        )
    ));
}
