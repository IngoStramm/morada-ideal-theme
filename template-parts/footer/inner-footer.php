                <div class="inner-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="footer-cl-1">
                                    <?php
                                    $company_text = mi_get_option('mi_company_text', false, 'mi_site_info_options');
                                    if ($company_text) { ?>
                                        <p class="text-variant-2"><?php echo $company_text; ?></p>
                                    <?php } ?>
                                    <?php
                                    $company_address = mi_get_option('mi_company_address', false, 'mi_site_info_options');
                                    $company_phone = mi_get_option('mi_company_phone', false, 'mi_site_info_options');
                                    $company_email = mi_get_option('mi_company_email', false, 'mi_site_info_options');
                                    if ($company_address || $company_phone || $company_email) { ?>
                                        <ul class="mt-12">
                                            <?php if ($company_address) { ?>
                                                <li class="mt-12 d-flex align-items-center gap-8">
                                                    <i class="icon icon-mapPinLine fs-20 text-variant-2"></i>
                                                    <p class="text-white"><?php echo $company_address; ?></p>
                                                </li>
                                            <?php } ?>
                                            <?php if ($company_phone) { ?>
                                                <li class="mt-12 d-flex align-items-center gap-8">
                                                    <i class="icon icon-phone2 fs-20 text-variant-2"></i>
                                                    <a href="tel:<?php echo $company_phone; ?>" class="text-white caption-1"><?php echo $company_phone; ?></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($company_email) { ?>
                                                <li class="mt-12 d-flex align-items-center gap-8">
                                                    <i class="icon icon-mail fs-20 text-variant-2"></i>
                                                    <p class="text-white"><?php echo $company_email; ?></p>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <?php if (has_nav_menu('footer_cat')) : ?>
                                    <div class="footer-cl-2 footer-col-block">
                                        <div class="fw-7 text-white footer-heading-mobile"><?php _e('Categorias', 'mi'); ?></div>
                                        <div class="tf-collapse-content">
                                            <?php
                                            wp_nav_menu(
                                                array(
                                                    'theme_location'    => 'footer_cat',
                                                    'walker'            => new Mi_Walker_Nav_Menu(),
                                                    'menu_class'        => 'mt-10 navigation-menu-footer',
                                                    'fallback_cb'       => false,
                                                    'container'         => false
                                                )
                                            );
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <?php if (has_nav_menu('footer_company')) : ?>
                                    <div class="footer-cl-3 footer-col-block">
                                        <div class="fw-7 text-white footer-heading-mobile"><?php _e('Nossa Empresa', 'mi'); ?></div>
                                        <div class="tf-collapse-content">
                                            <?php
                                            wp_nav_menu(
                                                array(
                                                    'theme_location'    => 'footer_company',
                                                    'walker'            => new Mi_Walker_Nav_Menu(),
                                                    'menu_class'        => 'mt-10 navigation-menu-footer',
                                                    'fallback_cb'       => false,
                                                    'container'         => false
                                                )
                                            );
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="footer-cl-4 footer-col-block">
                                    <div class="fw-7 text-white footer-heading-mobile"><?php _e('Boletim Informativo', 'mi'); ?></div>
                                    <div class="tf-collapse-content">
                                        <p class="mt-12 text-variant-2"><?php _e('Sua dose semanal/mensal de conhecimento e inspiração', 'mi'); ?></p>
                                        <?php echo do_shortcode('[newsletter_form]'); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>