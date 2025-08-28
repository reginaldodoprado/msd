<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\InformacoesFinanceirasService;
use Ds\AssasIntegration\Tests\TestCase;

class InformacoesFinanceirasServiceTest extends TestCase
{
    protected $apiClient;
    protected $informacoesFinanceirasService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->apiClient = app(ApiClientService::class);
        $this->informacoesFinanceirasService = new InformacoesFinanceirasService($this->apiClient);
    }

    /** @test */
    public function recuperar_saldo_da_conta()
    {
        $response = $this->informacoesFinanceirasService->recuperarSaldoDaConta();

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('balance', $response);
        $this->assertIsNumeric($response['balance']);
    }

    /** @test */
    public function recuperar_estatisticas_de_cobrancas()
    {
        $response = $this->informacoesFinanceirasService->recuperarEstatisticasDeCobrancas();

       

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
    }

    /** @test */
    public function recuperar_valores_de_split()
    {
        $response = $this->informacoesFinanceirasService->recuperarValoresDeSplit();

       

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
    }
}
