<?php

namespace Source\Classes;

class Mooven_Split
{

    public function pagarme_split($data, $order)
    {

        if (!class_exists('WooCommerce')) {
            return false;
        }

        $first_receiver_rep_id = get_option('mooven_creative_split_first_receiver_id');
        $second_receiver_rep_id = get_option('mooven_creative_split_second_receiver_id');

        //Se não existir recebedores continua o checkout sem split
        if (empty($second_receiver_rep_id) || empty($first_receiver_rep_id)) {
            return $data;
        }

        $second_receiver = [
            'amount' => 0,
            'recipient_id' => $second_receiver_rep_id,
            'charge_processing_fee' => true,
            'liable' => true
        ];
        $first_receiver = [
            'amount' => 0,
            'recipient_id' => $first_receiver_rep_id,
            'charge_processing_fee' => true,
            'liable' => true
        ];

        $products_list = $order->get_items();

        $obj_receivers_amount = [];

        //Recebedores sócios - Geralmente Mooven e o cliente
        $second_receiver_amount = 0;
        $first_receiver_amount = 0;

        $first_receiver_percent = intval(get_option('mooven_creative_split_first_receiver_percent'));
        $second_receiver_percent = intval(get_option('mooven_creative_split_second_receiver_percent'));

        if (empty($first_receiver_percent) || empty($second_receiver_percent)) {
            wc_add_notice(__('Recebedores principais inválidos'), 'error');
            return false;
        }

        foreach ($products_list as $item) {

            //Pega o valor do ID do recebedor dentro do produto
            $receiver_product_id = intval(get_post_meta($item['product_id'], 'mooven_products_id_receiver', true));
            $receiver_product_percent =  intval(get_post_meta($item['product_id'], 'mooven_products_percent_receiver', true));

            //Continua o checkout sem split
            if (empty($receiver_product_id) || $receiver_product_id == 0) {
                wc_add_notice(__('Recebedor ID do produto inválido'), 'error');
                return false;
            }
            //Pega o valor do hash ID do recebedor no cadastro de recebedores
            $receiver_rep_id_hash = get_post_meta($receiver_product_id, 'mooven_receivers_id_receiver', true);
            $receiver_percent = get_post_meta($receiver_product_id, 'mooven_receivers_percent_receiver', true);

            if (!empty($receiver_product_percent) && $receiver_product_percent > 0) {
                $receiver_percent = $receiver_product_percent;
            }

            $total_ownner = ($receiver_percent / 100) * $item['total'];

            //$total_test = $total;
            $rest_total = $item['total'] - $total_ownner;

            $second_receiver_amount = ($second_receiver_percent / 100) * $rest_total;
            $second_receiver['amount'] = ($second_receiver_amount * 100) + $second_receiver['amount'];

            $first_receiver_amount = $rest_total - $second_receiver_amount;
            $first_receiver['amount'] = ($first_receiver_amount * 100) + $first_receiver['amount'];

            if (!empty($obj_receivers_amount[$receiver_rep_id_hash])) {
                $total_ownner = $total_ownner + $obj_receivers_amount[$receiver_rep_id_hash];
            }

            $obj_receivers_amount[$receiver_rep_id_hash] = $total_ownner;
        }

        //Clientes
        $array_receivers = [];
        //Valores de Primeiro e Segundo recebedores

        $r = 0;

        foreach ($obj_receivers_amount as $key => $value) {

            $array_receivers[$r]['amount'] = $value * 100;
            $array_receivers[$r]['recipient_id'] = $key;
            $array_receivers[$r]['charge_processing_fee'] = false;
            $array_receivers[$r]['liable'] = true;

            $r++;
        }


        /**
         * Mooven Pagarme split
         */
        $split_rules_obj = [];

        if (!empty($array_receivers)) {
            foreach ($array_receivers as $item) {
                array_push($split_rules_obj, $item);
            }
        }

        array_push($split_rules_obj, $second_receiver);

        array_push($split_rules_obj, $first_receiver);

        $data['split_rules'] = $split_rules_obj;

        return $data;
    }
}
