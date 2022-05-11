<div class="gallery-pagarme-assinar-response error gallery-pagarme-assinar-box">
    <div class="gallery-pagarme-assinar-response-box">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M16 31C24.2843 31 31 24.2843 31 16C31 7.71573 24.2843 1 16 1C7.71573 1 1 7.71573 1 16C1 24.2843 7.71573 31 16 31Z" stroke="#BC6965" stroke-width="2" />
            <path d="M9 9L24 24" stroke="#BC6965" stroke-width="2" stroke-linecap="square" />
            <path d="M8.49512 23.4585L24.5049 9.54138" stroke="#BC6965" stroke-width="2" stroke-linecap="square" />
        </svg>

        <?php

        $title = get_option('mooven_creative_messages_subscription_error_title');
        $text = get_option('mooven_creative_messages_subscription_error_text');

        if (empty($title)) {
            $title = __('Por favor cadastre um titúlo.', 'mooven');
        }
        if (empty($text)) {
            $text = __('Por favor cadastre uma mensagem.', 'mooven');
        }

        ?>

        <h3 class="gallery-pagarme-assinar-response-box-title error"><?= $title; ?></h3>
        <p class="gallery-pagarme-assinar-response-box-text"><?= $text; ?></p>
    </div>

    <a href="<?= get_permalink(); ?>" class="gallery-pagarme-assinar-facilities error"><?= __('tente novamente', 'mooven') ?></a>
</div>

<?php if (1 == 2) : ?>
    <script>
        console.log('<?= $_SESSION['response']  ?>')
        console.log('<?= $_SESSION['err'] ?>')
    </script>
<?php endif; ?>