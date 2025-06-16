<?php

add_action('wp_head', 'mi_add_head_scripts', 1);

function mi_add_head_scripts()
{
    $head_scripts = mi_get_option('head_scripts', false, 'mi_scripts_options');
    echo "\n$head_scripts\n";
}

add_action('mi_body_start_scripts', 'mi_add_body_start_scripts', 1);

function mi_add_body_start_scripts()
{
    $body_start_scripts = mi_get_option('body_start_scripts', false, 'mi_scripts_options');
    echo "\n$body_start_scripts\n";
}

add_action('wp_footer', 'mi_add_body_end_scripts', 9999);

function mi_add_body_end_scripts()
{
    $body_end_scripts = mi_get_option('body_end_scripts', false, 'mi_scripts_options');
    echo "\n$body_end_scripts\n";
}
