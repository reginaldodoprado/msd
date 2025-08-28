<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\SubcontasService;
use Ds\AssasIntegration\Tests\TestCase;

class SubcontasServiceTest extends TestCase
{
    protected $apiClient;
    protected $subcontasService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->apiClient = app(ApiClientService::class);
        $this->subcontasService = new SubcontasService($this->apiClient);
    }

    /** @test */
    public function listar_subcontas()
    {
        $filtros = [
            'limit' => 10,
            'offset' => 0
        ];

        $response = $this->subcontasService->listarSubcontas($filtros);

        dump('RESPOSTA LISTAR SUBCONTAS:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function criar_subconta()
    {
        $dados = [
            'name' => 'Subconta Teste',
            'email' => 'subconta.' . time() . '@teste.com', // Email único com timestamp
            'cpfCnpj' => '42469359000152', // CNPJ válido real
            'companyType' => 'MEI', // Tipo da empresa (obrigatório para PJ)
            'mobilePhone' => '11987654321',
            'incomeValue' => 5000.00,
            'address' => 'Rua das Flores',
            'addressNumber' => '123',
            'province' => 'Centro',
            'postalCode' => '01234-567'
        ];

        $response = $this->subcontasService->criarSubconta($dados);

        dump('RESPOSTA CRIAR SUBCONTA:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('email', $response);
        $this->assertEquals('Subconta Teste', $response['name']);

        return $response['id'];
    }



    /**
     * @test
     * @depends criar_subconta
     */
    public function recuperar_subconta($subcontaId)
    {
        $response = $this->subcontasService->recuperarSubconta($subcontaId);

        dump('RESPOSTA RECUPERAR SUBCONTA:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($subcontaId, $response['id']);
        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('email', $response);
        $this->assertArrayHasKey('cpfCnpj', $response);
    }

    /**
     * @test
     * @depends criar_subconta
     */
    public function salvar_ou_atualizar_config_da_conta_escrow_para_subconta($subcontaId)
    {
        $dados = [
            'enabled' => true,
            'retentionPeriod' => 30
        ];

        $response = $this->subcontasService->salvarOuAtualizarConfigDaContaEscrowParaSubconta($subcontaId, $dados);

        dump('RESPOSTA SALVAR/ATUALIZAR CONFIG ESCROW:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('enabled', $response);
        $this->assertTrue($response['enabled']);
    }

    /**
     * @test
     * @depends criar_subconta
     */
    public function recuperar_config_da_conta_escrow_para_subconta($subcontaId)
    {
        $response = $this->subcontasService->recuperarConfigDaContaEscrowParaSubconta($subcontaId);

        dump('RESPOSTA RECUPERAR CONFIG ESCROW:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('enabled', $response);
        $this->assertIsBool($response['enabled']);
    }
}
