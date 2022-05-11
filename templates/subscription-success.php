<?php

$obj_json = $_SESSION['obj_json'];
$success_title = $_SESSION['success_title'];
$success_text = $_SESSION['success_text'];

?>
<div class="gallery-pagarme-assinar-response success gallery-pagarme-assinar-box">
    <div class="gallery-pagarme-assinar-response-box">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
        </svg>
        <h3 class="gallery-pagarme-assinar-response-box-title success"><?= $success_title; ?></h3>
        <p class="gallery-pagarme-assinar-response-box-text"><?= $success_text; ?></p>
    </div>


    <h4 class="gallery-pagarme-assinar-response-dados-title"><?= __('Dados do assinante', 'mooven') ?></h4>
    <div class="gallery-pagarme-assinar-response-dados">
        <div class="row align-items-end d-flex">
            <div class="col-md-8">
                <div class="col-md-6">
                    <span><?= __('Nome:', 'mooven') ?></span>
                    <p class="gallery-pagarme-assinar-response-dados-text mb-3"><?= $obj_json->customer->name; ?></p>
                </div>
                <div class="col-md-6">
                    <span><?= __('E-mail:', 'mooven') ?></span>
                    <p class="gallery-pagarme-assinar-response-dados-text mb-3"><?= $obj_json->customer->email; ?></p>
                </div>
                <div class="col-md-6">
                    <span><?= __('Data de criação:', 'mooven') ?></span>
                    <?php $date_start = date_create($obj_json->current_transaction->date_created); ?>
                    <p class="gallery-pagarme-assinar-response-dados-text mb-0"><?= date_format($date_start, "d/m/Y"); ?></p>
                </div>
                <div class="col-md-6">
                    <?php $date_end = date_create($obj_json->current_transaction->date_updated); ?>
                    <span><?= __('Data de expiração:', 'mooven') ?></span>
                    <p class="gallery-pagarme-assinar-response-dados-text mb-0"><?= date_format($date_end, "d/m/Y"); ?></p>
                </div>
            </div>
            <?php if (1 == 2) : ?>
                <div class="col-md-4 d-flex justify-content-end">
                    <a href="<?= $obj_json->manage_url; ?>" target="_blank"><?= __('GERENCIAR ASSINATURA', 'mooven') ?></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <a href="https://galleryapp.com.br/facilities/" class="gallery-pagarme-assinar-facilities"><?= __('MEUS FACILITIES', 'mooven') ?></a>

    <div id="post_back_url"></div>
    <script>
        var product_back_url = sessionStorage.getItem("url_back_after_subscriber")
        var button_text = '<?= __('CONTINUAR COMPRANDO', 'mooven') ?>';
        if (product_back_url.length > 0) {
            var button_html = '<a href="' + product_back_url + '" class="gallery-pagarme-assinar-facilities">' + button_text + '</a>';
            document.getElementById('post_back_url').innerHTML = button_html;

            sessionStorage.setItem("url_back_after_subscriber", '');
        }
    </script>
</div>