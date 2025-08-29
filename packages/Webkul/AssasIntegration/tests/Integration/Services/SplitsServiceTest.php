<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Ds\AssasIntegration\Tests\TestCase;
use Ds\AssasIntegration\Services\SplitsService;
use Ds\AssasIntegration\Services\CobrancaService;
use Ds\AssasIntegration\Services\ApiClientService;

// teste individual do serviço SplitsService 
// php artisan test tests/Integration/SplitsServiceTest.php

class SplitsServiceTest extends TestCase
{
    protected $apiClient;
    protected $cobrancaService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
        $this->cobrancaService = new CobrancaService($this->apiClient);
    }

    /** @test */
    public function recuperar_split_pago()
    {
        $service = new SplitsService($this->apiClient);

        // Primeiro cria uma cobrança para testar
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de split pago',
            'split' => [
                [
                    'walletId' => '7027cdf6-b564-44a9-bf82-1327e152be8b',
                    'fixedValue' => 30.00
                ]
            ]
        ];

        $cobranca = $this->cobrancaService->criarNovaCobranca($dados);

       
        
        $cobrancaId = $cobranca['id'];

        $response = $service->recuperarSplitPago($cobrancaId);

        $this->assertIsArray($response);
    }

    /** @test */
    public function listar_splits_pago()
    {
        $service = new SplitsService($this->apiClient);

        $filtros = [
            'limit' => 20,
            'offset' => 0
        ];

        $response = $service->listarSplitsPago($filtros);

      

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
    }

   

    /** @test */
    public function listar_splits_recebido()
    {
        $service = new SplitsService($this->apiClient);

        $filtros = [
            'limit' => 20,
            'offset' => 0
        ];

        $response = $service->listarSplitsRecebido($filtros);

      

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
    }
}
