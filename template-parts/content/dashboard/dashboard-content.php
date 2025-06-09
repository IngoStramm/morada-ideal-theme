<?php get_sidebar('dashboard');
?>
<?php
$user = wp_get_current_user();
$user_id = $user->get('id');
$user_imoveis = mi_get_user_imoveis($user_id, array('draft'));
$imoveis_page_id = mi_get_page_id('myimoveis');
$imoveis_page_url = mi_get_page_url('myimoveis');
$favorites_id = mi_get_page_id('favorites');
$user_favorites = get_user_meta($user_id, '_user_favorites', true);
?>

<div class="main-content">
    <div class="main-content-inner">
        <?php get_template_part('template-parts/content/dashboard/dashboard-inner', 'top'); ?>
        <div class="wrapper-content row">
            <div class="col-xl-12">
                <div class="widget-box-2 wd-listing">
                    <h5 class="title"><?php echo sprintf(__('Bem vindo, %s %s!'), $user->first_name, $user->last_name); ?></h5>
                    <p><?php _e('Este é o painel da sua conta. Aqui encontram-se os dados sobre os seus imóveis. Use o menu lateral para navegar entre as áreas do painel.', 'mi'); ?></p>
                </div>
            </div>
        </div>
        <div class="flat-counter-v2 tf-counter">
            <div class="counter-box">
                <div class="box-icon">
                    <span class="icon icon-listing"></span>
                </div>
                <div class="content-box">
                    <div class="title-count text-variant-1"><?php echo $imoveis_page_id ? sprintf('<a href="%s">%s</a>', $imoveis_page_url, __('Seus imóveis', 'mi')) : __('Seus imóveis', 'mi'); ?></div>
                    <div class="box-count d-flex align-items-end">
                        <!-- <h3 class="number fw-8" data-speed="2000" data-to="17" data-inviewport="yes">32</h3>       -->
                        <h3 class="fw-8"><?php echo count($user_imoveis); ?></h3>
                        <?php /* ?><span class="text">/50 <?php _e('restantes', 'mi'); ?></span><?php */ ?>
                    </div>

                </div>
            </div>
            <?php if ($favorites_id) { ?>
                <?php
                $total_favorites = !$user_favorites || !is_array($user_favorites) ? 0 : count($user_favorites);
                ?>
                <div class="counter-box">
                    <div class="box-icon">
                        <span class="icon icon-favorite"></span>
                    </div>
                    <div class="content-box">
                        <div class="title-count text-variant-1"><?php echo sprintf('<a href="%s">%s</a>', mi_get_page_url('favorites'), get_the_title($favorites_id)); ?></div>
                        <div class="d-flex align-items-end">
                            <!-- <h6 class="number" data-speed="2000" data-to="1" data-inviewport="yes">1</h6>  -->
                            <h3 class="fw-8"><?php echo (string)$total_favorites; ?></h3>
                        </div>

                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php echo mi_dashboard_footer(); ?>
</div>

<div class="overlay-dashboard"></div>