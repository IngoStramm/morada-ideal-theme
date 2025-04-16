<?php

add_action('init', 'mi_cat_faq_tax', 1);

function mi_cat_faq_tax()
{
    $tax = new MI_Taxonomy(
        __('Categoria de FAQ', 'mi'), // Nome (Singular) da nova Taxonomia.
        'faq-cat', // Slug do Taxonomia.
        'faq' // Nome do tipo de conteúdo que a taxonomia irá fazer parte.
    );

    $tax->set_labels(
        array(
            'menu_name'                             => __('Categoria de FAQ', 'mi'),
            'name'                                  => __('Categorias de FAQ', 'mi'),
            'add_new_item'                          => __('Adicionar nova Categoria de FAQ', 'mi'),
            'new_item_name'                         => __('Nova Categoria de FAQ', 'mi'),
            'all_items'                             => __('Todas Categorias de FAQ', 'mi'),
            'separate_items_with_commas'            => __('Categorias de FAQ separadas por vírgula', 'mi'),
            'choose_from_most_used'                 => __('Escolha a partir das Categorias de FAQ mais usadas', 'mi'),
        )
    );

    $tax->set_arguments(
        array(
            'hierarchical' => false,
            // 'default_term' => array(
            //     'name' => __('Geral', 'mi'),
            //     'slug' => 'geral',
            // )
        )
    );
}
