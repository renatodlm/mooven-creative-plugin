<?php

namespace Source\Classes;

use voku\helper\AntiXSS;

/**
 * API Assinatura Pagarme
 */
class Mooven_Subscription
{

    /**
     * API URL.
     *
     * @return string
     */
    protected static function get_api_url()
    {
        $api_url = get_option('mooven_creative_subscription_api_url');
        return $api_url;
    }

    /**
     * API KEY.
     *
     * @return string
     */
    protected static function get_api_key()
    {
        $api_key = get_option('mooven_creative_subscription_api_key');
        return $api_key;
    }
    /**
     * API Encryption key
     *
     * @return string
     */
    protected static function get_api_encryption_key()
    {
        $api_encryption_key = get_option('mooven_creative_subscription_api_key');
        return $api_encryption_key;
    }
    /**
     * Plan ID.
     *
     * @return string
     */
    protected static function get_plan_id()
    {
        $plan_id = get_option('mooven_creative_subscription_plan_id');
        return $plan_id;
    }
    /**
     * Postback URL.
     *
     * @return string
     */
    protected static function get_postbacl_url()
    {
        $postbacl_url = get_option('mooven_creative_subscription_postback_url');
        return $postbacl_url;
    }

    public static function pagarme_subscriber()
    {

        $antiXss = new AntiXSS();

        $custom_filter = [
            "user-full-name" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            "user-cpf" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            "user-email" => FILTER_VALIDATE_EMAIL,
            "user-postalcode" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            "user-address" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            "user-neighborhood" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            "user-number" => FILTER_VALIDATE_INT,
            "user-phone" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            "card_hash" => FILTER_DEFAULT
        ];

        $data_post = filter_input_array(INPUT_POST, $custom_filter);

        if (!in_array(false, $data_post) && !empty($data_post)) :

            $user_full_name = $data_post['user-full-name'];
            $user_document_number = $data_post['user-cpf'];
            $user_email = $data_post['user-email'];
            $user_zipcode = $data_post['user-postalcode'];
            $user_address = $data_post['user-address'];
            $user_neighborhood = $data_post['user-neighborhood'];
            $user_street_number = $data_post['user-number'];
            $card_hash = $antiXss->xss_clean($data_post['card_hash']);
            $telefone = $data_post['user-phone'];

            $user_phone = preg_replace('/\D/', '', $telefone);

            if (strlen($user_phone) < 10) {
                require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/templates/subscription-warning.php');
                return false;
            }

            $user_ddd = mb_substr($user_phone, 0, 2);
            $user_phone = substr($user_phone, 2, 9);

            if (!is_user_logged_in()) {
                return false;
            }

            /**
             * Define variavel com login do usuario atual
             */
            $current_user = wp_get_current_user();
            $subscriber_login = $current_user->user_login;

            if (empty($subscriber_login)) {
                return false;
            }

            $receiver_id_gallery = get_option('mooven_creative_subscription_second_receiver_id');
            $receiver_id_mooven = get_option('mooven_creative_subscription_first_receiver_id');

            if (empty($receiver_id_gallery) && empty($receiver_id_mooven)) {
                return false;
            }

            $gallery_percent = '90';
            $mooven_percent = '10';

            if (!empty(get_option('mooven_creative_subscription_first_receiver_percent') && !empty(get_option('mooven_creative_subscription_second_receiver_percent')))) {
                $gallery_percent = get_option('mooven_creative_subscription_second_receiver_percent');
                $mooven_percent = get_option('mooven_creative_subscription_first_receiver_percent');
            }

            $totalpercent = $mooven_percent + $gallery_percent;
            if ($totalpercent != 100) {
                echo 'O total percentual deve ser 100!';
                return false;
            }

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => Mooven_Subscription::get_api_url(),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n    \"api_key\": \"" . Mooven_Subscription::get_api_key() . "\", \n    \"card_hash\": \"" . $card_hash . "\", \n    \"customer\": {\n        \"address\": {\n            \"neighborhood\": \"" . $user_neighborhood . "\", \n            \"street\": \"" . $user_address . "\", \n            \"street_number\": \"" . $user_street_number . "\", \n            \"zipcode\": \"" . $user_zipcode . "\"\n        }, \n        \"document_number\": \"" . $user_document_number . "\", \n        \"email\": \"" . $user_email . "\", \n        \"name\": \"" . $user_full_name . "\", \n        \"phone\": {\n            \"ddd\": \"" . $user_ddd . "\", \n            \"number\": \"" . $user_phone . "\"\n        }\n    }, \n    \"payment_method\": \"credit_card\", \n    \"plan_id\": \"" . Mooven_Subscription::get_plan_id() . "\", \n    \"postback_url\": \"" . Mooven_Subscription::get_postbacl_url() . "\",\n  \t\"split_rules\": [\n    \t{\n      \t\"recipient_id\": \"" . $receiver_id_mooven . "\",\n      \t\"percentage\": " . $mooven_percent . ",\n      \t\"liable\": true,\n      \t\"charge_processing_fee\": true\n    \t},{\n      \t\"recipient_id\": \"" . $receiver_id_gallery . "\",\n      \t\"percentage\": " . $gallery_percent . ",\n      \t\"liable\": true,\n      \t\"charge_processing_fee\": true\n    \t}\n   \t],\n\t\t\"metadata\": {\n\t\t\t\"subscriber_login\": \"" . $subscriber_login . "\",\n\t\t\t\"subscriber_email\": \"" . $user_email . "\",\n\t\t\t\"subscriber_document_number\": \"" . $user_document_number . "\"\n\t\t}\n}",
                CURLOPT_COOKIE => "__cfruid=3113a418b3f12a31cbf6bd6746a7887a39b63db8-1641307077",

                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ],
            ]);

            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);
            $_SESSION['response'] = $response;
            $obj_json = json_decode($response);

            $err = curl_error($curl);
            $_SESSION['err'] = $err;

            curl_close($curl);
        else :
        //$err = 'Erro';
        endif;


        if (!empty($err)) {

            require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/templates/subscription-error.php');
        } else {

            if (!empty($obj_json->errors)) :
                require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/templates/subscription-warning.php');
            else :
                $_SESSION['obj_json'] = $obj_json;
                $_SESSION['success_title'] = 'Parabéns! Bem vindo a Gallery Memberships Club!';
                $_SESSION['success_text'] = 'Sua assinatura foi realizada com sucesso! Logo abaixo você pode visualizar seus dados referente a assinatura, após esse periodo inicial de sua assinatura ela será renovada automáticamente, você pode gerenciala atráves do link "Gerenciar Assinatura" abaixo. Aproveite <a href="https://galleryapp.com.br/facilities/">SEUS FACILITIES</a>, para mais informações entre em contato com nosso time de suporte.';

                require_once(plugin_dir_path(MOOVEN_PLUGIN_FILE) . '/templates/subscription-success.php');

            endif;
        }
    }

    public function subscriber_scripts()
    {

        wp_enqueue_script('jquery');

        $subscription_page = get_option('mooven_creative_subscription_page_id');
        $subscription_module_state = get_option('mooven_creative_subscription_module_state');
        $api_encryption_key = get_option('mooven_creative_subscription_api_encryption_key');

        if (!empty($subscription_page) && !empty($subscription_module_state)) {
            if (is_page($subscription_page)) :

                wp_enqueue_style('mooven_subscriber_css', get_stylesheet_directory_uri() . '/scss/themes/assinatura/assinatura.css', array(), null, false);

                //Adicionando o script da assinatura
                wp_enqueue_script('mooven_subscriber_js', get_stylesheet_directory_uri() . '/js/themes/assinatura/assinatura.js', array(), null, false);
                //Adicionando o script da documentação do pagarme para geração do cardhash
                wp_enqueue_script('pagarme_js', get_stylesheet_directory_uri() . '/js/themes/assinatura/pagarme.js', array(), null, false);

                //Adicionando variaveis ao JS
                wp_localize_script('mooven_subscriber_js', 'mooven_pagarme_vars', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'my_encryption_key' =>  $api_encryption_key,
                ));

            endif;
        }

        wp_enqueue_script('mooven_subscriber_js');
    }


    public static function is_Subcriber()
    {
        if (!is_user_logged_in()) {
            return false;
        }

        $current_user = wp_get_current_user();
        $subscriber_login = $current_user->user_login;
        $subscriber_email = $current_user->user_email;

        if (empty($subscriber_login) || empty($subscriber_email)) {
            return false;
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => Mooven_Subscription::get_api_url(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{\n    \"api_key\": \"" . Mooven_Subscription::get_api_key() . "\",\n\t\t\"status\": \"paid\",\n\t\t\t\"metadata\": {\n\t\t\t\"subscriber_login\": \"" . $subscriber_login . "\",\n\t\t\t\t\"subscriber_email\": \"" . $subscriber_email . "\"\n\t\t}\n}",
            CURLOPT_COOKIE => "AWSALBTGCORS=x4qi%2Boydh2CejUZ33F5TlQKlBPkxF0x1%2Bu0K5JMtAvstJ3XGhBgpwwonqJBVPlIWHx4zPS%2BVYjl%2BTzRQzLawELKrH0wkB6uZCNAQQk30pElTjpGiBuriaAiniJklcazXbxEQ5IO0BS0DLJspEIosrKnBckLEkvMe9lcKVdT9WF2Q; AWSALBTG=x4qi%2Boydh2CejUZ33F5TlQKlBPkxF0x1%2Bu0K5JMtAvstJ3XGhBgpwwonqJBVPlIWHx4zPS%2BVYjl%2BTzRQzLawELKrH0wkB6uZCNAQQk30pElTjpGiBuriaAiniJklcazXbxEQ5IO0BS0DLJspEIosrKnBckLEkvMe9lcKVdT9WF2Q; __cfruid=4184a00a5c7cbf2aec1f1a1e0c4dffb83b5fe6d7-1644500617",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
        ]);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            $obj_json = json_decode($response);
            $obj_json = $obj_json[0];
        }

        if (!empty($obj_json)) {
            return $obj_json;
        }


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => Mooven_Subscription::get_api_url(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{\n    \"api_key\": \"" . Mooven_Subscription::get_api_key() . "\",\n\t\t\"status\": \"trialing\",\n\t\t\t\"metadata\": {\n\t\t\t\"subscriber_login\": \"" . $subscriber_login . "\",\n\t\t\t\t\"subscriber_email\": \"" . $subscriber_email . "\"\n\t\t}\n}",
            CURLOPT_COOKIE => "AWSALBTGCORS=x4qi%2Boydh2CejUZ33F5TlQKlBPkxF0x1%2Bu0K5JMtAvstJ3XGhBgpwwonqJBVPlIWHx4zPS%2BVYjl%2BTzRQzLawELKrH0wkB6uZCNAQQk30pElTjpGiBuriaAiniJklcazXbxEQ5IO0BS0DLJspEIosrKnBckLEkvMe9lcKVdT9WF2Q; AWSALBTG=x4qi%2Boydh2CejUZ33F5TlQKlBPkxF0x1%2Bu0K5JMtAvstJ3XGhBgpwwonqJBVPlIWHx4zPS%2BVYjl%2BTzRQzLawELKrH0wkB6uZCNAQQk30pElTjpGiBuriaAiniJklcazXbxEQ5IO0BS0DLJspEIosrKnBckLEkvMe9lcKVdT9WF2Q; __cfruid=4184a00a5c7cbf2aec1f1a1e0c4dffb83b5fe6d7-1644500617",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
        ]);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            $obj_json = json_decode($response);
            $obj_json = $obj_json[0];
        }

        if (!empty($obj_json)) {
            return $obj_json;
        }

        return false;
    }
}
