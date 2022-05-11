<?php

namespace Source\Classes;

use WP_Query;

class Mooven_Product_Meta_Box
{

    public function __construct()
    {

        if (is_admin()) {
            add_action('load-post.php',     array($this, 'mooven_init_metabox'));
            add_action('load-post-new.php', array($this, 'mooven_init_metabox'));
        }

        $this::mooven_register_meta();
        add_action('init',  array($this, 'mooven_products_date_meta_init'));
    }

    public function mooven_init_metabox()
    {

        add_action('add_meta_boxes', array($this, 'mooven_add_metabox'), 10, 2);
        add_action('save_post',      array($this, 'mooven_save_metabox'), 10, 2);
    }

    public function mooven_add_metabox()
    {

        if (!class_exists('WooCommerce')) {
            return false;
        }

        if (split_is_enable()) {

            add_meta_box(
                'mooven_product',
                __('Informações do Recebedor', 'mooven'),
                array($this, 'mooven_render_metabox'),
                'product',
                'advanced',
                'default'
            );
        }
    }

    public function mooven_render_metabox($post)
    {

        // Adicione nonce para segurança e autenticação.
        wp_nonce_field('mooven_products_nonce_action', 'mooven_products_nonce');

        // Recupere um valor existente do banco de dados.
        $mooven_products_id_receiver = get_post_meta($post->ID, 'mooven_products_id_receiver', true);
        $mooven_products_percent_receiver = get_post_meta($post->ID, 'mooven_products_percent_receiver', true);


        // Defina valores padrão.
        if (empty($mooven_products_id_receiver)) $mooven_products_id_receiver = '';

        // Campos do formulário.
?>
        <table class="form-table mooven-table">

            <?php
            $args = [
                'post_type' => 'mooven_receivers',
                'post_status' => 'publish',
                'posts_per_page' => -1
            ];
            $loop_receivers = new WP_Query($args);
            ?>

            <tr>
                <th>
                    <label for="mooven_products_id_receiver" class="mooven_products_id_receiver_label"><?= __('ID do Recebedor', 'mooven') ?></label>
                </th>
                <td>
                    <select type="text" id="mooven_products_id_receiver" name="mooven_products_id_receiver" class="mooven_products_id_receiver_field">
                        <option></option>
                        <?php if ($loop_receivers->have_posts()) :
                            while ($loop_receivers->have_posts()) : $loop_receivers->the_post(); ?>
                                <option <?php if (get_the_ID() == $mooven_products_id_receiver) :  echo 'selected="selected"';
                                        endif; ?> value="<?= get_the_ID() ?>"><?= get_the_title() ?></option>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <option value="0">Nenhum cadastrado</option>
                        <?php endif; ?>
                    </select>
                    <p class="description"><?= __('Escolha o recebedor cadastrados.', 'mooven') ?></p>

                </td>
            </tr>

            <tr>
                <th>
                    <label for="mooven_products_percent_receiver" class="mooven_products_percent_receiver_label"><?= __('Percentual do Recebedor no Produto', 'mooven') ?></label>
                </th>
                <td>
                    <input type="number" max="100" min="0" id="mooven_products_percent_receiver" name="mooven_products_percent_receiver" class="mooven_products_percent_receiver_field" value="<?= $mooven_products_percent_receiver ?>"><?= __('', 'mooven') ?>
                    <p class="description"><?= __('O percentual escolhido aqui sobrepõe o cadastrado no recebedor. Para desativer o campo dentro do produto salve como 0.', 'mooven') ?></p>
                </td>
            </tr>


        </table>
        <!-- <style>
            .mooven-table input[type="text"],
            .select2 {
                width: 100%;
                max-width: 400px;
            }
        </style>
        <script>
            jQuery(document).ready(function($) {
                $('.mooven_products_id_receiver_field').select2();
                $('.mooven_products_id_receiver_field').select2({
                    placeholder: "Selecionar"
                });
            });
        </script> -->
<?php
    }

    public function mooven_save_metabox($post_id, $post)
    {

        // Adiciona nonce para segurança e autenticação.
        $nonce_name   = $_POST['mooven_products_nonce'];
        $nonce_action = 'mooven_products_nonce_action';

        // Verifica se um nonce está definido.
        if (!isset($nonce_name))
            return;

        // Verifica se um nonce é válido.
        if (!wp_verify_nonce($nonce_name, $nonce_action))
            return;

        // Verifica se o usuário tem permissão para salvar dados.
        if (!current_user_can('edit_post', $post_id))
            return;

        // Verifica se não é um salvamento automático.
        if (wp_is_post_autosave($post_id))
            return;

        // Verifica se não é uma revisão.
        if (wp_is_post_revision($post_id))
            return;

        // Higienize a entrada do usuário.
        $mooven_products_id_receiver_control = filter_input(INPUT_POST, "mooven_products_id_receiver", FILTER_VALIDATE_INT);
        $mooven_products_percent_receiver_control = filter_input(INPUT_POST, "mooven_products_percent_receiver", FILTER_VALIDATE_INT);

        // if (empty($mooven_products_percent_receiver_control) || $mooven_products_percent_receiver_control > 0 || $mooven_products_percent_receiver_control < 100) {
        //     $mooven_products_percent_receiver_control = 0;
        // }

        // Atualize o campo meta no banco de dados.
        update_post_meta($post_id, 'mooven_products_id_receiver', $mooven_products_id_receiver_control);
        update_post_meta($post_id, 'mooven_products_percent_receiver', $mooven_products_percent_receiver_control);
    }

    public static function mooven_register_meta()
    {
        if (!class_exists('WooCommerce')) {
            return false;
        }
        // O $object_type é para CPT;
        $object_type = 'product';
        $meta_args = array(
            'type'         => 'text',
            // Mostrado no esquema para a meta-chave.
            'description'  => 'A meta key associated with a string meta value.',
            // Retorna um único valor do tipo.
            'single'       => true,
            // Mostre na resposta da API REST do WP. Padrão: falso.
            'show_in_rest' => true,
        );

        register_meta($object_type, 'mooven_products_id_receiver', $meta_args);
        register_meta($object_type, 'mooven_products_percent_receiver', $meta_args);
    }

    public function mooven_products_date_meta_init()
    {
        if (!class_exists('WooCommerce')) {
            return false;
        }

        register_meta('product', 'mooven_products_id_receiver', array(
            'show_in_rest' => true,
            'single' => true
        ));
        register_meta('product', 'mooven_products_percent_receiver', array(
            'show_in_rest' => true,
            'single' => true
        ));
    }
}
