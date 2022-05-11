<?php

function mooven_subscription_api_url($attrs, $cotent)
{
    //EXIGE A CHAVE DE AUTENTICAÇÃO
    if (get_option('mooven_creative_api_subscription_url')) :
        extract(shortcode_atts(array(), $attrs));

        $html = get_option('mooven_creative_api_subscription_url');

        return $html;
    else :
        //CASO NÃO TENHAM CADASTRADO A CHAVE
        return 'Você precisa cadastrar URL API Subscription';
    endif;
}

//adiciona o shortcode
add_shortcode('mooven_subscription_api_url', 'mooven_subscription_api_url');
