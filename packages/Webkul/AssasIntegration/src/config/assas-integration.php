<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configurações da API Asaas
    |--------------------------------------------------------------------------
    |
    | Aqui você pode configurar as credenciais e URLs da API Asaas
    |
    */

    'asaas' => [
        // Chave da API (obrigatória)
        'api_key' => env('ASAAS_API_KEY'),
        
        // URL base da API (sandbox ou produção)
        'base_url' => env('ASAAS_BASE_URL', 'https://sandbox.asaas.com/api/v3'),
        
        // Ambiente (sandbox ou production)
        'environment' => env('ASAAS_ENVIRONMENT', 'sandbox'),
        
        // Timeout para requisições (em segundos)
        'timeout' => env('ASAAS_TIMEOUT', 30),
        
        // Número máximo de tentativas em caso de erro
        'max_retries' => env('ASAAS_MAX_RETRIES', 3),
        
        // Headers personalizados
        'headers' => [
            'User-Agent' => 'Laravel App',
            'Content-Type' => 'application/json',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Webhook
    |--------------------------------------------------------------------------
    |
    | Configurações para receber notificações de pagamentos
    |
    */

    'webhook' => [
        // Chave secreta para validar webhooks
        'secret_key' => env('ASAAS_WEBHOOK_SECRET'),
        
        // URL do webhook (opcional)
        'url' => env('ASAAS_WEBHOOK_URL'),
        
        // Eventos que você quer receber
        'events' => [
            'PAYMENT_RECEIVED',
            'PAYMENT_OVERDUE',
            'PAYMENT_DELETED',
            'PAYMENT_RESTORED',
            'PAYMENT_REFUNDED',
            'PAYMENT_RECEIVED_CASH',
            'PAYMENT_ANTICIPATED',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Pagamento
    |--------------------------------------------------------------------------
    |
    | Configurações padrão para pagamentos
    |
    */

    'payment' => [
        // Moeda padrão
        'currency' => env('ASAAS_CURRENCY', 'BRL'),
        
        // Dias para vencimento padrão
        'default_due_days' => env('ASAAS_DEFAULT_DUE_DAYS', 3),
        
        // Taxa de juros mensal padrão
        'interest_rate' => env('ASAAS_INTEREST_RATE', 0),
        
        // Taxa de multa padrão
        'fine_rate' => env('ASAAS_FINE_RATE', 0),
        
        // Desconto padrão
        'discount_rate' => env('ASAAS_DISCOUNT_RATE', 0),
    ],
];
