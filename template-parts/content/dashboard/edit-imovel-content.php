<?php get_sidebar('dashboard'); ?>

<?php
$post_id = get_the_ID();
$cardboxes = get_post_meta($post_id, 'cardbox_group', true);
$curr_step = isset($_REQUEST['step']) && $_REQUEST['step'] ? $_REQUEST['step'] : 1;
$args = [
    'step' => $curr_step
];
?>
<div class="main-content">
    <?php echo mi_edit_imovel_progress_bar($curr_step); ?>
    <div class="main-content-inner">
        <?php get_template_part('template-parts/content/dashboard/dashboard-inner', 'top'); ?>
        <div class="wrapper-content row">
            <div class="col-lg-7 col-xl-8">
                <div class="widget-box-2">
                    <h3 class="title fw-bold"><?php _e('Registrar Imóvel', 'mi'); ?></h3>
                    <?php get_template_part('template-parts/content/dashboard/imovel', 'form', $args); ?>
                </div>
            </div>
            <div class="col-lg-5 col-xl-4">
                <div class="widget-box-2 widget-box-info mess-box">
                    <div class="content">
                        <?php the_content(); ?>
                        <?php if ($cardboxes) { ?>
                            <?php foreach ($cardboxes as $cardbox) { ?>
                                <div class="card-box">
                                    <div class="card-icon"><img class="img-fluid" src="<?php echo $cardbox['image']; ?>" alt=""></div>
                                    <div class="card-content">
                                        <h6><?php echo $cardbox['title']; ?></h6>
                                        <p><?php echo $cardbox['description']; ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo mi_dashboard_footer(); ?>
</div>

<div class="overlay-dashboard"></div>