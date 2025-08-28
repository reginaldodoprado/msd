<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\ConsultaSerasaService;
use Tests\TestCase;

class ConsultaSerasaServiceTest extends TestCase
{
    protected $apiClient;
    protected $consultaSerasaService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->apiClient = app(ApiClientService::class);
        $this->consultaSerasaService = new ConsultaSerasaService($this->apiClient);
    }

    /** @test */
    public function consultar_serasa()
    {
        $dados = [
            'cpfCnpj' => '12345678909', // CPF válido que funcionou nos outros testes
            'name' => 'João Silva',
            'birthDate' => '1990-01-01'
        ];

        $response = $this->consultaSerasaService->consultarSerasa($dados);

      

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('cpfCnpj', $response);
        $this->assertEquals('12345678909', $response['cpfCnpj']);

        return $response['id'];
    }

    /** @test */
    public function listar_consultas_serasa()
    {
        $filtros = [
            'limit' => 10,
            'offset' => 0
        ];

        $response = $this->consultaSerasaService->listarConsultasSerasa($filtros);

        dump('RESPOSTA LISTAR CONSULTAS SERASA:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

    /** 
     * @test
     * @depends consultar_serasa
     */
    public function recuperar_consulta_serasa($consultaId)
    {
        // Recupera a consulta usando o ID retornado pelo primeiro teste
        $response = $this->consultaSerasaService->recuperarConsultaSerasa($consultaId);

      

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($consultaId, $response['id']);
    }
}
