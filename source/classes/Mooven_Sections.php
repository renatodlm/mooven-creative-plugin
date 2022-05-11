<?php

class Mooven_Sections
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {

        add_action('admin_init', array($this, 'mooven_creative_init_fields_options'));
    }

    public static function mooven_creative_init_fields_options()
    {
        add_settings_section(
            'page_1_section',                                                   // ID de identificação
            'Configurações gerais',                                             // Titulo no Menu do admin
            'Mooven_Sections::page_1_section_callback',            // Callback udosado para renderizar a descrição da sessão
            'mooven-geral-section-slug'                                         // Page on which to add this section of options  

        );

        add_settings_section(
            'page_2_section',
            'Configurações de assinatura',
            'Mooven_Sections::page_2_section_callback',
            'mooven-subscription-section-slug'
        );

        add_settings_section(
            'page_3_section',
            'Configurações do split',
            'Mooven_Sections::page_3_section_callback',
            'mooven-split-section-slug'
        );

        add_settings_section(
            'page_4_section',
            'Mensagens',
            'Mooven_Sections::page_4_section_callback',
            'mooven-messages-section-slug'
        );
    }

    public static function page_1_section_callback()
    {
        echo '<p>Opções gerais do plugin mooven creative.</p>';
    }
    public static function page_2_section_callback()
    {
        echo '<p>Opções de assinaturas integradas ao pagarme.</p>';
    }
    public static function page_3_section_callback()
    {
        echo '<p>Opções de split integradas ao pagarme.</p>';
    }
    public static function page_4_section_callback()
    {
        echo '<p>Alterar mensagens do Plugin.</p>';
    }
}
