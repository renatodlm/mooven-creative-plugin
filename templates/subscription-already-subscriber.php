<div class="gallery-pagarme-assinar-response gallery-pagarme-assinar-box">
    <div class="gallery-pagarme-assinar-response-box">
        <?php
        $current_url = get_permalink();
        $url_login = get_permalink(UM()->options()->get('core_login')) . '?redirect_to=' . $current_url;

        $required_title = get_option('mooven_creative_messages_subscription_login_required_title');
        $required_text = get_option('mooven_creative_messages_subscription_login_required_text');

        if (empty($required_title)) {
            $required_title = __('Por favor cadastre um titúlo.', 'mooven');
        }
        if (empty($required_text)) {
            $required_text = __('Por favor cadastre uma mensagem.', 'mooven');
        }

        ?>
        <h3 class="gallery-pagarme-assinar-response-box-title"><?= $required_title; ?></h3>
        <p class="gallery-pagarme-assinar-response-box-text"><?= $required_text; ?></p>
    </div>

    <div style="text-align:center;margin-bottom:15px;">
        <a class="gallery-pagarme-assinar-facilities" style="display:inline-flex; margin: 5px;" href="<?= $url_login; ?>"><?= __('ENTRAR', 'mooven') ?></a>
        <a class="gallery-pagarme-assinar-facilities" style="display:inline-flex; margin: 5px;" href="<?= get_permalink(UM()->options()->get('core_register')); ?>"><?= __('CADASTRE-SE', 'mooven') ?></a>
    </div>
</div>