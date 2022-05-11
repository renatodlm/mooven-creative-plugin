<?php

use Source\Classes\Mooven_Subscription;

get_header();

$custom_filter = [
    "url_back_after_subscriber" => FILTER_DEFAULT,
];

$data_get = filter_input_array(INPUT_GET, $custom_filter);

if (!in_array(false, $data_get) && !empty($data_get)) :

    $url_back_after_subscriber = $data_get['url_back_after_subscriber'];
?>
    <script>
        var url_checkout = '<?= $url_back_after_subscriber ?>';
        sessionStorage.setItem("url_back_after_subscriber", url_checkout);
    </script>
<?php
endif;


if (is_user_logged_in() && class_exists('Source\Classes\Mooven_Subscription')) {
    /**
     * Coletando dados do usuario atual
     */

    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;

    /**
     * Telefone
     */
    $telefone = get_user_meta($user_id, 'phone_number', true);

    $user_phone = preg_replace('/\D/', '', $telefone);

    if (strlen($user_phone) < 10) {
        $user_phone = '';
    }

    if (!empty($user_phone)) {
        $user_ddd = mb_substr($user_phone, 0, 2);
        $user_phone = substr($user_phone, 2, 9);
    }

    /* 
    * Nome Completo
    */
    $full_name = get_user_meta($user_id, 'first_name', true) . ' ' . get_user_meta($user_id, 'last_name', true);

    if (empty($full_name)) {
        $full_name = $current_user->display_name;
    }

    /** 
     * CPF
     */
    $user_cpf = get_user_meta($user_id, 'user_cpf', true);

    if (!empty($user_cpf)) {
        $user_cpf = preg_replace('/\D/', '', $user_cpf);
    }

?>

    <div class="gallery-pagarme-assinar">
        <div class="container">
            <div class="row justify-content-center d-flex flex-wrap">
                <div class="col-lg-9 col-md-10">
                    <?php
                    $is_subscriber = new Mooven_Subscription;

                    if (!empty($is_subscriber::is_Subcriber())) {

                        $obj = $is_subscriber::is_Subcriber();

                        //Aplicar variaveis para o template success

                        $already_title = get_option('mooven_creative_messages_subscription_already_subscriber_title');
                        $already_text = get_option('mooven_creative_messages_subscription_already_subscriber_text');

                        if (empty($already_title)) {
                            $already_title = __('Por favor cadastre um titúlo.', 'mooven');
                        }
                        if (empty($already_text)) {
                            $already_text = __('Por favor cadastre uma mensagem.', 'mooven');
                        }

                        $_SESSION['obj_json'] = $obj;
                        $_SESSION['success_title'] = $already_title;
                        $_SESSION['success_text'] = $already_text;

                        require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/templates/subscription-success.php'); ?>

                    <?php } else {
                    ?>
                        <form id="payment_form" class="gallery-pagarme-assinar-box" action="" method="POST">
                            <div class="row my-3">
                                <div class="col-12">
                                    <div class="gallery-pagarme-assinar-box-dados-pessoais">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label><?= __('Nome completo', 'mooven') ?></label>
                                                <input type="text" name="user-full-name" id="user-full-name" value="<?php if (!empty($full_name)) : echo $full_name;
                                                                                                                    endif; ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label><?= __('CPF', 'mooven') ?></label>
                                                <input type="text" name="user-cpf" id="user-cpf" value="<?php if (!empty($user_cpf)) : echo $user_cpf;
                                                                                                        endif; ?>">
                                                <p id="cpf-mesage" class="gallery-pagarme-assinar-mesage"></p>
                                            </div>
                                            <div class="col-md-7">
                                                <label><?= __('E-mail', 'mooven') ?></label>
                                                <input type="text" name="user-email" id="user-email" value="<?= $current_user->user_email; ?>">
                                                <span id="email-mesage" class="gallery-pagarme-assinar-mesage"></span>
                                            </div>
                                            <div class="col-md-5">
                                                <label><?= __('Telefone', 'mooven') ?></label>
                                                <input type="text" name="user-phone" id="user-phone" value="<?= $user_ddd . $user_phone; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gallery-pagarme-assinar-box-endereco">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label><?= __('CEP', 'mooven') ?></label>
                                                <input type="text" name="user-postalcode" id="user-postalcode">
                                            </div>
                                            <div class="col-md-8">
                                                <label><?= __('Bairro', 'mooven') ?></label>
                                                <input type="text" name="user-neighborhood" id="user-neighborhood">
                                            </div>
                                            <div class="col-md-9">
                                                <label><?= __('Logradouro', 'mooven') ?></label>
                                                <input type="text" name="user-address" id="user-address">
                                            </div>
                                            <div class="col-md-3">
                                                <label><?= __('Numero', 'mooven') ?></label>
                                                <input type="number" name="user-number" id="user-number">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3 align-items-center">
                                <div class="col-lg-6">
                                    <div class="col1">
                                        <div class="card card-gallery">
                                            <div class="front">
                                                <div class="type">
                                                    <img class="bankid" />
                                                </div>
                                                <span class="chip"></span>
                                                <span class="card_number">&#x25CF;&#x25CF;&#x25CF;&#x25CF;
                                                    &#x25CF;&#x25CF;&#x25CF;&#x25CF;
                                                    &#x25CF;&#x25CF;&#x25CF;&#x25CF; &#x25CF;&#x25CF;&#x25CF;&#x25CF;
                                                </span>
                                                <div class="date"><span class="date_value"><?= __('MM / YYYY', 'mooven') ?></span></div>
                                                <span class="fullname"><?= __('NOME COMPLETO', 'mooven') ?></span>
                                            </div>
                                            <div class="back">
                                                <div class="magnetic"></div>
                                                <div class="bar"></div>
                                                <span class="seccode">&#x25CF;&#x25CF;&#x25CF;</span>
                                                <span class="chip"></span><span class="disclaimer">Este é apenas um cartão de ilustração, todo efeito é apenas visual. <br> Não salvamos dados de cartões de nossos clientes.
                                                    para tirar dúvidas entre em contato,
                                                    ~ Mooven Creative </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="col2">
                                        <div class="row">

                                            <div class="col-xs-12">
                                                <label><?= __('Numero do cartão', 'mooven') ?></label>
                                                <input id="card_number" class="number" type="text" ng-model="ncard" maxlength="19" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
                                            </div>
                                            <div class="col-xs-12">
                                                <label><?= __('Nome como impresso no cartão', 'mooven') ?></label>
                                                <input id="card_holder_name" class="inputname" type="text" placeholder="" />

                                            </div>
                                            <div class="col-xs-6">
                                                <label><?= __('Data de expiração', 'mooven') ?></label>
                                                <input id="card_expiration" class="expire" type="text" placeholder="MM / AA" />
                                            </div>
                                            <div class="col-xs-6">
                                                <label><?= __('Código de Segurança', 'mooven') ?></label>
                                                <input id="card_cvv" class="ccv" type="text" placeholder="CVV" maxlength="3" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
                                            </div>
                                        </div>
                                        <input type="hidden" id="card_hash" name="card_hash" value="">
                                        <input id="payment_form_submit" type="submit" class="buy" value="<?= __('Assinar agora', 'mooven') ?>">
                                        <div id="field_errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="payment_form_loading">
                                <div id="gallery-loader" class="gallery-loader">
                                    <div class="load-1">
                                        <div class="line"></div>
                                        <div class="line"></div>
                                        <div class="line"></div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div id="payment_form_response">
                        </div>
                <?php
                    };
                } else {
                    echo '<div class="gallery-pagarme-assinar">';
                    echo '<div class="container">';
                    echo '<div class="row justify-content-center d-flex flex-wrap">';
                    echo '<div class="col-lg-9 col-md-10">';

                    require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/templates/subscription-already-subscriber.php');
                }
                ?>

                </div>
            </div>
        </div>
    </div>
    <?php get_footer(); ?>