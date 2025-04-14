<?php

add_action('cmb2_admin_init', 'mi_register_user_profile_metabox');
/**
 * Hook in and add a metabox to add fields to the user profile pages
 */
function mi_register_user_profile_metabox()
{

    /**
     * Metabox for the user profile screen
     */
    $cmb_user = new_cmb2_box(array(
        'id'               => 'mi_user_edit',
        'title'            => esc_html__('Informação Extra', 'mi'), // Doesn't output for user boxes
        'object_types'     => array('user'), // Tells CMB2 to use user_meta vs post_meta
        'show_names'       => true,
        'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
    ));

    $cmb_user->add_field(array(
        'name'     => esc_html__('Informação Extra', 'mi'),
        'desc'     => esc_html__('field description (optional)', 'mi'),
        'id'       => 'mi_user_extra_info',
        'type'     => 'title',
        'on_front' => false,
    ));

    $cmb_user->add_field(array(
        'name'    => esc_html__('Avatar', 'mi'),
        'id'      => 'mi_user_avatar',
        'type'    => 'file',
    ));

    $cmb_user->add_field(array(
        'name' => esc_html__('Número de telefone', 'mi'),
        'id'   => 'mi_user_phone',
        'type' => 'text',
    ));
}
