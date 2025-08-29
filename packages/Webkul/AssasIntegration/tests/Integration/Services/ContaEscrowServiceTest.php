<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Ds\AssasIntegration\Tests\TestCase;
use Ds\AssasIntegration\Services\ContaEscrowService;
use Ds\AssasIntegration\Services\CobrancaService;
use Ds\AssasIntegration\Services\ApiClientService;

// teste individual do serviço ContaEscrowService 
// php artisan test tests/Integration/ContaEscrowServiceTest.php

class ContaEscrowServiceTest extends TestCase
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
    public function encerrar_garantia_da_cobranca()
    {
        $service = new ContaEscrowService($this->apiClient);

        // Primeiro cria uma cobrança para testar
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de encerramento de garantia escrow'
        ];

        $cobranca = $this->cobrancaService->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        $response = $service->encerrarGarantiaDaCobranca($cobrancaId);

        dump('RESPOSTA ENCERRAR GARANTIA DA COBRANÇA:', $response);

        $this->assertIsArray($response);
    }
}
