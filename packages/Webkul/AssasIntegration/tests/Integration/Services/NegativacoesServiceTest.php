<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\NegativacoesService;
use Ds\AssasIntegration\Services\CobrancaService;
use Ds\AssasIntegration\Tests\TestCase;

class NegativacoesServiceTest extends TestCase
{
    protected $apiClient;
    protected $negativacoesService;
    protected $cobrancaService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->apiClient = app(ApiClientService::class);
        $this->negativacoesService = new NegativacoesService($this->apiClient);
        $this->cobrancaService = new CobrancaService($this->apiClient);
    }

    /** @test */
    public function criar_cobranca_boleto_para_teste()
    {
        // Primeiro cria uma cobrança de boleto para testar a negativação
        $dados = [
            'customer' => 'cus_000006963164', // Cliente existente
            'billingType' => 'BOLETO',
            'value' => 150.00,
            'dueDate' => '2025-09-30',
            'description' => 'Boleto para teste de negativação',
            'externalReference' => 'negativacao-teste-001'
        ];

        $response = $this->cobrancaService->criarNovaCobranca($dados);



        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('PENDING', $response['status']);

        return [
            'cobrancaId' => $response['id'],
            'customerId' => $response['customer']
        ];
    }

    /**
     * @test
     * @depends criar_cobranca_boleto_para_teste
     */
    public function simular_negativacao($dadosCobranca)
    {
        $filtros = [
            'payment' => $dadosCobranca['cobrancaId']
        ];

        $response = $this->negativacoesService->simularNegativacao($filtros);
       

        $this->assertIsArray($response);
       
    }

    /**
     * @test
     * @depends criar_cobranca_boleto_para_teste
     */
    public function criar_negativacao($dadosCobranca)
    {
        // Extrai os dados da cobrança criada
        $cobrancaId = $dadosCobranca['cobrancaId'];


        // Dados para criar negativação conforme a documentação da API Asaas
        $dados = [
            'payment' => $cobrancaId, // ID da cobrança criada
            'type' => 'CREDIT_BUREAU', // Tipo de negativação
            'description' => 'Negativação por falta de pagamento - Teste',
            'customerName' => 'teste teste', // Nome do cliente
            'customerCpfCnpj' => '24971563792', // CPF do cliente
            'customerPrimaryPhone' => '11994152001', // Telefone principal
            'customerSecondaryPhone' => '11994152001', // Telefone secundário
            'customerPostalCode' => '07145110', // CEP
            'customerAddress' => 'teste', // Logradouro
            'customerAddressNumber' => '11', // Número
            'customerComplement' => 'Apto 1', // Complemento
            'customerProvince' => 'Guarulhos' // Bairro
        ];

        $response = $this->negativacoesService->criarNegativacao($dados);



        $this->assertIsArray($response);



        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('payment', $response);
        $this->assertEquals($cobrancaId, $response['payment']);

        return $response['id'];
    }


    /** @test */
    public function listar_negativacoes()
    {
        $filtros = [
            'limit' => 10,
            'offset' => 0,

        ];

        $response = $this->negativacoesService->listarNegativacoes($filtros);



        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

    /**
     * @test
     * @depends criar_negativacao
     */
    public function recuperar_negativacao($negativacaoId)
    {
        // Para este teste, vamos usar um ID fictício


        $response = $this->negativacoesService->recuperarNegativacao($negativacaoId);



        $this->assertIsArray($response);



        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($negativacaoId, $response['id']);
    }

    /**
     * @test
     * @depends criar_negativacao
     */
    public function listar_historico_de_eventos($negativacaoId)
    {
        // Para este teste, vamos usar um ID fictício


        $response = $this->negativacoesService->listarHistoricoDeEventos($negativacaoId);



        $this->assertIsArray($response);



        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

    /**
     * @test
     * @depends criar_negativacao
     */
    public function listar_pagamentos_recebidos($negativacaoId)
    {



        $response = $this->negativacoesService->listarPagamentosRecebidos($negativacaoId);



        $this->assertIsArray($response);

        // Se retornar erro, pode ser que não tenha permissão no sandbox
        if (isset($response['errors'])) {
            $this->markTestSkipped('API retornou erro - possível limitação do sandbox');
            return;
        }

        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

    /**
     * @test
   
     */
    public function listar_cobrancas_disponiveis_para_uma_negativacao()
    {



        $response = $this->negativacoesService->listarCobrancasDisponiveisParaUmaNegativacao();



        $this->assertIsArray($response);



        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

    /**
     * @test
     * @depends criar_negativacao
     */
    public function reenviar_documento($negativacaoId)
    {
        // Primeiro verifica se a negativação precisa de reenvio de documentação
        $negativacao = $this->negativacoesService->recuperarNegativacao($negativacaoId);

        // Se não precisar reenviar documentação, pula o teste
        if (!$negativacao['isNecessaryResendDocumentation']) {
            $this->markTestSkipped('Negativação não precisa de reenvio de documentação');
            return;
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'test_');
        file_put_contents($tempFile, 'Conteudo de teste para documento');

        $dados = [
            'documents' => new \CURLFile($tempFile, 'text/plain', 'teste.txt')
        ];

        $response = $this->negativacoesService->reenviarDocumento($negativacaoId, $dados);



        $this->assertIsArray($response);

        // Remove o arquivo temporário
        unlink($tempFile);

        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($negativacaoId, $response['id']);
    }

    /**
     * @test
     * @depends criar_negativacao
     */
    public function cancelar_negativacao($negativacaoId)
    {



        $response = $this->negativacoesService->cancelarNegativacao($negativacaoId);



        $this->assertIsArray($response);



        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('CANCELLED', $response['status']);
    }
}
