<?php

return [
    'asaas_pix_cartao' => [
        'code'        => 'asaas_pix_cartao',
        'title'       => 'PIX ou Cartão de Crédito',
        'description' => 'Pague com PIX ou Cartão de Crédito',
        'class'       => 'Ds\AssasIntegration\PaymentMethods\PixCartaoPaymentMethod',
        'active'      => true,
        'sort'        => 1,
    ],

    'asaas_boleto' => [
        'code'        => 'asaas_boleto',
        'title'       => 'Boleto Bancário',
        'description' => 'Pague com Boleto Bancário',
        'class'       => 'Ds\AssasIntegration\PaymentMethods\BoletoPaymentMethod',
        'active'      => true,
        'sort'        => 2,
    ],
];
