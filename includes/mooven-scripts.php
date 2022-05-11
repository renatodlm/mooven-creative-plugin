<?php
//Load Scripts

function mooven_scripts()
{
    if ($_GET['page'] == 'mooven-creative') {
        wp_enqueue_style('mooven_style', plugin_dir_url(__FILE__) . '../css/mooven-creative-style.min.css');
        wp_enqueue_script('mooven_script', plugin_dir_url(__FILE__) . '../js/mooven-creative-main.min.js');

        $mooven_params = array(
            'api_encryption_key' => get_option('mooven_subscription_api_encryption_key')
        );
        wp_localize_script('mooven_script', 'gitsearch_script_params', $mooven_params);
    }
}

add_action('admin_enqueue_scripts', 'mooven_scripts');
//add_action('wp_enqueue_scripts', 'mooven_scripts');