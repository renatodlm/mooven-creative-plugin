<?php

namespace Source\Classes;

class Mooven_Receiver_Meta_Box
{

    public function __construct()
    {

        if (is_admin()) {
            add_action('load-post.php',     array($this, 'mooven_init_metabox'), 10, 3);
            add_action('load-post-new.php', array($this, 'mooven_init_metabox'), 10, 3);
        }

        $this::mooven_register_meta();
        add_action('init',  array($this, 'mooven_receivers_date_meta_init'));
    }

    public function mooven_init_metabox()
    {

        add_action('add_meta_boxes', array($this, 'mooven_add_metabox'));
        add_action('save_post',      array($this, 'mooven_save_metabox'), 10, 3);
    }

    public function mooven_add_metabox()
    {

        if (split_is_enable()) {

            add_meta_box(
                'mooven_receiver',
                __('Informações do Recebedor', 'mooven'),
                array($this, 'mooven_render_metabox'),
                'mooven_receivers',
                'advanced',
                'default'
            );
        }
    }

    public function mooven_render_metabox($post)
    {

        // Adicione nonce para segurança e autenticação.
        wp_nonce_field('mooven_receivers_nonce_action', 'mooven_receivers_nonce');

        // Recupere um valor existente do banco de dados.
        $mooven_receivers_id_receiver = get_post_meta($post->ID, 'mooven_receivers_id_receiver', true);
        $mooven_receivers_percent_receiver = get_post_meta($post->ID, 'mooven_receivers_percent_receiver', true);

        // Defina valores padrão.
        if (empty($mooven_receivers_id_receiver)) $mooven_receivers_id_receiver = '';

        // Campos do formulário.
?>
        <table class="form-table mooven-table">

            <tr>
                <th>
                    <label for="mooven_receivers_id_receiver" class="mooven_receivers_id_receiver_label"><?= __('ID do Recebedor', 'mooven') ?></label>
                </th>
                <td>
                    <input type="text" id="mooven_receivers_id_receiver" name="mooven_receivers_id_receiver" class="mooven_receivers_id_receiver_field" value="<?= $mooven_receivers_id_receiver ?>"><?= __('', 'mooven') ?>
                    <p class="description"><?= __('Esta informação está disponível na plataforma da pagarme.', 'mooven') ?></p>
                </td>
            </tr>

            <tr>
                <th>
                    <label for="mooven_receivers_percent_receiver" class="mooven_receivers_percent_receiver_label"><?= __('Percentual do Recebedor', 'mooven') ?></label>
                </th>
                <td>
                    <input type="number" min="0" max="100" id="mooven_receivers_percent_receiver" name="mooven_receivers_percent_receiver" class="mooven_receivers_percent_receiver_field" value="<?= $mooven_receivers_percent_receiver ?>"><?= __('', 'mooven') ?>
                    <p class="description"><?= __('Esta informação está disponível na plataforma da pagarme.', 'mooven') ?></p>
                </td>
            </tr>

        </table>
        <style>
            .mooven-table input[type="text"] {
                width: 100%;
                max-width: 400px;
            }
        </style>
<?php
    }

    public function mooven_save_metabox($post_id, $post)
    {

        // Adiciona nonce para segurança e autenticação.
        $nonce_name   = $_POST['mooven_receivers_nonce'];
        $nonce_action = 'mooven_receivers_nonce_action';

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
        $mooven_receivers_id_receiver_control = filter_input(INPUT_POST, "mooven_receivers_id_receiver", FILTER_SANITIZE_STRING);
        $mooven_receivers_percent_receiver_control = filter_input(INPUT_POST, "mooven_receivers_percent_receiver", FILTER_VALIDATE_INT);

        // Atualize o campo meta no banco de dados.
        update_post_meta($post_id, 'mooven_receivers_id_receiver', $mooven_receivers_id_receiver_control);
        update_post_meta($post_id, 'mooven_receivers_percent_receiver', $mooven_receivers_percent_receiver_control);
    }

    public static function mooven_register_meta()
    {
        // O $object_type é para CPT;
        $object_type = 'mooven_receivers';
        $meta_args = array(
            'type'         => 'text',
            // Mostrado no esquema para a meta-chave.
            'description'  => 'A meta key associated with a string meta value.',
            // Retorna um único valor do tipo.
            'single'       => true,
            // Mostre na resposta da API REST do WP. Padrão: falso.
            'show_in_rest' => true,
        );

        register_meta($object_type, 'mooven_receivers_id_receiver', $meta_args);
        register_meta($object_type, 'mooven_receivers_percent_receiver', $meta_args);
    }

    public function mooven_receivers_date_meta_init()
    {
        register_meta('mooven_receivers', 'mooven_receivers_id_receiver', array(
            'show_in_rest' => true,
            'single' => true
        ));
        register_meta('mooven_receivers', 'mooven_receivers_percent_receiver', array(
            'show_in_rest' => true,
            'single' => true
        ));
    }
}
