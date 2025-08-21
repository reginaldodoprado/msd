<?php

return [
    [
        'key'    => 'sales.payment_methods.asaas_pix_cartao',
        'name'   => 'PIX e Cartão',
        'info'   => 'Configurações para PIX e Cartão de Crédito',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'title',
                'title'         => 'Título',
                'type'          => 'text',
                'depends'       => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'description',
                'title'         => 'Descrição',
                'type'          => 'textarea',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'image',
                'title'         => 'Logo',
                'type'          => 'image',
                'info'          => 'Informações sobre o logo',
                'channel_based' => true,
                'locale_based'  => false,
                'validation'    => 'mimes:bmp,jpeg,jpg,png,webp',
            ], [
                'name'          => 'active',
                'title'         => 'Status',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'    => 'sort',
                'title'   => 'Ordem',
                'type'    => 'select',
                'options' => [
                    [
                        'title' => '1',
                        'value' => 1,
                    ], [
                        'title' => '2',
                        'value' => 2,
                    ], [
                        'title' => '3',
                        'value' => 3,
                    ], [
                        'title' => '4',
                        'value' => 4,
                    ],
                ],
            ],
        ],
    ], [
        'key'    => 'sales.payment_methods.asaas_boleto',
        'name'   => 'Boleto Bancário',
        'info'   => 'Configurações para Boleto Bancário',
        'sort'   => 2,
        'fields' => [
            [
                'name'          => 'title',
                'title'         => 'Título',
                'type'          => 'text',
                'depends'       => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'description',
                'title'         => 'Descrição',
                'type'          => 'textarea',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'image',
                'title'         => 'Logo',
                'type'          => 'image',
                'info'          => 'Informações sobre o logo',
                'channel_based' => true,
                'locale_based'  => false,
                'validation'    => 'mimes:bmp,jpeg,jpg,png,webp',
            ], [
                'name'          => 'active',
                'title'         => 'Status',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'    => 'sort',
                'title'   => 'Ordem',
                'type'    => 'select',
                'options' => [
                    [
                        'title' => '1',
                        'value' => 1,
                    ], [
                        'title' => '2',
                        'value' => 2,
                    ], [
                        'title' => '3',
                        'value' => 3,
                    ], [
                        'title' => '4',
                        'value' => 4,
                    ],
                ],
            ],
        ],
    ],
];
