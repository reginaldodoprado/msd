<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\ParcelamentoService;
use Ds\AssasIntegration\Tests\TestCase;

class ParcelamentoServiceTest extends TestCase
{
    protected $apiClient;
    protected $parcelamentoService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->apiClient = app(ApiClientService::class);
        $this->parcelamentoService = new ParcelamentoService($this->apiClient);
    }

    /** @test */
    public function criar_parcelamento()
    {
        $dados = [
            'customer' => 'cus_000006963164',
            'installmentCount' => 6,
            'value' => 100.00,
            'totalValue' => 600.00,
            'billingType' => 'BOLETO',
            'dueDate' => '2025-12-31',
            'description' => 'Parcelamento de serviço em 6x'
        ];

        $response = $this->parcelamentoService->criarParcelamento($dados);

        dump('RESPOSTA CRIAR PARCELAMENTO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('installmentCount', $response);
        $this->assertEquals(6, $response['installmentCount']);

        return $response['id'];
    }

    /** @test */
    public function listar_parcelamentos()
    {
        $filtros = [
            'limit' => 10,
            'offset' => 0,
            'status' => 'ACTIVE'
        ];

        $response = $this->parcelamentoService->listarParcelamentos($filtros);

        dump('RESPOSTA LISTAR PARCELAMENTOS:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function criar_parcelamento_com_cartao_de_credito()
    {
        $dados = [
            'customer' => 'cus_000006963164',
            'installmentCount' => 12,
            'value' => 50.00,
            'totalValue' => 600.00,
            'billingType' => 'CREDIT_CARD',
            'dueDate' => '2025-12-31',
            'description' => 'Parcelamento com cartão em 12x',
            'creditCard' => [
                'holderName' => 'João Silva',
                'number' => '4111111111111111',
                'expiryMonth' => '12',
                'expiryYear' => '2025',
                'ccv' => '123'
            ],
            'creditCardHolderInfo' => [
                'name' => 'João Silva',
                'email' => 'joao.silva@teste.com',
                'cpfCnpj' => '12345678909',
                'phone' => '11987654321',
                'postalCode' => '07145100',
                'addressNumber' => '123',
                'addressComplement' => 'Apto 45',
                'mobilePhone' => '11987654321'
            ]
        ];

        $response = $this->parcelamentoService->criarParcelamentoComCartaoDeCredito($dados);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('billingType', $response);
        $this->assertEquals('CREDIT_CARD', $response['billingType']);

        return $response['id'];
    }

    /**
     * @test
     * @depends criar_parcelamento
     */
    public function recuperar_parcelamento($parcelamentoId)
    {
        $response = $this->parcelamentoService->recuperarParcelamento($parcelamentoId);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($parcelamentoId, $response['id']);
    }

   

    /**
     * @test
     * @depends criar_parcelamento
     */
    public function listar_cobrancas_do_parcelamento($parcelamentoId)
    {
        $response = $this->parcelamentoService->listarCobrancasDoParcelamento($parcelamentoId);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

    /**
     * @test
     * @depends criar_parcelamento
     */
    public function gerar_carne_de_parcelamento($parcelamentoId)
    {
        $response = $this->parcelamentoService->gerarCarneDeParcelamento($parcelamentoId);

       

        $this->assertIsArray($response);
       
    }

    /**
     * @test
     * @depends criar_parcelamento
     */
    public function atualizar_split_do_parcelamento($parcelamentoId)
    {
        $dados = [
            'splits' => [
                [
                    'walletId' => 'wal_123456789',
                    'fixedValue' => 50.00,
                    'percentualValue' => 50.0
                ]
            ]
        ];

        $response = $this->parcelamentoService->atualizarSplitDoParcelamento($parcelamentoId, $dados);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($parcelamentoId, $response['id']);
    }


     /**
     * @test
     * @depends criar_parcelamento
     */
    public function remover_parcelamento($parcelamentoId)
    {
        $response = $this->parcelamentoService->removerParcelamento($parcelamentoId);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('deleted', $response);
        $this->assertTrue($response['deleted']);
        
        return $response;
    }
}
