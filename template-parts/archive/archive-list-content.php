<?php
$post_id = get_the_ID();
$author_id = get_the_author_meta('ID');
$user_avatar = get_user_meta($author_id, 'mi_user_avatar', true);
$user_phone = get_user_meta($author_id, 'mi_user_phone', true);
$imovel_operacao = wp_get_post_terms($post_id, 'operacao');
$imovel_tipologia = wp_get_post_terms($post_id, 'tipologia');
$imovel_casas_banho = wp_get_post_terms($post_id, 'casas-de-banho');
$imovel_estado = get_post_meta($post_id, 'imovel_estado', true);
$imovel_cidade = get_post_meta($post_id, 'imovel_cidade', true);
$imovel_valor = get_post_meta($post_id, 'imovel_valor', true);
$imovel_area_bruta = get_post_meta($post_id, 'imovel_area_bruta', true);
$imovel_area_util = get_post_meta($post_id, 'imovel_area_util', true);
$valor_por_metro = mi_calcula_valor_por_metro($imovel_valor, $imovel_area_bruta);
$imovel_galeria = get_post_meta($post_id, 'imovel_galeria', true);
$imovel_galeria_id = get_post_meta($post_id, '_imovel_galeria_id', true);
$imovel_caracteristicas_especificas = get_post_meta($post_id, 'imovel_caracteristicas_especificas', true);
$imovel_certificado_energetico = get_post_meta($post_id, 'imovel_certificado_energetico', true);
?>
<div class="col-md-12">
    <div class="homelengo-box list-style-1 list-style-2 line">
        <div class="archive-top">
            <a href="<?php echo get_permalink(); ?>" class="images-group">
                <div class="images-style">
                    <img class="lazyload" data-src="<?php echo get_the_post_thumbnail_url(); ?>" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="img-property">
                </div>
                <?php /* ?>
                <div class="top">
                    <ul class="d-flex gap-6 flex-wrap">
                        <li class="flag-tag primary">Featured</li>
                        <li class="flag-tag style-1">For Sale</li>
                    </ul>
                </div>
                <?php */ ?>
            </a>
        </div>
        <div class="archive-bottom">
            <div class="content-top">
                <h6 class="text-capitalize"><a href="<?php echo get_permalink(); ?>" class="link text-line-clamp-1"><?php the_title(); ?></a></h6>
                <div class="location">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 7C10 7.53043 9.78929 8.03914 9.41421 8.41421C9.03914 8.78929 8.53043 9 8 9C7.46957 9 6.96086 8.78929 6.58579 8.41421C6.21071 8.03914 6 7.53043 6 7C6 6.46957 6.21071 5.96086 6.58579 5.58579C6.96086 5.21071 7.46957 5 8 5C8.53043 5 9.03914 5.21071 9.41421 5.58579C9.78929 5.96086 10 6.46957 10 7Z" stroke="#A3ABB0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M13 7C13 11.7613 8 14.5 8 14.5C8 14.5 3 11.7613 3 7C3 5.67392 3.52678 4.40215 4.46447 3.46447C5.40215 2.52678 6.67392 2 8 2C9.32608 2 10.5979 2.52678 11.5355 3.46447C12.4732 4.40215 13 5.67392 13 7Z" stroke="#A3ABB0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="text-line-clamp-1">
                        <?php
                        if ($imovel_estado) {
                            echo $imovel_estado;
                        }
                        if ($imovel_estado) {
                            echo ', ';
                        }
                        if ($imovel_cidade) {
                            echo $imovel_cidade;
                        }
                        ?>
                    </span>
                </div>

                <?php
                $imovel_tipologia = isset($imovel_tipologia[0]) ? $imovel_tipologia[0]->name : null;
                $imovel_casas_banho = isset($imovel_casas_banho[0]) ? $imovel_casas_banho[0]->name : null;
                echo mi_imovel_meta_list($imovel_tipologia, $imovel_casas_banho, $imovel_area_bruta);
                ?>

                <div class="description mt-20 text-line-clamp-2 text-variant-1"><?php the_excerpt(); ?></div>
            </div>

            <div class="content-bottom">
                <div class="d-flex gap-8 align-items-center">
                    <?php if ($user_avatar) { ?>
                        <img src="<?php echo $user_avatar; ?>" class="user-avatar">
                    <?php } ?>
                    <?php /* ?><span><?php the_author(); ?></span><?php */ ?>
                </div>
                <?php if ($imovel_valor) { ?>
                    <h6 class="price"><?php echo mi_format_money($imovel_valor); ?> €<?php echo $imovel_operacao[0]->name === 'Arrendar' ? '/mês' : ''; ?></h6>
                <?php } ?>
            </div>
        </div>

    </div>
</div>