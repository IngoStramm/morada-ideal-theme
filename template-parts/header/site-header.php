<?php
$login_page_url = mi_get_page_url('login');
$newsuser_page_url = mi_get_page_url('newuser');
?>
<!-- Main Header -->
<header id="header" class="main-header header-fixed fixed-header">
    <!-- Header Lower -->
    <div class="header-lower">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner-header">
                    <div class="inner-header-left">
                        <?php get_template_part('template-parts/header/header', 'branding'); ?>
                        <div class="nav-outer flex align-center">
                            <!-- Main Menu -->
                            <?php // get_template_part('template-parts/header/header', 'nav'); 
                            ?>
                            <!-- Main Menu End-->
                        </div>
                    </div>
                    <div class="inner-header-right header-account">
                        <?php if (!is_user_logged_in()) { ?>
                            <?php if ($login_page_url) { ?>
                                <a href="<?php echo $login_page_url; ?>" class="tf-btn btn-line btn-login">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.1251 5C13.1251 5.8288 12.7959 6.62366 12.2099 7.20971C11.6238 7.79576 10.8289 8.125 10.0001 8.125C9.17134 8.125 8.37649 7.79576 7.79043 7.20971C7.20438 6.62366 6.87514 5.8288 6.87514 5C6.87514 4.1712 7.20438 3.37634 7.79043 2.79029C8.37649 2.20424 9.17134 1.875 10.0001 1.875C10.8289 1.875 11.6238 2.20424 12.2099 2.79029C12.7959 3.37634 13.1251 4.1712 13.1251 5ZM3.75098 16.765C3.77776 15.1253 4.44792 13.5618 5.61696 12.4117C6.78599 11.2616 8.36022 10.6171 10.0001 10.6171C11.6401 10.6171 13.2143 11.2616 14.3833 12.4117C15.5524 13.5618 16.2225 15.1253 16.2493 16.765C14.2888 17.664 12.1569 18.1279 10.0001 18.125C7.77014 18.125 5.65348 17.6383 3.75098 16.765Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <?php echo get_the_title(mi_get_page_id('login')); ?>
                                </a>
                            <?php } ?>
                        <?php } else { ?>
                            <?php $account_page_url = mi_get_page_url('dashboard'); ?>
                            <a href="<?php echo $account_page_url; ?>" class="tf-btn btn-line btn-login">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.1251 5C13.1251 5.8288 12.7959 6.62366 12.2099 7.20971C11.6238 7.79576 10.8289 8.125 10.0001 8.125C9.17134 8.125 8.37649 7.79576 7.79043 7.20971C7.20438 6.62366 6.87514 5.8288 6.87514 5C6.87514 4.1712 7.20438 3.37634 7.79043 2.79029C8.37649 2.20424 9.17134 1.875 10.0001 1.875C10.8289 1.875 11.6238 2.20424 12.2099 2.79029C12.7959 3.37634 13.1251 4.1712 13.1251 5ZM3.75098 16.765C3.77776 15.1253 4.44792 13.5618 5.61696 12.4117C6.78599 11.2616 8.36022 10.6171 10.0001 10.6171C11.6401 10.6171 13.2143 11.2616 14.3833 12.4117C15.5524 13.5618 16.2225 15.1253 16.2493 16.765C14.2888 17.664 12.1569 18.1279 10.0001 18.125C7.77014 18.125 5.65348 17.6383 3.75098 16.765Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <?php _e('Sua Conta', 'mi'); ?>
                            </a>
                        <?php } ?>
                    </div>

                    <div class="mobile-nav-toggler mobile-button"><span></span></div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Header Lower -->

    <!-- Mobile Menu  -->
    <div class="close-btn"><span class="icon flaticon-cancel-1"></span></div>
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>
        <nav class="menu-box">
            <div class="nav-logo">
                <a href="<?php echo get_home_url() ?>">
                    <?php echo mi_logo(); ?>
                </a>
            </div>
            <div class="bottom-canvas">
                <div class="login-box flex align-center">
                    <?php
                    if (!is_user_logged_in()) { ?>
                        <a href="<?php echo $login_page_url; ?>"><?php echo get_the_title(mi_get_page_id('login')); ?></a>
                        <span>/</span>
                        <a href="<?php echo $newsuser_page_url; ?>"><?php echo get_the_title(mi_get_page_id('newuser')); ?></a>
                    <?php } else { ?>
                        <?php $account_page_url = mi_get_page_url('dashboard'); ?>
                        <a href="<?php echo $account_page_url; ?>"><?php _e('Sua Conta', 'mi'); ?></a>
                    <?php } ?>
                </div>
                <div class="menu-outer"></div>
                <div class="mobi-icon-box">
                    <?php
                    $mi_company_phone = mi_get_option('mi_company_phone', false, 'mi_site_info_options');
                    if ($mi_company_phone) { ?>
                        <div class="box d-flex align-items-center">
                            <span class="icon icon-phone2"></span>
                            <div><?php echo $mi_company_phone; ?></div>
                        </div>
                    <?php } ?>
                    <?php
                    $mi_company_email = mi_get_option('mi_company_email', false, 'mi_site_info_options');
                    if ($mi_company_email) { ?>
                        <div class="box d-flex align-items-center">
                            <span class="icon icon-mail"></span>
                            <div><?php echo $mi_company_email; ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </nav>
    </div>
    <!-- End Mobile Menu -->

</header>