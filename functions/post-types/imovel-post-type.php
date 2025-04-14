<?php

add_action('init', 'mi_imovel_post_type', 1);

function mi_imovel_post_type()
{
    $portfolio = new MI_Post_Type(
        'Imóvel', // Nome (Singular) do Post Type.
        'imovel' // Slug do Post Type.;
    );

    $portfolio->set_labels(
        array(
            'name'               => __('Imóvel', 'mi'),
            'singular_name'      => __('Imóvel', 'mi'),
            'menu_name'          => __('Imóveis', 'mi'),
            'name_admin_bar'     => __('Imóvel', 'mi'),
            'add_new'            => __('Adicionar Imóvel', 'mi'),
            'add_new_item'       => __('Adicionar Novo Imóvel', 'mi'),
            'new_item'           => __('Novo Imóvel', 'mi'),
            'edit_item'          => __('Editar Imóvel', 'mi'),
            'view_item'          => __('Visualizar Imóvel', 'mi'),
            'all_items'          => __('Todos os Imóveis', 'mi'),
            'search_items'       => __('Pesquisar Imóveis', 'mi'),
            'parent_item_colon'  => __('Imóveis Pai', 'mi'),
            'not_found'          => __('Nenhum Imóvel encontrado', 'mi'),
            'not_found_in_trash' => __('Nenhum Imóvel encontrado na lixeira.', 'mi'),
        )
    );

    $portfolio->set_arguments(
        array(
            'supports'             => array('title', 'editor', 'thumbnail', 'revisions'),
            'menu_icon'         => 'dashicons-admin-multisite',
            'show_in_nav_menus' => true
        )
    );
}
