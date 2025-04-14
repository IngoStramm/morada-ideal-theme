<?php

add_action('init', 'mi_operacao_imovel_tax', 1);

function mi_operacao_imovel_tax()
{
    $tax = new MI_Taxonomy(
        __('Operação', 'mi'), // Nome (Singular) da nova Taxonomia.
        'operacao', // Slug do Taxonomia.
        'imovel' // Nome do tipo de conteúdo que a taxonomia irá fazer parte.
    );

    $tax->set_labels(
        array(
            'menu_name'                             => __('Operação', 'mi'),
            'name'                                  => __('Regiões', 'mi'),
            'add_new_item'                          => __('Adicionar nova Operação', 'mi'),
            'new_item_name'                         => __('Nova Operação', 'mi'),
            'all_items'                             => __('Todas Operações', 'mi'),
            'separate_items_with_commas'            => __('Operações separadas por vírgula', 'mi'),
            'choose_from_most_used'                 => __('Escolha a partir das Operações mais usadas', 'mi'),
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

add_action('init', 'mi_tipo_imovel_tax', 1);

function mi_tipo_imovel_tax()
{
    $tax = new MI_Taxonomy(
        __('Tipo de imóvel', 'mi'), // Nome (Singular) da nova Taxonomia.
        'tipo', // Slug do Taxonomia.
        'imovel' // Nome do tipo de conteúdo que a taxonomia irá fazer parte.
    );

    $tax->set_labels(
        array(
            'menu_name' => __('Tipo de imóvel', 'mi')
        )
    );

    $tax->set_arguments(
        array(
            'hierarchical' => true,
            'default_term' => array(
                'name' => __('Casas e apartamentos', 'mi'),
                'slug' => 'casas-e-apartamentos',
            )
        )
    );
}

add_action('init', 'mi_regiao_imovel_tax', 1);

function mi_regiao_imovel_tax()
{
    $tax = new MI_Taxonomy(
        __('Região', 'mi'), // Nome (Singular) da nova Taxonomia.
        'regiao', // Slug do Taxonomia.
        'imovel' // Nome do tipo de conteúdo que a taxonomia irá fazer parte.
    );

    $tax->set_labels(
        array(
            'menu_name'                             => __('Região', 'mi'),
            'name'                                  => __('Regiões', 'mi'),
            'add_new_item'                          => __('Adicionar nova Região', 'mi'),
            'new_item_name'                         => __('Nova Região', 'mi'),
            'all_items'                             => __('Todas Regiões', 'mi'),
            'separate_items_with_commas'            => __('Regiões separadas por vírgula', 'mi'),
            'choose_from_most_used'                 => __('Escolha a partir das Regiões mais usadas', 'mi'),
        )
    );

    $tax->set_arguments(
        array(
            'hierarchical' => true,
            // 'default_term' => array(
            //     'name' => __('Arrendar', 'mi'),
            //     'slug' => 'arrendar',
            // )
        )
    );
}

add_action('init', 'mi_caracteristicas_gerais_imovel_tax', 1);

function mi_caracteristicas_gerais_imovel_tax()
{
    $tax = new MI_Taxonomy(
        __('Característica Geral', 'mi'), // Nome (Singular) da nova Taxonomia.
        'caracteristica-geral', // Slug do Taxonomia.
        'imovel' // Nome do tipo de conteúdo que a taxonomia irá fazer parte.
    );

    $tax->set_labels(
        array(
            'menu_name'                             => __('Característica Geral', 'mi'),
            'name'                                  => __('Características Gerais', 'mi'),
            'add_new_item'                          => __('Adicionar nova Característica Geral', 'mi'),
            'new_item_name'                         => __('Nova Característica Geral', 'mi'),
            'all_items'                             => __('Todas Características Gerais', 'mi'),
            'separate_items_with_commas'            => __('Características Gerais separadas por vírgula', 'mi'),
            'choose_from_most_used'                 => __('Escolha a partir das Características Gerais mais usadas', 'mi'),
        )
    );

    $tax->set_arguments(
        array(
            'hierarchical' => false,
        )
    );
}

add_action('init', 'mi_tipologia_imovel_tax', 1);

function mi_tipologia_imovel_tax()
{
    $tax = new MI_Taxonomy(
        __('Tipologia', 'mi'), // Nome (Singular) da nova Taxonomia.
        'tipologia', // Slug do Taxonomia.
        'imovel' // Nome do tipo de conteúdo que a taxonomia irá fazer parte.
    );

    $tax->set_labels(
        array(
            'menu_name'                             => __('Tipologia', 'mi'),
            'name'                                  => __('Tipologias', 'mi'),
            'add_new_item'                          => __('Adicionar nova Tipologia', 'mi'),
            'new_item_name'                         => __('Nova Tipologia', 'mi'),
            'all_items'                             => __('Todas Tipologias', 'mi'),
            'separate_items_with_commas'            => __('Tipologias separadas por vírgula', 'mi'),
            'choose_from_most_used'                 => __('Escolha a partir das Tipologias mais usadas', 'mi'),
        )
    );

    $tax->set_arguments(
        array(
            'hierarchical' => false,
        )
    );
}

add_action('init', 'mi_outras_denominacoes_imovel_tax', 1);

function mi_outras_denominacoes_imovel_tax()
{
    $tax = new MI_Taxonomy(
        __('Outras Denominações', 'mi'), // Nome (Singular) da nova Taxonomia.
        'outras-denominacoes', // Slug do Taxonomia.
        'imovel' // Nome do tipo de conteúdo que a taxonomia irá fazer parte.
    );

    $tax->set_labels(
        array(
            'menu_name'                             => __('Outras Denominações', 'mi'),
            'name'                                  => __('Outras Denominações', 'mi'),
            'add_new_item'                          => __('Adicionar nova Denominação', 'mi'),
            'new_item_name'                         => __('Nova Denominação', 'mi'),
            'all_items'                             => __('Todas Denominações', 'mi'),
            'separate_items_with_commas'            => __('Denominações separadas por vírgula', 'mi'),
            'choose_from_most_used'                 => __('Escolha a partir das Denominações mais usadas', 'mi'),
        )
    );

    $tax->set_arguments(
        array(
            'hierarchical' => false,
        )
    );
}

add_action('init', 'mi_casas_de_banho_imovel_tax', 1);

function mi_casas_de_banho_imovel_tax()
{
    $tax = new MI_Taxonomy(
        __('Casas de Banho', 'mi'), // Nome (Singular) da nova Taxonomia.
        'casas-de-banho', // Slug do Taxonomia.
        'imovel' // Nome do tipo de conteúdo que a taxonomia irá fazer parte.
    );

    $tax->set_labels(
        array(
            'menu_name'                             => __('Casas de Banho', 'mi'),
            'name'                                  => __('Casas de Banho', 'mi'),
            'add_new_item'                          => __('Adicionar nova Casa de Banho', 'mi'),
            'new_item_name'                         => __('Nova Casa de Banho', 'mi'),
            'all_items'                             => __('Todas Casas de Banho', 'mi'),
            'separate_items_with_commas'            => __('Casas de Banho separadas por vírgula', 'mi'),
            'choose_from_most_used'                 => __('Escolha a partir das Casas de Banho mais usadas', 'mi'),
        )
    );

    $tax->set_arguments(
        array(
            'hierarchical' => false,
        )
    );
}

add_action('init', 'mi_estado_imovel_tax', 1);

function mi_estado_imovel_tax()
{
    $tax = new MI_Taxonomy(
        __('Estado', 'mi'), // Nome (Singular) da nova Taxonomia.
        'estado', // Slug do Taxonomia.
        'imovel' // Nome do tipo de conteúdo que a taxonomia irá fazer parte.
    );

    $tax->set_labels(
        array(
            'menu_name' => __('Estado', 'mi')
        )
    );

    $tax->set_arguments(
        array(
            'hierarchical' => false,
        )
    );
}

add_action('init', 'mi_mais_filtro_imovel_tax', 1);

function mi_mais_filtro_imovel_tax()
{
    $tax = new MI_Taxonomy(
        __('Filtro', 'mi'), // Nome (Singular) da nova Taxonomia.
        'filtro', // Slug do Taxonomia.
        'imovel' // Nome do tipo de conteúdo que a taxonomia irá fazer parte.
    );

    $tax->set_labels(
        array(
            'menu_name' => __('Mais Filtros', 'mi')
        )
    );

    $tax->set_arguments(
        array(
            'hierarchical' => false,
        )
    );
}

add_action('init', 'mi_andar_imovel_tax', 1);

function mi_andar_imovel_tax()
{
    $tax = new MI_Taxonomy(
        __('Andar', 'mi'), // Nome (Singular) da nova Taxonomia.
        'andar', // Slug do Taxonomia.
        'imovel' // Nome do tipo de conteúdo que a taxonomia irá fazer parte.
    );

    $tax->set_labels(
        array(
            'menu_name' => __('Andar', 'mi')
        )
    );

    $tax->set_arguments(
        array(
            'hierarchical' => false,
        )
    );
}
