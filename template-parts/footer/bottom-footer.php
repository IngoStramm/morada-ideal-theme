<div class="bottom-footer">
    <div class="container">
        <div class="content-footer-bottom">
            <div class="copyright">©<?php echo date('Y'); ?> <?php _e('Todos os direitos reservados.', 'mi'); ?></div>
            <?php
            $page_service_terms_id = mi_get_option('mi_service_terms', true, 'mi_site_pages_options');
            $page_for_privacy_policy_id = get_option('wp_page_for_privacy_policy');
            $page_cookies_policy_id = mi_get_option('mi_cookies_policy', false, 'mi_site_pages_options');
            ?>
            <?php if ($page_service_terms_id || $page_for_privacy_policy_id || $page_cookies_policy_id) { ?>
                <ul class="menu-bottom">
                    <?php if ($page_service_terms_id) { ?>
                        <li><a href="<?php echo get_page_link($page_service_terms_id); ?>"><?php echo get_the_title($page_service_terms_id); ?></a> </li>
                    <?php } ?>

                    <?php if ($page_for_privacy_policy_id) { ?>
                        <li><a href="<?php echo get_privacy_policy_url(); ?>"><?php echo get_the_title($page_for_privacy_policy_id); ?></a> </li>
                    <?php } ?>

                    <?php if ($page_cookies_policy_id) { ?>
                        <li><a href="<?php echo get_page_link($page_cookies_policy_id); ?>"><?php echo get_the_title($page_cookies_policy_id); ?></a> </li>
                    <?php } ?>

                </ul>
            <?php } ?>
        </div>
    </div>
</div>