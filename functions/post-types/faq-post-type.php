<?php

add_action('init', 'mi_faq_post_type', 1);

function mi_faq_post_type()
{
    $faq = new MI_Post_Type(
        'FAQ', // Nome (Singular) do Post Type.
        'faq' // Slug do Post Type.;
    );

    $faq->set_labels(
        array(
            'name'               => __('FAQ', 'mi'),
            'singular_name'      => __('FAQ', 'mi'),
            'menu_name'          => __('FAQs', 'mi'),
            'name_admin_bar'     => __('FAQ', 'mi'),
            'add_new'            => __('Adicionar FAQ', 'mi'),
            'add_new_item'       => __('Adicionar Novo FAQ', 'mi'),
            'new_item'           => __('Novo FAQ', 'mi'),
            'edit_item'          => __('Editar FAQ', 'mi'),
            'view_item'          => __('Visualizar FAQ', 'mi'),
            'all_items'          => __('Todos os FAQs', 'mi'),
            'search_items'       => __('Pesquisar FAQs', 'mi'),
            'parent_item_colon'  => __('FAQs Pai', 'mi'),
            'not_found'          => __('Nenhum FAQ encontrado', 'mi'),
            'not_found_in_trash' => __('Nenhum FAQ encontrado na lixeira.', 'mi'),
        )
    );

    $faq->set_arguments(
        array(
            'supports'             => array('title', 'editor', 'page-attributes'),
            'menu_icon'         => 'dashicons-list-view',
            'show_in_nav_menus' => true
        )
    );
}
