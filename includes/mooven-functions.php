<?php

function split_is_enable()
{
    /**
     * Verifica se o móduto de slipt está ativo
     */
    $split_module_state_value = stripcslashes(get_option('mooven_creative_split_module_state'));
    $split_module_state_check = checked(1, $split_module_state_value, false);

    if (!empty($split_module_state_check)) {
        return true;
    }
    return false;
}
