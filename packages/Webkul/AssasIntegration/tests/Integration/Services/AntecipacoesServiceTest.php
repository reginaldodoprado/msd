<?php

namespace Ds\AssasIntegration\Tests\Integration\Services;

use Ds\AssasIntegration\Services\ApiClientService;
use Ds\AssasIntegration\Services\AntecipacoesService;
use Ds\AssasIntegration\Services\CobrancaService;
use Ds\AssasIntegration\Tests\TestCase;

class AntecipacoesServiceTest extends TestCase
{
    protected $apiClient;
    protected $antecipacoesService;
    protected $cobrancaService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->apiClient = app(ApiClientService::class);
        $this->antecipacoesService = new AntecipacoesService($this->apiClient);
        $this->cobrancaService = new CobrancaService($this->apiClient);
    }

    /** @test */
    public function simular_antecipacao()
    {
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'CREDIT_CARD',
            'value' => 150.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de cobrança com cartão',
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

        $cobranca = $this->cobrancaService->criarCobrancaComCartaoDeCredito($dados);
        $cobrancaId = $cobranca['id'];

        

        $cobrancaPagamento = $this->cobrancaService->confirmarPagamentoEmSandbox($cobrancaId);

        sleep(10);

        // Simula a antecipação
        $dadosSimulacao = [
            'payment' => $cobrancaId, // ID da cobrança

        ];

        $response = $this->antecipacoesService->simularAntecipacao($dadosSimulacao);

        dump('RESPOSTA SIMULAR ANTECIPAÇÃO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('totalValue', $response);
        $this->assertIsNumeric($response['totalValue']);

        return [
            'cobrancaId' => $cobrancaId,
            'simulacao' => $response
        ];
    }

    /**
     * @test
     * @depends simular_antecipacao
     */
    public function solicitar_antecipacao($dados)
    {
        $cobrancaId = $dados['cobrancaId'];

        $dadosAntecipacao = [
            'payment' => $cobrancaId, // ID da cobrança a ser antecipada

        ];

        $response = $this->antecipacoesService->solicitarAntecipacao($dadosAntecipacao);

        dump('RESPOSTA SOLICITAR ANTECIPAÇÃO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);

        return [
            'antecipacaoId' => $response['id'],
            'cobrancaId' => $cobrancaId
        ];
    }

    /**
     * @test
     * @depends solicitar_antecipacao
     */
    public function recuperar_antecipacao($dados)
    {
        $antecipacaoId = $dados['antecipacaoId'];

        $response = $this->antecipacoesService->recuperarAntecipacao($antecipacaoId);

        dump('RESPOSTA RECUPERAR ANTECIPAÇÃO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($antecipacaoId, $response['id']);
    }

    /** @test */
    public function listar_antecipacoes()
    {
        $filtros = [
            'limit' => 10,
            'offset' => 0
        ];

        $response = $this->antecipacoesService->listarAntecipacoes($filtros);

        dump('RESPOSTA LISTAR ANTECIPAÇÕES:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }

    /** @test */
    public function recuperar_limite_de_antecipacao()
    {
        $response = $this->antecipacoesService->recuperarLimiteDeAntecipacao();

        dump('RESPOSTA RECUPERAR LIMITE DE ANTECIPAÇÃO:', $response);

        $this->assertIsArray($response);
        
    }

    /**
     * @test
     * @depends solicitar_antecipacao
     */
    public function cancelar_antecipacao($dados)
    {
        $antecipacaoId = $dados['antecipacaoId'];

        $response = $this->antecipacoesService->cancelarAntecipacao($antecipacaoId);

        dump('RESPOSTA CANCELAR ANTECIPAÇÃO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('CANCELLED', $response['status']);
    }

    /** @test */
    public function recuperar_status_de_uma_antecipacao_automatica()
    {
        $response = $this->antecipacoesService->recuperarStatusDeUmaAntecipacaoAutomatica();

        dump('RESPOSTA RECUPERAR STATUS ANTECIPAÇÃO AUTOMÁTICA:', $response);

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
    }

    /** @test */
    public function atualizar_status_de_antecipacao_automatica()
    {
        $dados = [
            'creditCardAutomaticEnabled' => true,
           
        ];

        $response = $this->antecipacoesService->atualizarStatusDeUmaAntecipacaoAutomaticamente($dados);

        dump('RESPOSTA ATUALIZAR STATUS ANTECIPAÇÃO AUTOMÁTICA:', $response);
    }
}
