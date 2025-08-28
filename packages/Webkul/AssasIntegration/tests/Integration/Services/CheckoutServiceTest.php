<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Ds\AssasIntegration\Tests\TestCase;
use Ds\AssasIntegration\Services\CheckoutService;
use Ds\AssasIntegration\Services\ApiClientService;

// teste individual do serviço CheckoutService 
// php artisan test tests/Integration/CheckoutServiceTest.php

class CheckoutServiceTest extends TestCase
{
    protected $apiClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
    }

    /** @test */
    public function criar_checkout()
    {
        $service = new CheckoutService($this->apiClient);

        $dados = [
            'name' => 'Checkout de Teste',
            'value' => 99.90,
            'billingTypes' => ['PIX'], // Apenas PIX para simplificar
            'chargeTypes' => ['DETACHED'], // Tentando com valores mais básicos
            'dueDateLimitDays' => 3,
            'notificationEnabled' => true,
            'description' => 'Teste de checkout',
            'items' => [ // Itens obrigatórios
                [
                    'name' => 'Produto de Teste',
                    'value' => 99.90,
                    'amount' => 1,
                    'quantity' => 1
                ]
            ],
            'callback' => [ // Callback obrigatório
                'successUrl' => 'https://exemplo.com/sucesso',
                'cancelUrl' => 'https://exemplo.com/cancelado'
            ]
        ];

        $response = $service->criarCheckout($dados);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);

        return $response['id'];
    }

    /** 
     * @test
     * @depends criar_checkout
     */
    public function cancelar_checkout($checkoutId)
    {
        $service = new CheckoutService($this->apiClient);

       

        // Agora cancela o checkout
        $response = $service->cancelarCheckout($checkoutId);

     

        $this->assertIsArray($response);
    }
}
