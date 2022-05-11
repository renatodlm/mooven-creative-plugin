<?php

class Mooven_Fields
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

    /*
    /* Adicionando fields de opções
    */

    public static function mooven_creative_init_fields_options()
    {

        /* 
        /* Option 1
        */

        add_settings_field(
            'option_1',                                              // ID de identificação 
            'Option 1',                                              // Label a esquerda do elemento
            'Mooven_Fields::option_1_callback',  // O nome da função responsável por renderizar a interface de opções 
            'mooven-geral-section-slug',                             // A Pagina na qual esta opção será exibida
            'page_1_section',                                        // O nome da seção à qual este field pertence
            array(                                                   // Paramentros $args na função callback
                'This is the description of the option 1',
            )
        );
        register_setting(
            'mooven-geral-setting-group',
            'option_1'
        );

        /*
        /* Ativar Assinatura
        */

        add_settings_field(
            'mooven_creative_subscription_module_state',
            'Ativar módulo',
            'Mooven_Fields::subscription_state_callback',
            'mooven-subscription-section-slug',
            'page_2_section',
            array(
                'Essa opção define se o múdulo está habilitada.',
            )
        );
        register_setting(
            'mooven-assinatura-setting-group',
            'mooven_creative_subscription_module_state'
        );

        /**
         * API URL
         */
        add_settings_field(
            'mooven_creative_subscription_api_url',
            'API URL Assinatura',
            'Mooven_Fields::mooven_creative_subscription_api_url_callback',
            'mooven-subscription-section-slug',
            'page_2_section',
            array(
                'Url da API de assinatura. Para mais informações consultar a documentação da pagarme.',
            )
        );
        register_setting(
            'mooven-assinatura-setting-group',
            'mooven_creative_subscription_api_url'
        );

        /**
         * API Key
         */
        add_settings_field(
            'mooven_creative_subscription_api_key',
            'API Key Assinatura',
            'Mooven_Fields::mooven_creative_subscription_api_key_callback',
            'mooven-subscription-section-slug',
            'page_2_section',
            array(
                'Chave utilizada para integração API. Para mais informações consultar a documentação da pagarme.',
            )
        );
        register_setting(
            'mooven-assinatura-setting-group',
            'mooven_creative_subscription_api_key'
        );

        /**
         * API Encryption key
         */
        add_settings_field(
            'mooven_creative_subscription_api_encryption_key',
            'API Encryption key',
            'Mooven_Fields::mooven_creative_subscription_api_encryption_key_callback',
            'mooven-subscription-section-slug',
            'page_2_section',
            array(
                'Código usado para recursos da pagarme. Para mais informações consultar a documentação da pagarme.',
            )
        );
        register_setting(
            'mooven-assinatura-setting-group',
            'mooven_creative_subscription_api_encryption_key'
        );

        /**
         * Plan ID
         */
        add_settings_field(
            'mooven_creative_subscription_plan_id',
            'ID do Plano',
            'Mooven_Fields::mooven_creative_subscription_plan_id_callback',
            'mooven-subscription-section-slug',
            'page_2_section',
            array(
                'Esse ID será o plano em que os assinantes serão ingressados, para obter o ID do seu plano acesse o painel da pagarme.',
            )
        );
        register_setting(
            'mooven-assinatura-setting-group',
            'mooven_creative_subscription_plan_id'
        );

        /**
         * Postback URL
         */
        add_settings_field(
            'mooven_creative_subscription_postback_url',
            'Postback URL',
            'Mooven_Fields::mooven_creative_subscription_postback_url_callback',
            'mooven-subscription-section-slug',
            'page_2_section',
            array(
                'Consulte a documentação da pagarme para mais informações.',
            )
        );
        register_setting(
            'mooven-assinatura-setting-group',
            'mooven_creative_subscription_postback_url'
        );

        /**
         * ID Recebedor Primário
         */
        add_settings_field(
            'mooven_creative_subscription_first_receiver_id',
            'ID Recebedor Mooven',
            'Mooven_Fields::mooven_creative_subscription_first_receiver_id_callback',
            'mooven-subscription-section-slug',
            'page_2_section',
            array(
                'ID do recebedor para o funcionamento do split de assinatura. Essa informação consta no painel da pagarme.',
            )
        );
        register_setting(
            'mooven-assinatura-setting-group',
            'mooven_creative_subscription_first_receiver_id'
        );


        /**
         * Percentual do Recebedor Primário
         */
        add_settings_field(
            'mooven_creative_subscription_first_receiver_percent',
            'Percentual do Recebedor Mooven',
            'Mooven_Fields::mooven_creative_subscription_first_receiver_percent_callback',
            'mooven-subscription-section-slug',
            'page_2_section',
            array(
                'Percentual recebido no split de assinatura. Insira um value de 0 a 100 considerando o segundo recebedor na soma total que deverá ser 100.',
            )
        );
        register_setting(
            'mooven-assinatura-setting-group',
            'mooven_creative_subscription_first_receiver_percent'
        );


        /**
         * ID Recebedor Secundário
         */
        add_settings_field(
            'mooven_creative_subscription_second_receiver_id',
            'ID Recebedor Secundário',
            'Mooven_Fields::mooven_creative_subscription_second_receiver_id_callback',
            'mooven-subscription-section-slug',
            'page_2_section',
            array(
                'ID do recebedor para o funcionamento do split de assinatura. Essa informação consta no painel da pagarme.',
            )
        );
        register_setting(
            'mooven-assinatura-setting-group',
            'mooven_creative_subscription_second_receiver_id'
        );
        /**
         * Percentual do Recebedor Secundário
         */
        add_settings_field(
            'mooven_creative_subscription_second_receiver_percent',
            'Percentual do Recebedor Secundário',
            'Mooven_Fields::mooven_creative_subscription_second_receiver_percent_callback',
            'mooven-subscription-section-slug',
            'page_2_section',
            array(
                'Percentual recebido no split de assinatura. Insira um value de 0 a 100 considerando o primeiro recebedor na soma total que deverá ser 100.',
            )
        );
        register_setting(
            'mooven-assinatura-setting-group',
            'mooven_creative_subscription_second_receiver_percent'
        );

        /**
         * Pagina selecionada para template subscription
         */
        add_settings_field(
            'mooven_creative_subscription_page_id',
            'Página de assinatura',
            'Mooven_Fields::mooven_creative_subscription_page_id_callback',
            'mooven-subscription-section-slug',
            'page_2_section',
            array(
                'Escolha a página que será utilizada para assinatura.',
            )
        );
        register_setting(
            'mooven-assinatura-setting-group',
            'mooven_creative_subscription_page_id'
        );


        /**
         * Fileds Split de pagamento
         * 
         */

        /*
        /* Ativar Split de pagamento
        */

        add_settings_field(
            'mooven_creative_split_module_state',
            'Ativar módulo',
            'Mooven_Fields::split_state_callback',
            'mooven-split-section-slug',
            'page_3_section',
            array(
                'Essa opção define se o múdulo está habilitado.',
            )
        );
        register_setting(
            'mooven-split-setting-group',
            'mooven_creative_split_module_state'
        );

        /**
         * ID Recebedor Primário - Split de pagamento
         */
        add_settings_field(
            'mooven_creative_split_first_receiver_id',
            'ID Recebedor Primário',
            'Mooven_Fields::mooven_creative_split_first_receiver_id_callback',
            'mooven-split-section-slug',
            'page_3_section',
            array(
                'ID do recebedor para o funcionamento do split de pagamento. Essa informação consta no painel da pagarme.',
            )
        );
        register_setting(
            'mooven-split-setting-group',
            'mooven_creative_split_first_receiver_id'
        );


        /**
         * Percentual do Recebedor Primário - Split de pagamento
         */
        add_settings_field(
            'mooven_creative_split_first_receiver_percent',
            'Percentual do Recebedor Primário',
            'Mooven_Fields::mooven_creative_split_first_receiver_percent_callback',
            'mooven-split-section-slug',
            'page_3_section',
            array(
                'Recebedor primário (ficará com o resto).Percentual recebido no split de pagamento. Insira um value de 0 a 100 considerando o segundo recebedor na soma total que deverá ser 100.',
            )
        );
        register_setting(
            'mooven-split-setting-group',
            'mooven_creative_split_first_receiver_percent'
        );


        /**
         * ID Recebedor Secundário - Split de pagamento
         */
        add_settings_field(
            'mooven_creative_split_second_receiver_id',
            'ID Recebedor Secundário',
            'Mooven_Fields::mooven_creative_split_second_receiver_id_callback',
            'mooven-split-section-slug',
            'page_3_section',
            array(
                'ID do recebedor para o funcionamento do split de pagamento. Essa informação consta no painel da pagarme.',
            )
        );
        register_setting(
            'mooven-split-setting-group',
            'mooven_creative_split_second_receiver_id'
        );


        /**
         * Percentual do Recebedor Secundário - Split de pagamento
         */
        add_settings_field(
            'mooven_creative_split_second_receiver_percent',
            'Percentual do Recebedor Secundário',
            'Mooven_Fields::mooven_creative_split_second_receiver_percent_callback',
            'mooven-split-section-slug',
            'page_3_section',
            array(
                'Percentual recebido no split de pagamento. Insira um value de 0 a 100 considerando o primeiro recebedor na soma total que deverá ser 100.',
            )
        );
        register_setting(
            'mooven-split-setting-group',
            'mooven_creative_split_second_receiver_percent'
        );


        /**
         * Mensagens
         */

        /**
         * Titulo da Mensagem de Sucesso
         */
        add_settings_field(
            'mooven_creative_messages_subscription_success_title',
            'Sucesso - Titulo',
            'Mooven_Fields::mooven_creative_messages_subscription_success_title_callback',
            'mooven-messages-section-slug',
            'page_4_section',
            array(
                'Titulo da mensagem de sucesso.',
            )
        );
        register_setting(
            'mooven-messages-setting-group',
            'mooven_creative_messages_subscription_success_title'
        );

        /**
         * Texto da Mensagem de Sucesso
         */
        add_settings_field(
            'mooven_creative_messages_subscription_success_text',
            'Sucesso - Texto',
            'Mooven_Fields::mooven_creative_messages_subscription_success_text_callback',
            'mooven-messages-section-slug',
            'page_4_section',
            array(
                'Texto da mensagem de sucesso.',
            )
        );
        register_setting(
            'mooven-messages-setting-group',
            'mooven_creative_messages_subscription_success_text'
        );

        /**
         * Titulo da Mensagem de Ja é Assinante
         */
        add_settings_field(
            'mooven_creative_messages_subscription_already_subscriber_title',
            'Ja é Assinante - Titulo',
            'Mooven_Fields::mooven_creative_messages_subscription_already_subscriber_title_callback',
            'mooven-messages-section-slug',
            'page_4_section',
            array(
                'Titulo da mensagem de sucesso.',
            )
        );
        register_setting(
            'mooven-messages-setting-group',
            'mooven_creative_messages_subscription_already_subscriber_title'
        );

        /**
         * Texto da Mensagem de Ja é Assinante
         */
        add_settings_field(
            'mooven_creative_messages_subscription_already_subscriber_text',
            'Ja é Assinante - Texto',
            'Mooven_Fields::mooven_creative_messages_subscription_already_subscriber_text_callback',
            'mooven-messages-section-slug',
            'page_4_section',
            array(
                'Texto da mensagem de sucesso.',
            )
        );
        register_setting(
            'mooven-messages-setting-group',
            'mooven_creative_messages_subscription_already_subscriber_text'
        );

        /**
         * Titulo da Mensagem de Warning
         */
        add_settings_field(
            'mooven_creative_messages_subscription_warning_title',
            'Erro de dados - Titulo',
            'Mooven_Fields::mooven_creative_messages_subscription_warning_title_callback',
            'mooven-messages-section-slug',
            'page_4_section',
            array(
                'Titulo da mensagem de erro de dados.',
            )
        );
        register_setting(
            'mooven-messages-setting-group',
            'mooven_creative_messages_subscription_warning_title'
        );

        /**
         * Texto da Mensagem de Warning
         */
        add_settings_field(
            'mooven_creative_messages_subscription_warning_text',
            'Erro de dados - Texto',
            'Mooven_Fields::mooven_creative_messages_subscription_warning_text_callback',
            'mooven-messages-section-slug',
            'page_4_section',
            array(
                'Texto da mensagem de erro de dados.',
            )
        );
        register_setting(
            'mooven-messages-setting-group',
            'mooven_creative_messages_subscription_warning_text'
        );


        /**
         * Titulo da Mensagem de Login Requerido
         */
        add_settings_field(
            'mooven_creative_messages_subscription_login_required_title',
            'Login Obrigatório - Titulo',
            'Mooven_Fields::mooven_creative_messages_subscription_login_required_title_callback',
            'mooven-messages-section-slug',
            'page_4_section',
            array(
                'Titulo da mensagem de erro de dados.',
            )
        );
        register_setting(
            'mooven-messages-setting-group',
            'mooven_creative_messages_subscription_login_required_title'
        );

        /**
         * Texto da Mensagem de login_required
         */
        add_settings_field(
            'mooven_creative_messages_subscription_login_required_text',
            'Login Obrigatório - Texto',
            'Mooven_Fields::mooven_creative_messages_subscription_login_required_text_callback',
            'mooven-messages-section-slug',
            'page_4_section',
            array(
                'Texto da mensagem de erro de dados.',
            )
        );
        register_setting(
            'mooven-messages-setting-group',
            'mooven_creative_messages_subscription_login_required_text'
        );


        /**
         * Titulo da Mensagem de Erro
         */
        add_settings_field(
            'mooven_creative_messages_subscription_error_title',
            'Erro - Titulo',
            'Mooven_Fields::mooven_creative_messages_subscription_error_title_callback',
            'mooven-messages-section-slug',
            'page_4_section',
            array(
                'Titulo da mensagem de erro.',
            )
        );
        register_setting(
            'mooven-messages-setting-group',
            'mooven_creative_messages_subscription_error_title'
        );

        /**
         * Texto da Mensagem de Erro
         */
        add_settings_field(
            'mooven_creative_messages_subscription_error_text',
            'Erro - Texto',
            'Mooven_Fields::mooven_creative_messages_subscription_error_text_callback',
            'mooven-messages-section-slug',
            'page_4_section',
            array(
                'Texto da mensagem de erro.',
            )
        );
        register_setting(
            'mooven-messages-setting-group',
            'mooven_creative_messages_subscription_error_text'
        );
    }



    /**
     * Field Callbacks
     */

    public static function option_1_callback($args)
    {
?>
        <input type="text" id="option_1" class="option_1" name="option_1" value="<?php echo get_option('option_1') ?>">
        <p class="description option_1"> <?php echo $args[0] ?> </p>
        <?php
    }

    public static function subscription_state_callback($args)
    {
        $fields = array('mooven_creative_subscription_module_state');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='checkbox' name='$field'  value='1' " . checked(1, $value, false) . "><p class='description'>$args[0]</p>";

        endforeach;
    }


    public static function mooven_creative_subscription_api_url_callback($args)
    {
        $fields = array('mooven_creative_subscription_api_url');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_subscription_api_key_callback($args)
    {
        $fields = array('mooven_creative_subscription_api_key');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_subscription_api_encryption_key_callback($args)
    {

        $fields = array('mooven_creative_subscription_api_encryption_key');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_subscription_plan_id_callback($args)
    {
        $fields = array('mooven_creative_subscription_plan_id');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='number' min='0' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_subscription_postback_url_callback($args)
    {
        $fields = array('mooven_creative_subscription_postback_url');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_subscription_first_receiver_id_callback($args)
    {
        $fields = array('mooven_creative_subscription_first_receiver_id');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_subscription_second_receiver_id_callback($args)
    {
        $fields = array('mooven_creative_subscription_second_receiver_id');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_subscription_first_receiver_percent_callback($args)
    {
        $fields = array('mooven_creative_subscription_first_receiver_percent');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='number' min='0' max='100' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_subscription_second_receiver_percent_callback($args)
    {
        $fields = array('mooven_creative_subscription_second_receiver_percent');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='number' min='0' max='100' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_subscription_page_id_callback($args)
    {
        $fields = array('mooven_creative_subscription_page_id');

        $args = [
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => -1
        ];
        $loop_receivers = new WP_Query($args);

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            // echo "<input type='number' min='0' max='100' name='$field' value='$value'><p class='description'>$args[0]</p>";

        ?>
            <select type="text" id="mooven_creative_subscription_page_id" name="mooven_creative_subscription_page_id" class="mooven_creative_subscription_page_id">
                <?php if ($loop_receivers->have_posts()) :
                    while ($loop_receivers->have_posts()) : $loop_receivers->the_post(); ?>
                        <option <?php if (get_the_ID() == $value) :  echo 'selected="selected"';
                                endif; ?> value="<?= get_the_ID() ?>"><?= get_the_title() ?></option>
                    <?php endwhile; ?>
                <?php else : ?>
                    <option value="0">Nenhum cadastrado</option>
                <?php endif; ?>
            </select>
            <p class='description'><?= $args[0] ?></p>
            <style>
                .select2 {
                    width: 100%;
                    max-width: 400px;
                }
            </style>
            <script>
                jQuery(document).ready(function($) {
                    $('.mooven_creative_subscription_page_id').select2();
                });
            </script>
<?php

        endforeach;
    }

    /**
     * Split payment fields
     */


    public static function split_state_callback($args)
    {
        $fields = array('mooven_creative_split_module_state');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='checkbox' name='$field'  value='1' " . checked(1, $value, false) . "><p class='description'>$args[0]</p>";

        endforeach;
    }


    public static function mooven_creative_split_first_receiver_id_callback($args)
    {
        $fields = array('mooven_creative_split_first_receiver_id');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_split_second_receiver_id_callback($args)
    {
        $fields = array('mooven_creative_split_second_receiver_id');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_split_first_receiver_percent_callback($args)
    {
        $fields = array('mooven_creative_split_first_receiver_percent');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_split_second_receiver_percent_callback($args)
    {
        $fields = array('mooven_creative_split_second_receiver_percent');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }



    /**
     * Mensages
     */

    public static function mooven_creative_messages_subscription_success_text_callback($args)
    {
        $fields = array('mooven_creative_messages_subscription_success_text');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<textarea type='text' rows='6' name='$field'>$value</textarea><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_messages_subscription_success_title_callback($args)
    {
        $fields = array('mooven_creative_messages_subscription_success_title');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }



    public static function mooven_creative_messages_subscription_warning_text_callback($args)
    {
        $fields = array('mooven_creative_messages_subscription_warning_text');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<textarea type='text' rows='6' name='$field'>$value</textarea><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_messages_subscription_warning_title_callback($args)
    {
        $fields = array('mooven_creative_messages_subscription_warning_title');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_messages_subscription_error_text_callback($args)
    {
        $fields = array('mooven_creative_messages_subscription_error_text');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<textarea type='text' rows='6' name='$field'>$value</textarea><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_messages_subscription_error_title_callback($args)
    {
        $fields = array('mooven_creative_messages_subscription_error_title');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }


    public static function mooven_creative_messages_subscription_already_subscriber_text_callback($args)
    {
        $fields = array('mooven_creative_messages_subscription_already_subscriber_text');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<textarea type='text' rows='6' name='$field'>$value</textarea><p class='description'>$args[0]</p>";

        endforeach;
    }

    public static function mooven_creative_messages_subscription_already_subscriber_title_callback($args)
    {
        $fields = array('mooven_creative_messages_subscription_already_subscriber_title');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }


    public static function mooven_creative_messages_subscription_login_required_text_callback($args)
    {
        $fields = array('mooven_creative_messages_subscription_login_required_text');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<textarea type='text' rows='6' name='$field'>$value</textarea><p class='description'>$args[0]</p>";

        endforeach;
    }


    public static function mooven_creative_messages_subscription_login_required_title_callback($args)
    {
        $fields = array('mooven_creative_messages_subscription_login_required_title');

        foreach ($fields as  $field) :

            if (!empty($_POST[$field]))
                update_option($field, $_POST[$field]);

            $value = stripcslashes(get_option($field));

            echo "<input type='text' name='$field' value='$value'><p class='description'>$args[0]</p>";

        endforeach;
    }
}
