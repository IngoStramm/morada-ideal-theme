<?php get_sidebar('dashboard'); ?>

<?php
$user = wp_get_current_user();
$user_id = $user->get('ID');
$search = isset($_GET['search']) && $_GET['search'] ? $_GET['search'] : null;
$editar_imovel_url = mi_get_page_url('editimovel');
$orderby = isset($_GET['orderby']) ? $_GET['orderby'] : null;
$order_list = [
    ''                      => __('Ordenar (padrão)', 'mi'),
    'date_desc'             => __('Mais recentes primeiro', 'mi'),
    'date_asc'              => __('Mais antigos primeiro', 'mi'),
    'title_asc'             => __('Ordem alfabética (A-Z)', 'mi'),
    'title_desc'            => __('Ordem alfabética reversa (Z-A)', 'mi'),
];
?>
<div class="main-content">
    <div class="main-content-inner wrap-dashboard-content">
        <?php get_template_part('template-parts/content/dashboard/dashboard-inner', 'top'); ?>
        <div class="row">
            <div class="col-md-3">
                <fieldset class="box-fieldset">
                    <label>
                        <?php _e('Data', 'mi'); ?>:<span>*</span>
                    </label>
                    <div class="nice-select my-imoveis-select" tabindex="0"><span class="current"><?php echo $order_list[$orderby]; ?></span>
                        <ul class="list">
                            <?php foreach ($order_list as $k => $v) {
                                $selected = $k === $orderby ? 'selected' : '';
                                echo '<li data-value="' . $k . '" class="option ' . $selected . '">' . $v . '</li>';
                            } ?>
                        </ul>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-9">
                <form role="filter" method="get" name="filter-imoveis">
                    <fieldset class="box-fieldset">
                        <label>
                            <?php _e('Pesquisar', 'mi'); ?>:<span>*</span>
                        </label>
                        <input type="search" class="form-control" name="search" value="<?php echo $search; ?>" placeholder="<?php _e('Pesquisar', 'mi'); ?>">
                    </fieldset>
                </form>
            </div>
        </div>
        <div class="widget-box-2 wd-listing">
            <h5 class="title"><?php _e('Meus imóveis', 'mi'); ?></h5>
            <div class="wrap-table">
                <?php $imoveis_query = mi_get_user_imoveis($user_id);
                $args = array(
                    'post_type'             => 'imovel',
                    'posts_per_page'        => 10,
                    'post_status'           => array('publish', 'draft'),
                    'author'                => $user_id,
                );
                $orderby = $orderby ? $orderby : 'date_desc';
                $order_array = array(
                    'date_asc' => array(
                        'orderby'   => 'date',
                        'order'     => 'ASC'
                    ),
                    'date_desc' => array(
                        'orderby'   => 'date',
                        'order'     => 'DESC'
                    ),
                    'title_asc' => array(
                        'orderby'   => 'title',
                        'order'     => 'ASC'
                    ),
                    'title_desc' => array(
                        'orderby'   => 'title',
                        'order'     => 'DESC'
                    ),
                );

                $args['order'] = $order_array[$orderby]['order'];
                $args['orderby'] = $order_array[$orderby]['orderby'];

                if ($search) {
                    $args['s'] = $search;
                }

                $imoveis_query = new WP_Query($args);
                if ($imoveis_query->have_posts()) { ?>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th><?php _e('Imóvel', 'mi'); ?></th>
                                    <th><?php _e('Status', 'mi'); ?></th>
                                    <th><?php _e('Data', 'mi'); ?></th>
                                    <th><?php _e('Ação', 'mi'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($imoveis_query->have_posts()) {
                                    $imoveis_query->the_post();
                                    $imovel = $post;
                                    $imovel_id = get_the_ID();
                                    $imovel_title = $imovel->post_title;
                                    $imovel_date = get_the_date();
                                    $imovel_modified = $imovel->post_modified;
                                    $imovel_url = get_post_permalink($imovel_id);
                                    $imovel_thumbnail = has_post_thumbnail($imovel_id) ? get_the_post_thumbnail_url($imovel_id, 'full') : mi_get_option('mi_anuncio_default_image');
                                    $placeholder_image = mi_get_option('mi_anuncio_default_image');
                                    $imovel_valor = get_post_meta($imovel_id, 'imovel_valor', true);
                                    $imovel_thumbnail = get_the_post_thumbnail_url($imovel_id, 'full');
                                    $imovel_operacao = wp_get_post_terms($imovel_id, 'operacao');
                                    $imovel_status = $imovel->post_status;
                                ?>
                                    <tr class="file-delete">
                                        <td>
                                            <div class="listing-box">
                                                <div class="images">
                                                    <img src="<?php echo $imovel_thumbnail ? $imovel_thumbnail : $placeholder_image; ?>" alt="images">
                                                </div>
                                                <div class="content">
                                                    <div class="title"><a href="<?php echo $imovel_url; ?>" class="link"><?php echo $imovel_title; ?></a> </div>
                                                    <div class="text-date"><?php sprintf(__('Postado em: %s', 'mi'), $imovel_date); ?></div>
                                                    <div class="text-btn text-primary">
                                                        <?php echo $imovel_valor && (int)$imovel_valor !== 0 ? mi_format_money($imovel_valor) : $imovel_valor; ?> €
                                                        </h3>
                                                        <?php echo $imovel_operacao[0]->name === 'Arrendar' ? '<span class="small text-variant-1">/' . __('mês', 'mi') . '</span>' : ''; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="status-wrap">
                                                <a href="#" class="btn-status <?php echo $imovel_status === 'publish' ? '' : 'pending'; ?>"><?php echo $imovel_status === 'publish' ? __('Publicado', 'mi') : __('Rascunho', 'mi'); ?></a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="status-wrap">
                                                <?php echo $imovel_date; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="list-action">
                                                <li><a href="<?php echo $editar_imovel_url; ?>?imovel_id=<?php echo $imovel_id; ?>" class="item">
                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.2413 2.9915L12.366 1.86616C12.6005 1.63171 12.9184 1.5 13.25 1.5C13.5816 1.5 13.8995 1.63171 14.134 1.86616C14.3685 2.10062 14.5002 2.4186 14.5002 2.75016C14.5002 3.08173 14.3685 3.39971 14.134 3.63416L4.55467 13.2135C4.20222 13.5657 3.76758 13.8246 3.29 13.9668L1.5 14.5002L2.03333 12.7102C2.17552 12.2326 2.43442 11.7979 2.78667 11.4455L11.242 2.9915H11.2413ZM11.2413 2.9915L13 4.75016" stroke="#A3ABB0" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <?php _e('Editar', 'mi'); ?></a>
                                                </li>
                                                <?php /* ?>
                                                <li><a class="item">
                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12.2427 12.2427C13.3679 11.1175 14.0001 9.59135 14.0001 8.00004C14.0001 6.40873 13.3679 4.8826 12.2427 3.75737C11.1175 2.63214 9.59135 2 8.00004 2C6.40873 2 4.8826 2.63214 3.75737 3.75737M12.2427 12.2427C11.1175 13.3679 9.59135 14.0001 8.00004 14.0001C6.40873 14.0001 4.8826 13.3679 3.75737 12.2427C2.63214 11.1175 2 9.59135 2 8.00004C2 6.40873 2.63214 4.8826 3.75737 3.75737M12.2427 12.2427L3.75737 3.75737" stroke="#A3ABB0" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>

                                                        Sold</a>
                                                </li>
                                                <li><a class="remove-file item">
                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M9.82667 6.00035L9.596 12.0003M6.404 12.0003L6.17333 6.00035M12.8187 3.86035C13.0467 3.89501 13.2733 3.93168 13.5 3.97101M12.8187 3.86035L12.1067 13.1157C12.0776 13.4925 11.9074 13.8445 11.63 14.1012C11.3527 14.3579 10.9886 14.5005 10.6107 14.5003H5.38933C5.0114 14.5005 4.64735 14.3579 4.36999 14.1012C4.09262 13.8445 3.92239 13.4925 3.89333 13.1157L3.18133 3.86035M12.8187 3.86035C12.0492 3.74403 11.2758 3.65574 10.5 3.59568M3.18133 3.86035C2.95333 3.89435 2.72667 3.93101 2.5 3.97035M3.18133 3.86035C3.95076 3.74403 4.72416 3.65575 5.5 3.59568M10.5 3.59568V2.98501C10.5 2.19835 9.89333 1.54235 9.10667 1.51768C8.36908 1.49411 7.63092 1.49411 6.89333 1.51768C6.10667 1.54235 5.5 2.19901 5.5 2.98501V3.59568M10.5 3.59568C8.83581 3.46707 7.16419 3.46707 5.5 3.59568" stroke="#A3ABB0" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        Delete</a>
                                                </li>
                                                <?php */ ?>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo mi_pagination(2, 1, false, $imoveis_query); ?>
                    <?php wp_reset_postdata(); ?>
                <?php } else { ?>
                    <?php echo mi_alert(__('Nenhum imóvel encontrado.', 'mi'), 'warning'); ?>
                <?php } ?>

            </div>
        </div>
    </div>
    <?php echo mi_dashboard_footer(); ?>
</div>

<div class="overlay-dashboard"></div>