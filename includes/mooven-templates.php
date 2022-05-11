<?php


/**
 * Adiciona o template de assinaura na página selecionada no painel
 *
 * @param object   $post_states An array of post display states.
 */
add_filter('page_template', 'mooven_subscription_template');
function mooven_subscription_template($page_template)
{
    $subscription_page = get_option('mooven_creative_subscription_page_id');
    $subscription_module_state = get_option('mooven_creative_subscription_module_state');

    if (!empty($subscription_page) && !empty($subscription_module_state)) {
        if (is_page($subscription_page)) :
            $page_template = require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/templates/subscription.php');
        endif;
    }
    return $page_template;
}

add_filter('display_post_states', 'add_display_post_states', 10, 2);

/**
 * Adiciona Post status a página criada para facil identificação
 *
 * @param array   $post_states An array of post display states.
 * @param WP_Post $post        The current post object.
 */
function add_display_post_states($post_states, $post)
{

    $subscription_page = get_option('mooven_creative_subscription_page_id');
    $subscription_module_state = get_option('mooven_creative_subscription_module_state');
    if (!empty($subscription_page) && !empty($subscription_module_state)) {
        if ($post->ID == $subscription_page) :

            $post_states[]  = __('Mooven Subscription', 'mooven');

        endif;
    }

    return $post_states;
}
