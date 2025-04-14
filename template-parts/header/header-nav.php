<?php if (has_nav_menu('primary')) : ?>
    <nav class="main-menu show navbar-expand-md">
        <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
            <?php
            wp_nav_menu(
                array(
                    'theme_location'    => 'primary',
                    'walker'            => new Mi_Walker_Nav_Menu(),
                    'menu_class'        => 'navigation clearfix',
                    'fallback_cb'       => false,
                    'container'         => false
                )
            );
            ?>
        </div>
    </nav>
<?php endif; ?>