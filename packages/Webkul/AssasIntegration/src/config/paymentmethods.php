<?php

return [
    'asaas_pix' => [
        'code'        => 'asaas_pix',
        'title'       => 'PIX',
        'description' => 'Pague com PIX via Asaas',
        'class'       => 'Ds\AssasIntegration\PaymentMethods\PixPaymentMethod',
        'active'      => true,
        'sort'        => 1,
    ],

    'asaas_cartao' => [
        'code'        => 'asaas_cartao',
        'title'       => 'Cartão de Crédito',
        'description' => 'Pague com Cartão de Crédito via Asaas',
        'class'       => 'Ds\AssasIntegration\PaymentMethods\CartaoCreditoPaymentMethod',
        'active'      => true,
        'sort'        => 2,
    ],

    'asaas_boleto' => [
        'code'        => 'asaas_boleto',
        'title'       => 'Boleto Bancário',
        'description' => 'Pague com Boleto Bancário via Asaas',
        'class'       => 'Ds\AssasIntegration\PaymentMethods\BoletoPaymentMethod',
        'active'      => true,
        'sort'        => 3,
    ],
];
