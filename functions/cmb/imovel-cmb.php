<?php

add_action('cmb2_admin_init', 'mi_register_imovel_metabox');
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function mi_register_imovel_metabox()
{

    /**
     * Registers options page menu item and form.
     */
    $cmb = new_cmb2_box(array(
        'id'           => 'mi_imovel_metabox',
        'title'        => esc_html__('Opções', 'mi'),
        'object_types' => array('imovel'),
    ));

    $cmb->add_field(array(
        'name'                      => esc_html__('Operação', 'mi'),
        'id'                        => 'imovel_operacao',
        'type'                      => 'taxonomy_radio',
        'taxonomy'                  => 'operacao',
        'show_option_none'          => false,
    ));

    $cmb->add_field(array(
        'name'              => esc_html__('Valor', 'mi'),
        // 'desc'              => esc_html__('Valor em Euros (€)', 'mi'),
        'id'                => 'imovel_valor',
        'type'              => 'text',
        'before_field'      => '€',
        'attributes'        => array(
            'type'          => 'number'
        )
    ));

    $cmb->add_field(array(
        'name'         => esc_html__('Galeria de imagens', 'mi'),
        'id'           => 'imovel_galeria',
        'type'         => 'file_list',
        'preview_size' => array(100, 100), // Default: array( 50, 50 )
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Metragem² área bruta', 'mi'),
        'id'         => 'imovel_area_bruta',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Metragem² área útil', 'mi'),
        'id'         => 'imovel_area_util',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Ano de construção', 'mi'),
        'id'         => 'imovel_ano',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'                      => esc_html__('Tipologia (quantidade quartos)', 'mi'),
        'id'                        => 'imovel_tipologias',
        'type'                      => 'taxonomy_radio',
        'taxonomy'                  => 'tipologia',
        'show_option_none'          => false,
    ));

    $cmb->add_field(array(
        'name'                      => esc_html__('Características Gerais', 'mi'),
        'id'                        => 'imovel_caracteristicas_gerais',
        'type'                      => 'taxonomy_multicheck',
        'taxonomy'                  => 'caracteristica-geral',
        'show_option_none'          => false,
    ));

    $cmb->add_field(array(
        'name'                      => esc_html__('Outras Denominações', 'mi'),
        'id'                        => 'imovel_outras_denominacoes_gerais',
        'type'                      => 'taxonomy_multicheck',
        'taxonomy'                  => 'outras-denominacoes',
        'show_option_none'          => false,
    ));

    $cmb->add_field(array(
        'name'                      => esc_html__('Casas de Banho', 'mi'),
        'id'                        => 'imovel_casas_de_banho_gerais',
        'type'                      => 'taxonomy_multicheck',
        'taxonomy'                  => 'casas-de-banho',
        'show_option_none'          => false,
    ));

    $cmb->add_field(array(
        'name'                      => esc_html__('Estado', 'mi'),
        'id'                        => 'imovel_estado_gerais',
        'type'                      => 'taxonomy_multicheck',
        'taxonomy'                  => 'estado',
        'show_option_none'          => false,
    ));

    $cmb->add_field(array(
        'name'                      => esc_html__('Mais filtros', 'mi'),
        'id'                        => 'imovel_mais_filtros_gerais',
        'type'                      => 'taxonomy_multicheck',
        'taxonomy'                  => 'filtro',
        'show_option_none'          => false,
    ));

    $cmb->add_field(array(
        'name'                      => esc_html__('Andar', 'mi'),
        'id'                        => 'imovel_andar_gerais',
        'type'                      => 'taxonomy_radio',
        'taxonomy'                  => 'andar',
        'show_option_none'          => false,
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Características específicas', 'mi'),
        'id'         => 'imovel_caracteristicas_especificas',
        'type'       => 'text',
        'repeatable' => true,
    ));

    $cmb->add_field(array(
        'name'             => esc_html__('Certificado energético', 'mi'),
        'id'               => 'imovel_certificado_energetico',
        'type'             => 'select',
        'options'          => 'mi_certificado_energetico_options',
    ));

    $cmb->add_field(array(
        'name'             => esc_html__('Garagens', 'mi'),
        'id'               => 'imovel_garagens',
        'type'             => 'select',
        'options'          => 'mi_garagens_options',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Rua', 'mi'),
        'id'         => 'imovel_rua',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Número', 'mi'),
        'id'         => 'imovel_numero',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Código Postal', 'mi'),
        'id'         => 'imovel_codigo_postal',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Cidade', 'mi'),
        'id'         => 'imovel_cidade',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Estado', 'mi'),
        'id'         => 'imovel_estado',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Latitude', 'mi'),
        'id'         => 'imovel_lat',
        'type'       => 'text',
    ));

    $cmb->add_field(array(
        'name'       => esc_html__('Longitude', 'mi'),
        'id'         => 'imovel_lng',
        'type'       => 'text',
    ));
}
