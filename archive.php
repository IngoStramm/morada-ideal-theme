<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * 
 * @package morada-ideal
 */
$active_tab = isset($_GET['layout']) && $_GET['layout'] && $_GET['layout'] === 'list' ? 'list' : 'grid';
get_header(); ?>
<section class="flat-section flat-recommended flat-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                // if (!isset($_GET['view']) || $_GET['view'] !== 'map') {
                get_template_part('template-parts/archive/top', 'archive');
                // } 
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-5">
                <?php get_sidebar('sidebar') ?>
            </div>
            <div class="col-xl-8 col-lg-7 flat-animate-tab">
                <div class="tab-content">

                    <?php if (!isset($_GET['view']) || $_GET['view'] !== 'map') { ?>
                        <?php if (have_posts()) { ?>

                            <div class="tab-pane <?php echo $active_tab === 'grid' ? 'active show' : ''; ?>" id="gridLayout" role="tabpanel">
                                <div class="row">
                                    <?php while (have_posts()) {
                                        the_post();
                                        get_template_part('template-parts/archive/archive', 'grid-content');
                                    } ?>
                                </div>
                            </div>
                            <div class="tab-pane <?php echo $active_tab === 'list' ? 'active show' : ''; ?>" id="listLayout" role="tabpanel">
                                <div class="row">
                                    <?php while (have_posts()) {
                                        the_post();
                                        get_template_part('template-parts/archive/archive', 'list-content');
                                    } ?>
                                </div>
                            </div>
                            <?php mi_paging_nav(); ?>

                        <?php } ?>
                    <?php } else {
                        get_template_part('template-parts/archive/archive', 'map-content');
                    } ?>

                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>