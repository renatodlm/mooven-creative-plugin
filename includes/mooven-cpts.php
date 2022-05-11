<?php

// Register Custom Post Type
function mooven_cpt_receiver()
{

    $args = array(
        'label'                 => __('Recebedores', 'mooven'),
        'supports'              => array('title', 'editor', 'custom-fields', 'page-attributes', 'post-formats'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => false,
        'menu_position'         => 5,
        //'show_in_menu'           => 'admin.php?page=recebedores',
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => false,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'mooven_receivers',
    );


    if (split_is_enable()) {
        register_post_type('mooven_receivers', $args);
    }
}
add_action('init', 'mooven_cpt_receiver', 0);
