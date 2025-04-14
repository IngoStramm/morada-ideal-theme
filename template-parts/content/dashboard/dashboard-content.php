<?php get_sidebar('dashboard');
?>
<?php
$user = wp_get_current_user();
$user_id = $user->get('id');
$user_imoveis = mi_get_user_imoveis($user_id, array('draft'));
$imoveis_page_id = mi_get_page_id('myimoveis');
$imoveis_page_url = mi_get_page_url('myimoveis');
?>

<div class="main-content">
    <div class="main-content-inner">
        <?php get_template_part('template-parts/content/dashboard/dashboard-inner', 'top'); ?>
        <div class="wrapper-content row">
            <div class="col-xl-12">
                <div class="widget-box-2 wd-listing">
                    <h5 class="title"><?php echo sprintf(__('Bem vindo, %s!'), $user->display_name); ?></h5>
                    <p><?php _e('Este é o painel da sua conta. Aqui se encontram os dados sobre os seus imóveis. Use o menu lateral para navegar entre as áreas do painel.', 'mi'); ?></p>
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
            <div class="counter-box">
                <div class="box-icon">
                    <span class="icon icon-favorite"></span>
                </div>
                <div class="content-box">
                    <div class="title-count text-variant-1"><?php _e('Favoritos', 'mi'); ?></div>
                    <div class="d-flex align-items-end">
                        <!-- <h6 class="number" data-speed="2000" data-to="1" data-inviewport="yes">1</h6>  -->
                        <h3 class="fw-8 fs-5"><?php _e('Em breve', 'mi'); ?></h3>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php echo mi_dashboard_footer(); ?>
</div>

<div class="overlay-dashboard"></div>