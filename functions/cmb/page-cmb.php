<?php
add_action('cmb2_admin_init', 'mi_register_page_metabox');

function mi_register_page_metabox()
{
    $cmb = new_cmb2_box(array(
        'id'            => 'mi_page_metabox',
        'title'         => esc_html__('Opções de página', 'mi'),
        'object_types'  => array('page'), // Post type
        'show_on_cb' => 'mi_show_login_cmb_options',
        'context'    => 'normal',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Imagem lateral da página', 'mi'),
        'id'         => 'mi_side_image',
        'desc'       => esc_html__('A imagem é exibida do lado do formulário da página.', 'mi'),
        'type'       => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png'
        )
    ));
}

add_action('cmb2_admin_init', 'mi_register_page_edit_imovel_metabox');

function mi_register_page_edit_imovel_metabox()
{
    $cmb_group = new_cmb2_box(array(
        'id'            => 'mi_page_edit_imovel_metabox',
        'title'         => esc_html__('Opções de página', 'mi'),
        'object_types'  => array('page'), // Post type
        'show_on_cb' => 'mi_show_edit_imovel_cmb_options',
        'context'    => 'normal',
    ));

    $group_field_id = $cmb_group->add_field(array(
        'id'          => 'cardbox_group',
        'type'        => 'group',
        'description' => esc_html__('Cardbox', 'mi'),
        'options'     => array(
            'group_title'    => esc_html__('Cardbox {#}', 'mi'), // {#} gets replaced by row number
            'add_button'     => esc_html__('Adicionar novo Cardbox', 'mi'),
            'remove_button'  => esc_html__('Remover Cardbox', 'mi'),
            'sortable'       => true,
            // 'closed'      => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'mi' ), // Performs confirmation before removing group.
        ),
    ));

    /**
     * Group fields works the same, except ids only need
     * to be unique to the group. Prefix is not needed.
     *
     * The parent field's id needs to be passed as the first argument.
     */
    $cmb_group->add_group_field($group_field_id, array(
        'name'       => esc_html__('Título', 'mi'),
        'id'         => 'title',
        'type'       => 'text',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ));

    $cmb_group->add_group_field($group_field_id, array(
        'name'        => esc_html__('Texto', 'mi'),
        'id'          => 'description',
        'type'        => 'textarea_small',
    ));

    $cmb_group->add_group_field($group_field_id, array(
        'name' => esc_html__('Ícone', 'mi'),
        'id'   => 'image',
        'type' => 'file',
    ));
}
