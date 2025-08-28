<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\CobrancaDadosResumidosService;
use Ds\AssasIntegration\Tests\TestCase;

class CobrancaDadosResumidosServiceTest extends TestCase
{
    protected $apiClient;
    protected $cobrancaDadosResumidosService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->apiClient = app(ApiClientService::class);
        $this->cobrancaDadosResumidosService = new CobrancaDadosResumidosService($this->apiClient);
    }

    /** @test */
    public function criar_nova_cobranca_resumido()
    {
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de cobrança resumida'
        ];

        $response = $this->cobrancaDadosResumidosService->criarNovaCobrancaResumido($dados);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('customerId', $response);
        $this->assertEquals('cus_000006963164', $response['customerId']);

        return $response['id'];
    }

    /**
     * @test
     * @depends criar_nova_cobranca_resumido
     */
    public function listar_cobrancas_resumido($cobrancaId)
    {
        $filtros = [
            'limit' => 10,
            'offset' => 0,
            'status' => 'PENDING'
        ];

        $response = $this->cobrancaDadosResumidosService->listarCobrancasResumido($filtros);

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function criar_cobranca_com_cartao_de_credito_resumido()
    {
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'CREDIT_CARD',
            'value' => 150.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de cobrança com cartão resumida',
            'authorizeOnly' => true,
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

        $response = $this->cobrancaDadosResumidosService->criarCobrancaComCartaoDeCreditoResumido($dados);

        

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('billingType', $response);
        $this->assertEquals('CREDIT_CARD', $response['billingType']);

        return $response['id'];
    }

    /**
     * @test
     * @depends criar_cobranca_com_cartao_de_credito_resumido
     */
    public function capturar_cobranca_com_pre_autorizacao_resumido($cobrancaId)
    {
        $dados = [
            'value' => 150.00
        ];

        $response = $this->cobrancaDadosResumidosService->capturarCobrancaComPreAutorizacaoResumido($cobrancaId, $dados);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($cobrancaId, $response['id']);
    }

    /**
     * @test
     * @depends criar_nova_cobranca_resumido
     */
    public function recuperar_uma_unica_cobranca_resumido($cobrancaId)
    {
        $response = $this->cobrancaDadosResumidosService->recuperarUmaUnicaCobrancaResumido($cobrancaId);

     

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($cobrancaId, $response['id']);
    }

    /**
     * @test
     * @depends criar_nova_cobranca_resumido
     */
    public function atualizar_uma_cobranca_resumido($cobrancaId)
    {
        $dados = [
            'value' => 180.00,
            'description' => 'Cobrança resumida atualizada'
        ];

        $response = $this->cobrancaDadosResumidosService->atualizarUmaCobrancaResumido($cobrancaId, $dados);

      

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($cobrancaId, $response['id']);
    }

    /**
     * @test
     * @depends criar_nova_cobranca_resumido
     */
    public function excluir_uma_cobranca_resumido($cobrancaId)
    {
        $response = $this->cobrancaDadosResumidosService->excluirUmaCobrancaResumido($cobrancaId);

      

        $this->assertIsArray($response);
        $this->assertArrayHasKey('deleted', $response);
        $this->assertTrue($response['deleted']);

        return $response;
    }

    /**
     * @test
     * @depends excluir_uma_cobranca_resumido
     */
    public function restaurar_uma_cobranca_resumido($response)
    {
        $cobrancaId = $response['id'];
        $responseRestaurar = $this->cobrancaDadosResumidosService->restaurarUmaCobrancaResumido($cobrancaId);

     

        $this->assertIsArray($responseRestaurar);
        $this->assertArrayHasKey('id', $responseRestaurar);
        $this->assertEquals($cobrancaId, $responseRestaurar['id']);
    }

    /**
     * @test
     * @depends criar_nova_cobranca_resumido
     */
    public function confirmar_recebimento_em_dinheiro_resumido($cobrancaId)
    {
        // Primeiro vamos atualizar a cobrança para ter um valor mínimo de R$ 1,00
        $dadosAtualizacao = [
            'paymentDate' => '2025-08-28',
            'value' => 100.00
        ];
        
        $response = $this->cobrancaDadosResumidosService->confirmarRecebimentoEmDinheiroResumido($cobrancaId, $dadosAtualizacao);

       

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($cobrancaId, $response['id']);
        
        return $cobrancaId;
    }

    /**
     * @test
     * @depends confirmar_recebimento_em_dinheiro_resumido
     */
    public function desfazer_confirmacao_de_recebimento_em_dinheiro_resumido($cobrancaId)
    {
        $response = $this->cobrancaDadosResumidosService->desfazerConfirmacaoDeRecebimentoEmDinheiroResumido($cobrancaId);

     

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($cobrancaId, $response['id']);
    }
}
