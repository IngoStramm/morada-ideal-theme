<div class="top-footer">
    <div class="container">
        <div class="content-footer-top">
            <?php
            $footer_logo = mi_get_option('mi_footer_logo', false, 'mi_site_info_options');
            if ($footer_logo) { ?>
                <div class="navbar-brand d-block footer-logo"><a href="<?php echo get_home_url(); ?>"><img class="site-logo img-fluid" alt="logo" src="<?php echo $footer_logo; ?>"></a></div>
            <?php } ?>

            <?php get_template_part('template-parts/footer/footer', 'social-media'); ?>
        </div>
    </div>
</div>