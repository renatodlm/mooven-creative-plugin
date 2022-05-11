<?php

class Mooven_Dashboard
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
        add_action('admin_menu', array($this, 'set_custom_fields'));
    }

    //define os paramentros da tela, como slug, nome, url, icone
    public function set_custom_fields()
    {
        add_menu_page(
            'Mooven Creative', // page title 
            'Mooven Creative', // menu title
            'manage_options', // capability
            'mooven-creative',  // menu-slug
            'Mooven_Dashboard::mooven_main_menu',   // function that will render its output
            MOOVEN_PLUGIN_URL . '/img/mooven-creative.svg',   // link to the icon that will be displayed in the sidebar
            '2',    // position of the menu option
        );

        if (split_is_enable()) {
            add_submenu_page(
                'mooven-creative',
                'Recebedores',
                'Recebedores',
                'manage_options',
                'edit.php?post_type=mooven_receivers'
            );
        }
    }


    public static function mooven_main_menu()
    {
?>
        <?php
        if (!empty($_GET['tab'])) {
            $active_tab = $_GET['tab'];
        } else {
            $active_tab = 'geral';
        }
        ?>
        <div class="wrap">
            <h2>Mooven Creative</h2>
            <div class="description">Plugin do time de desenvolvimento Mooven Creative.</div>
            <?php settings_errors(); ?>

            <h2 class="nav-tab-wrapper">
                <a href="?page=mooven-creative&tab=geral" class="nav-tab <?php echo $active_tab == 'geral' ? 'nav-tab-active' : ''; ?>">Geral</a>
                <a href="?page=mooven-creative&tab=split" class="nav-tab <?php echo $active_tab == 'split' ? 'nav-tab-active' : ''; ?>">Split</a>
                <a href="?page=mooven-creative&tab=assinatura" class="nav-tab <?php echo $active_tab == 'assinatura' ? 'nav-tab-active' : ''; ?>">Assinatura</a>
                <a href="?page=mooven-creative&tab=messages" class="nav-tab <?php echo $active_tab == 'messages' ? 'nav-tab-active' : ''; ?>">Mensagens</a>
            </h2>

            <form method="post" action="options.php">
                <?php
                if ($active_tab == 'geral') {

                    settings_fields('mooven-geral-setting-group');
                    do_settings_sections('mooven-geral-section-slug');
                } else if ($active_tab == 'split') {

                    settings_fields('mooven-split-setting-group');
                    do_settings_sections('mooven-split-section-slug');
                } else if ($active_tab == 'assinatura') {

                    settings_fields('mooven-assinatura-setting-group');
                    do_settings_sections('mooven-subscription-section-slug');
                } else if ($active_tab == 'messages') {

                    settings_fields('mooven-messages-setting-group');
                    do_settings_sections('mooven-messages-section-slug');
                }
                ?>

                <?php submit_button(); ?>
            </form>

        </div>
<?php
    }
}
