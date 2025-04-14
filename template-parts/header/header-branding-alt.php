<?php
$logo_alt = mi_get_option('mi_logo_alt');
if ($logo_alt) { ?>
    <div class="logo-box flex">
        <div class="logo">
            <a href="<?php echo get_home_url() ?>">
                <img class="site-logo" src="<?php echo $logo_alt; ?>" />
            </a>
        </div>
    </div>
<?php }
