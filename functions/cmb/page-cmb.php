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
            'accept' => '.jpg,.jpeg,.png,.svg'
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

add_action('cmb2_admin_init', 'mi_register_home_page_metabox');

function mi_register_home_page_metabox()
{
    $cmb = new_cmb2_box(array(
        'id'            => 'mi_homepage_metabox',
        'title'         => esc_html__('Opções de página', 'mi'),
        'object_types'  => array('page'), // Post type
        'show_on_cb' => 'mi_show_home_cmb_options',
        'context'    => 'normal',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Seção de destaque #1', 'mi'),
        'id'         => 'home_destaque_1_title_cmb',
        'type'       => 'title',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Título', 'mi'),
        'id'         => 'home_destaque_1_title',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Texto', 'mi'),
        'id'         => 'home_destaque_1_content',
        'type'    => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 5,
        ),
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Imagem', 'mi'),
        'id'         => 'home_destaque_1_image',
        'desc'       => esc_html__('A imagem é exibida do lado do formulário da página.', 'mi'),
        'type'       => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png,.svg'
        )
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Ícone do botão', 'mi'),
        'id'         => 'home_destaque_1_icon',
        'type'       => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png,.svg'
        )
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Texto do botão', 'mi'),
        'id'         => 'home_destaque_1_btn',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Link', 'mi'),
        'id'         => 'home_destaque_1_url',
        'type'       => 'text_url',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Seção de destaque #2', 'mi'),
        'id'         => 'home_destaque_3_title_cmb',
        'type'       => 'title',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Título', 'mi'),
        'id'         => 'home_destaque_3_title',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Texto', 'mi'),
        'id'         => 'home_destaque_3_content',
        'type'    => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 5,
        ),
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Imagem', 'mi'),
        'id'         => 'home_destaque_3_image',
        'desc'       => esc_html__('A imagem é exibida do lado do formulário da página.', 'mi'),
        'type'       => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png,.svg'
        )
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Ícone do botão', 'mi'),
        'id'         => 'home_destaque_3_icon',
        'type'       => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png,.svg'
        )
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Texto do botão', 'mi'),
        'id'         => 'home_destaque_3_btn',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Link', 'mi'),
        'id'         => 'home_destaque_3_url',
        'type'       => 'text_url',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Seção Calculadora', 'mi'),
        'id'         => 'home_calculadora_title_cmb',
        'type'       => 'title',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Título', 'mi'),
        'id'         => 'home_calculadora_title',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Imagem da Calculadora', 'mi'),
        'id'         => 'home_calculadora_image',
        'desc'       => esc_html__('A imagem é exibida do lado da calculadora.', 'mi'),
        'type'       => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png,.svg'
        )
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Seção das últimas notícias do blog da Morada Ideal', 'mi'),
        'id'         => 'home_destaque_4_title_cmb',
        'type'       => 'title',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Título da seção das últimas notícias', 'mi'),
        'id'         => 'home_destaque_4_title',
        'type'    => 'text',
        'sanitization_cb' => 'mi_text_without_sanitization',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Texto da seção das últimas notícias', 'mi'),
        'id'         => 'home_destaque_4_content',
        'type'    => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 5,
        ),
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Selo das últimas notícias', 'mi'),
        'id'         => 'home_destaque_4_selo',
        'type'    => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png,.svg'
        )
    ));
}

add_action('cmb2_admin_init', 'mi_register_about_page_metabox');

function mi_register_about_page_metabox()
{
    $cmb = new_cmb2_box(array(
        'id'            => 'mi_about_metabox',
        'title'         => esc_html__('Opções de página', 'mi'),
        'object_types'  => array('page'), // Post type
        'show_on_cb' => 'mi_show_about_cmb_options',
        'context'    => 'normal',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Banner do topo', 'mi'),
        'id'         => 'banner',
        'type'    => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png,.svg'
        )
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Imagem do corpo do texto', 'mi'),
        'id'         => 'image',
        'type'    => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png,.svg'
        )
    ));

    $cmb_group = new_cmb2_box(array(
        'id'           => 'mi_about_faq_metabox',
        'title'        => esc_html__('FAQ', 'mi'),
        'object_types' => array('page'),
        'show_on_cb' => 'mi_show_about_cmb_options',
    ));

    // $group_field_id is the field id string, so in this case: 'yourprefix_group_demo'
    $group_field_id = $cmb_group->add_field(array(
        'id'          => 'faq_group',
        'type'        => 'group',
        'description' => esc_html__('FAQ', 'mi'),
        'options'     => array(
            'group_title'    => esc_html__('FAQ {#}', 'mi'), // {#} gets replaced by row number
            'add_button'     => esc_html__('Adicionar novo FAQ', 'mi'),
            'remove_button'  => esc_html__('Remover FAQ', 'mi'),
            'sortable'       => true,
            // 'closed'      => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'mi' ), // Performs confirmation before removing group.
        ),
    ));

    $cmb_group->add_group_field($group_field_id, array(
        'name'       => esc_html__('Categoria de FAQ', 'mi'),
        'id'         => 'faq_cat',
        'type'     => 'select',
        'options' => 'mi_faq_cat',
        'show_option_none' => true,
    ));
}

add_action('cmb2_admin_init', 'mi_register_contact_page_metabox');

function mi_register_contact_page_metabox()
{
    $cmb = new_cmb2_box(array(
        'id'            => 'mi_contact_metabox',
        'title'         => esc_html__('Opções de página', 'mi'),
        'object_types'  => array('page'), // Post type
        'show_on_cb' => 'mi_show_contact_cmb_options',
        'context'    => 'normal',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Imagem do corpo do texto', 'mi'),
        'id'         => 'image',
        'type'    => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png,.svg'
        )
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Título antes do formulário', 'mi'),
        'id'         => 'subtitle',
        'type'    => 'text',
    ));

    $cmb_group = new_cmb2_box(array(
        'id'           => 'mi_contact_faq_metabox',
        'title'        => esc_html__('FAQ', 'mi'),
        'object_types' => array('page'),
        'show_on_cb' => 'mi_show_contact_cmb_options',
    ));

    // $group_field_id is the field id string, so in this case: 'yourprefix_group_demo'
    $group_field_id = $cmb_group->add_field(array(
        'id'          => 'faq_group',
        'type'        => 'group',
        'description' => esc_html__('FAQ', 'mi'),
        'options'     => array(
            'group_title'    => esc_html__('FAQ {#}', 'mi'), // {#} gets replaced by row number
            'add_button'     => esc_html__('Adicionar novo FAQ', 'mi'),
            'remove_button'  => esc_html__('Remover FAQ', 'mi'),
            'sortable'       => true,
            // 'closed'      => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'mi' ), // Performs confirmation before removing group.
        ),
    ));

    $cmb_group->add_group_field($group_field_id, array(
        'name'       => esc_html__('Categoria de FAQ', 'mi'),
        'id'         => 'faq_cat',
        'type'     => 'select',
        'options' => 'mi_faq_cat',
        'show_option_none' => true,
    ));
}

add_action('cmb2_admin_init', 'mi_register_anuncie_page_metabox');

function mi_register_anuncie_page_metabox()
{
    $cmb = new_cmb2_box(array(
        'id'            => 'mi_anuncie_metabox',
        'title'         => esc_html__('Opções de página', 'mi'),
        'object_types'  => array('page'), // Post type
        'show_on_cb' => 'mi_show_anuncie_cmb_options',
        'context'    => 'normal',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Título', 'mi'),
        'id'         => 'destaque_title',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Texto', 'mi'),
        'id'         => 'destaque_content',
        'type'    => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 5,
        ),
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Imagem', 'mi'),
        'id'         => 'destaque_image',
        'desc'       => esc_html__('A imagem é exibida do lado do formulário da página.', 'mi'),
        'type'       => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png,.svg'
        )
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Ícone do botão', 'mi'),
        'id'         => 'destaque_icon',
        'type'       => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png,.svg'
        )
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Texto do botão', 'mi'),
        'id'         => 'destaque_btn',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Link', 'mi'),
        'id'         => 'destaque_url',
        'type'       => 'text_url',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Texto após o botão', 'mi'),
        'id'         => 'destaque_text_after_btn',
        'type'    => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 5,
        ),
    ));
}

add_action('cmb2_admin_init', 'mi_register_simulador_credito_habitacao_page_metabox');

function mi_register_simulador_credito_habitacao_page_metabox()
{
    $cmb = new_cmb2_box(array(
        'id'            => 'mi_simulador_credito_habitacao_metabox',
        'title'         => esc_html__('Opções de página', 'mi'),
        'object_types'  => array('page'), // Post type
        'show_on_cb' => 'mi_show_simulador_credito_habitacao_cmb_options',
        'context'    => 'normal',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Imagem do Banner do topo', 'mi'),
        'id'         => 'banner_image',
        'type'    => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png,.svg'
        )
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Título do Banner do topo', 'mi'),
        'id'         => 'banner_title',
        'type'    => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Subtítulo do Banner do topo', 'mi'),
        'id'         => 'banner_subtitle',
        'type'    => 'textarea',
        'attributes'        => array(
            'rows'          => 2
        )
    ));

    $cmb_group = new_cmb2_box(array(
        'id'           => 'mi_depoimentos_metabox',
        'title'        => esc_html__('Depoimentos', 'mi'),
        'object_types' => array('page'),
        'show_on_cb' => 'mi_show_simulador_credito_habitacao_cmb_options',
    ));

    // $group_field_id is the field id string, so in this case: 'yourprefix_group_demo'
    $group_field_id = $cmb_group->add_field(array(
        'id'          => 'depoimentos_group',
        'type'        => 'group',
        'description' => esc_html__('Depoimento', 'mi'),
        'options'     => array(
            'group_title'    => esc_html__('Depoimento {#}', 'mi'), // {#} gets replaced by row number
            'add_button'     => esc_html__('Adicionar novo Depoimento', 'mi'),
            'remove_button'  => esc_html__('Remover Depoimento', 'mi'),
            'sortable'       => true,
            // 'closed'      => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'mi' ), // Performs confirmation before removing group.
        ),
    ));

    $cmb_group->add_group_field($group_field_id, array(
        'name'       => esc_html__('Nome', 'mi'),
        'id'         => 'depoimento_nome',
        'type'     => 'text',
    ));

    $cmb_group->add_group_field($group_field_id, array(
        'name'       => esc_html__('Avatar', 'mi'),
        'id'         => 'depoimento_avatar',
        'type'     => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png,.svg'
        )
    ));

    $cmb_group->add_group_field($group_field_id, array(
        'name'       => esc_html__('Texto', 'mi'),
        'id'         => 'depoimento_text',
        'type'     => 'textarea',
        'attributes'        => array(
            'rows'      => 3
        )
    ));

    $cmb_group->add_group_field($group_field_id, array(
        'name'       => esc_html__('Avaliação', 'mi'),
        'id'         => 'depoimento_rating',
        'type'     => 'select',
        'options'   => array(
            1       => 1,
            2       => 2,
            3       => 3,
            4       => 4,
            5       => 5
        )
    ));

    $cmb_group = new_cmb2_box(array(
        'id'           => 'mi_simulador_credito_habitacao_faq_metabox',
        'title'        => esc_html__('FAQ', 'mi'),
        'object_types' => array('page'),
        'show_on_cb' => 'mi_show_simulador_credito_habitacao_cmb_options',
    ));

    // $group_field_id is the field id string, so in this case: 'yourprefix_group_demo'
    $group_field_id = $cmb_group->add_field(array(
        'id'          => 'faq_group',
        'type'        => 'group',
        'description' => esc_html__('FAQ', 'mi'),
        'options'     => array(
            'group_title'    => esc_html__('FAQ {#}', 'mi'), // {#} gets replaced by row number
            'add_button'     => esc_html__('Adicionar novo FAQ', 'mi'),
            'remove_button'  => esc_html__('Remover FAQ', 'mi'),
            'sortable'       => true,
            // 'closed'      => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'mi' ), // Performs confirmation before removing group.
        ),
    ));

    $cmb_group->add_group_field($group_field_id, array(
        'name'       => esc_html__('Categoria de FAQ', 'mi'),
        'id'         => 'faq_cat',
        'type'     => 'select',
        'options' => 'mi_faq_cat',
        'show_option_none' => true,
    ));
}
