<?php

add_action('wp_enqueue_scripts', 'mi_frontend_scripts');

function mi_frontend_scripts()
{

    $min = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', '10.0.0.3'))) ? '' : '.min';
    $version = mi_version();
    $imoveis = mi_get_imoveis();

    $default_prices = [];
    $default_prices[] = MI_MIN_PRICE;
    $default_prices[] = MI_MAX_PRICE;

    $selected_prices = [];
    $selected_prices[] = mi_get_selected_min_price();
    $selected_prices[] = mi_get_selected_max_price();

    $default_areas = [];
    $default_areas[] = MI_MIN_AREA;
    $default_areas[] = MI_MAX_AREA;

    $selected_areas = [];
    $selected_areas[] = mi_get_selected_min_area();
    $selected_areas[] = mi_get_selected_max_area();
    /*
    $precos_array[] = array(0, '0');
    foreach ($precos_options as $k => $option) {
        $precos_array[] = array($k, $option);
    }
    */
    $metragem_options = mi_metragem_options();
    $metragem_array = [];
    $metragem_array[] = array(0, '0');
    foreach ($metragem_options as $k => $option) {
        $metragem_array[] = array($k, $option);
    }
    $cores = array(
        'roxo' => 'rgba(90, 77, 140, 1)',
        'track-color' => '#E7F0FF'
    );

    $lat = isset($_GET['lat']) ? $_GET['lat'] : null;
    $lng = isset($_GET['lng']) ? $_GET['lng'] : null;

    if (is_single()) {
        $post_id = get_the_ID();
        $imovel_lat = get_post_meta($post_id, 'imovel_lat', true);
        if ($imovel_lat) {
            $lat = $imovel_lat;
        }
        $imovel_lng = get_post_meta($post_id, 'imovel_lng', true);
        if ($imovel_lng) {
            $lng = $imovel_lng;
        }
    }

    if (empty($min)) :
        wp_enqueue_script('morada-ideal-livereload', 'http://localhost:35729/livereload.js?snipver=1', array(), null, true);
    endif;

    wp_register_script('imask-script', MI_URL . '/assets/js/imask.min.js', array('jquery'), $version, array('strategy' => 'defer', 'in_footer' => true));

    wp_register_script('bootstrap-script', MI_URL . '/assets/js/bootstrap.min.js', array('jquery'), $version, true);

    wp_register_script('swiper-script', MI_URL . '/assets/js/swiper-bundle.min.js', array('jquery'), $version, true);

    wp_register_script('carousel-script', MI_URL . '/assets/js/carousel.js', array('jquery'), $version, true);

    wp_register_script('plugin-script', MI_URL . '/assets/js/plugin.js', array('jquery'), $version, true);

    wp_register_script('nice-select-script', MI_URL . '/assets/js/jquery.nice-select.min.js', array('jquery'), $version, true);

    wp_register_script('rangle-slider-script', MI_URL . '/assets/js/rangle-slider.js', array('jquery'), $version, true);

    wp_enqueue_script('rangle-slider-script');

    wp_localize_script('rangle-slider-script', 'ajax_object', array(
        'ajax_url'                  => admin_url('admin-ajax.php'),
        'plugin_url'                => MI_URL,
        'imoveis'                   => $imoveis,
        'default_prices'            => $default_prices,
        'selected_prices'           => $selected_prices,
        'default_areas'             => $default_areas,
        'selected_areas'            => $selected_areas,
        'metragem'                  => $metragem_array,
        'lat'                       => $lat,
        'lng'                       => $lng,
        'cores'                     => $cores,
    ));

    wp_register_script('countto-script', MI_URL . '/assets/js/countto.js', array('jquery'), $version, true);

    wp_register_script('shortcodes-script', MI_URL . '/assets/js/shortcodes.js', array('jquery'), $version, true);

    wp_register_script('animation_heading-script', MI_URL . '/assets/js/animation_heading.js', array('jquery'), $version, true);

    wp_register_script('lazysize-script', MI_URL . '/assets/js/lazysize.min.js', array('jquery'), $version, true);

    wp_register_script('main-script', MI_URL . '/assets/js/main.js', array('bootstrap-script', 'jquery', 'swiper-script', 'carousel-script', 'plugin-script', 'nice-select-script', 'rangle-slider-script', 'countto-script', 'animation_heading-script', 'lazysize-script'), $version, true);

    // wp_register_script('list-js', MI_URL . '/assets/js/list' . $min . '.js', array('jquery'), $version, array('strategy' => 'defer', 'in_footer' => true));

    // wp_register_script('slick-script', MI_URL . '/assets/js/slick/slick.min.js', array('jquery'), $version, true);

    wp_register_script('morada-ideal-script', MI_URL . '/assets/js/morada-ideal' . $min . '.js', array('jquery', 'bootstrap-script', 'imask-script', 'swiper-script', 'carousel-script', 'plugin-script', 'nice-select-script', 'rangle-slider-script', 'countto-script', 'shortcodes-script', 'animation_heading-script', 'lazysize-script', 'main-script'), $version, true);

    wp_enqueue_script('morada-ideal-script');

    wp_localize_script('morada-ideal-script', 'ajax_object', array(
        'ajax_url'                  => admin_url('admin-ajax.php'),
        'plugin_url'                => MI_URL,
        'imoveis'                   => $imoveis,
        'default_prices'            => $default_prices,
        'selected_prices'           => $selected_prices,
        'default_areas'             => $default_areas,
        'selected_areas'            => $selected_areas,
        'metragem'                  => $metragem_array,
        'lat'                       => $lat,
        'lng'                       => $lng,
        'cores'                     => $cores,
    ));

    $gmaps_key = mi_get_option('gmaps_key', false, 'mi_google_keys_options');

    if ($gmaps_key) {
        wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $gmaps_key . '&language=pt-PT&libraries=places&callback=initGoogleApi&', array(), null,  array(
            'in_footer' => true,
            'strategy' => 'defer'
        ));
        // wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $gmaps_key, array(), null,  array(
        //     'in_footer' => true,
        //     'strategy' => 'defer'
        // ));
        wp_enqueue_script('morada-maps', MI_URL . '/assets/js/map.js', array('google-maps'), $version,  array(
            'in_footer' => true,
            'strategy' => 'defer'
        ));
        wp_enqueue_script('morada-marker', MI_URL . '/assets/js/marker.js', array('google-maps', 'morada-maps'), $version,  array(
            'in_footer' => true,
            'strategy' => 'defer'
        ));
        wp_enqueue_script('morada-infobox', MI_URL . '/assets/js/infobox.min.js', array('google-maps', 'morada-maps', 'morada-marker'), $version,  array(
            'in_footer' => true,
            'strategy' => 'defer'
        ));
    }

    wp_enqueue_style('fonts-style', MI_URL . '/assets/fonts/fonts.css', array(), $version, 'all');
    wp_enqueue_style('font-icons-style', MI_URL . '/assets/fonts/font-icons.css', array(), $version, 'all');
    wp_enqueue_style('bootstrap-style', MI_URL . '/assets/css/bootstrap.min.css', array(), $version, 'all');
    wp_enqueue_style('swiper-style', MI_URL . '/assets/css/swiper-bundle.min.css', array(), $version, 'all');
    wp_enqueue_style('theme-style', MI_URL . '/assets/css/app.css', array(), $version, 'all');

    // wp_enqueue_style('slick-style', MI_URL . '/assets/js/slick/slick.css', array(), $version, 'all');
    // wp_enqueue_style('slick-theme-style', MI_URL . '/assets/js/slick/slick-theme.css', array(), $version, 'all');

    // wp_enqueue_style('googleapis', 'https://fonts.googleapis.com', array(), null, 'all');
    // wp_enqueue_style('gstatic', 'https://fonts.gstatic.com', array(), null, 'all');
    // wp_enqueue_style('inter-font', 'https://fonts.googleapis.com/css2?family=Assistant:wght@200..800&display=swap', array(), null, 'all');
    // wp_enqueue_style('adventpro-font', 'https://fonts.googleapis.com/css2?family=Advent+Pro:ital,wght@0,100..900;1,100..900&display=swap', array(), null, 'all');

    wp_enqueue_style('morada-ideal-style', MI_URL . '/assets/css/morada-ideal.css', array('fonts-style', 'font-icons-style', 'bootstrap-style', 'swiper-style', 'theme-style'), $version, 'all');
}

add_action('admin_enqueue_scripts', 'mi_admin_scripts');

function mi_admin_scripts()
{
    if (!is_user_logged_in())
        return;

    $version = mi_version();

    $min = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', '10.0.0.3'))) ? '' : '.min';

    wp_register_script('imask-script', MI_URL . '/assets/js/imask.min.js', array('jquery'), $version, array('strategy' => 'defer', 'in_footer' => true));

    wp_register_script('morada-ideal-admin-script', MI_URL . '/assets/js/morada-ideal-admin' . $min . '.js', array('jquery', 'imask-script'), $version, array('strategy' => 'defer', 'in_footer' => true));

    wp_enqueue_script('morada-ideal-admin-script');

    wp_localize_script('morada-ideal-admin-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
