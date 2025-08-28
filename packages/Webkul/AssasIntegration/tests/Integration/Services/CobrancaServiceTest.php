<?php

namespace Ds\AssasIntegration\Tests\Integration;

use Ds\AssasIntegration\Tests\TestCase;
use Ds\AssasIntegration\Services\CobrancaService;
use Ds\AssasIntegration\Services\ApiClientService;

// teste individual do serviço CobrancaService 
// php artisan test tests/Integration/CobrancaServiceTest.php

class CobrancaServiceTest extends TestCase
{
    protected $apiClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = app(ApiClientService::class);
    }

    /** @test */
    public function criar_nova_cobranca()
    {
        $service = new CobrancaService($this->apiClient);

        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de cobrança'
        ];

        $response = $service->criarNovaCobranca($dados);

        dump('RESPOSTA CRIAR NOVA COBRANÇA:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('value', $response);
        $this->assertArrayHasKey('billingType', $response);

        return $response['id'];
    }

    /** @test */
    public function listar_cobrancas()
    {
        $service = new CobrancaService($this->apiClient);

        $filtros = [
            'limit' => 20,
            'offset' => 0
        ];

        $response = $service->listarCobrancas($filtros);

        dump('RESPOSTA LISTAR COBRANÇAS:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('totalCount', $response);
    }

    /** @test */
    public function criar_cobranca_com_cartao_de_credito()
    {
        $service = new CobrancaService($this->apiClient);

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

        $response = $service->criarCobrancaComCartaoDeCredito($dados);

        dump('RESPOSTA CRIAR COBRANÇA COM CARTÃO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('billingType', $response);
        $this->assertEquals('CREDIT_CARD', $response['billingType']);

        return $response['id'];
    }

    /** @test */
    public function capturar_cobranca_com_pre_autorizacao()
    {
        $service = new CobrancaService($this->apiClient);

        // Primeiro cria uma cobrança com pre-autorização
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'CREDIT_CARD',
            'value' => 200.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de pre-autorização',
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

        $cobranca = $service->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        // Agora captura a cobrança
        $dadosCaptura = [
            'value' => 200.00
        ];

        $response = $service->capturarCobrancaComPreAutorizacao($cobrancaId, $dadosCaptura);

        dump('RESPOSTA CAPTURAR COBRANÇA:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
    }

    /** @test */
    public function pagar_cobranca_com_cartao_de_credito()
    {
        $service = new CobrancaService($this->apiClient);

        // Primeiro cria uma cobrança
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'UNDEFINED',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de pagamento com cartão'
        ];

        $cobranca = $service->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        // Agora paga com cartão
        $dadosPagamento = [
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
                'cpfCnpj' => '12345678901',
                'phone' => '11987654321',
                'postalCode' => '07000000',
                'addressNumber' => '123',
                'addressComplement' => 'Apto 45',
                'mobilePhone' => '11987654321'
            ],
          
        ];

        $response = $service->pagarCobrancaComCartaoDeCredito($cobrancaId, $dadosPagamento);

        dump('RESPOSTA PAGAR COBRANÇA COM CARTÃO:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
    }

    /** @test */
    public function recuperar_informacoes_do_pagamento()
    {
        $service = new CobrancaService($this->apiClient);

        // Primeiro cria uma cobrança
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de informações de pagamento'
        ];

        $cobranca = $service->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        $response = $service->recuperarInformacoesDoPagamento($cobrancaId);

        dump('RESPOSTA INFORMAÇÕES DO PAGAMENTO:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function informacoes_sobre_vizualizacao_da_cobranca()
    {
        $service = new CobrancaService($this->apiClient);

        // Primeiro cria uma cobrança
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de visualização'
        ];

        $cobranca = $service->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        $response = $service->informacoesSobreVizualizacaoDaCobranca($cobrancaId);

        dump('RESPOSTA INFORMAÇÕES DE VISUALIZAÇÃO:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function recuperar_uma_unica_cobranca()
    {
        $service = new CobrancaService($this->apiClient);

        // Primeiro cria uma cobrança
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de recuperação'
        ];

        $cobranca = $service->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        $response = $service->recuperarUmaUnicaCobranca($cobrancaId);

        dump('RESPOSTA RECUPERAR COBRANÇA:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($cobrancaId, $response['id']);
    }

    /** @test */
    public function atualizar_uma_cobranca()
    {
        $service = new CobrancaService($this->apiClient);

        // Primeiro cria uma cobrança
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de atualização'
        ];

        $cobranca = $service->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        // Agora atualiza a cobrança
        $dadosAtualizados = [
            'description' => 'Descrição atualizada',
            'value' => 150.00
        ];

        $response = $service->atualizarUmaCobranca($cobrancaId, $dadosAtualizados);

        dump('RESPOSTA ATUALIZAR COBRANÇA:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($cobrancaId, $response['id']);
        $this->assertEquals('Descrição atualizada', $response['description']);
    }

    /** @test */
    public function excluir_uma_cobranca()
    {
        $service = new CobrancaService($this->apiClient);

        // Primeiro cria uma cobrança
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de exclusão'
        ];

        $cobranca = $service->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        $response = $service->excluirUmaCobranca($cobrancaId);

        dump('RESPOSTA EXCLUIR COBRANÇA:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function restaurar_uma_cobranca()
    {
        $service = new CobrancaService($this->apiClient);

        // Primeiro cria uma cobrança
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de restauração'
        ];

        $cobranca = $service->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        // Exclui a cobrança
        $service->excluirUmaCobranca($cobrancaId);

        // Agora restaura
        $response = $service->restaurarUmaCobranca($cobrancaId);

        dump('RESPOSTA RESTAURAR COBRANÇA:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function recuperar_status_de_uma_cobranca()
    {
        $service = new CobrancaService($this->apiClient);

        // Primeiro cria uma cobrança
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de status'
        ];

        $cobranca = $service->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        $response = $service->recuperarStatusDeUmaCobranca($cobrancaId);

        dump('RESPOSTA STATUS DA COBRANÇA:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function obter_linha_digitavel_do_boleto()
    {
        $service = new CobrancaService($this->apiClient);

        // Primeiro cria uma cobrança
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de linha digitável'
        ];

        $cobranca = $service->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        $response = $service->obterLinhaDigitavelDoBoleto($cobrancaId);

        dump('RESPOSTA LINHA DIGITÁVEL:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function obter_qrcode_para_pagamento_pix()
    {
        $service = new CobrancaService($this->apiClient);

        // Primeiro cria uma cobrança
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'PIX',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de QR Code PIX'
        ];

        $cobranca = $service->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        $response = $service->obterQrcodeParaPagamentoPix($cobrancaId);

        dump('RESPOSTA QR CODE PIX:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function confirmar_recebimento_em_dinheiro()
    {
        $service = new CobrancaService($this->apiClient);

        // Primeiro cria uma cobrança
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'UNDEFINED',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de recebimento em dinheiro'
        ];

        $cobranca = $service->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        $response = $service->confirmarRecebimentoEmDinheiro($cobrancaId, [
            'paymentDate' => '2025-08-28',
            'value' => 100.00,
            'notifyCustomer' => false
        ]);

        dump('RESPOSTA CONFIRMAR RECEBIMENTO:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function desfazer_confirmacao_de_recebimento_em_dinheiro()
    {
        $service = new CobrancaService($this->apiClient);

        // Primeiro cria uma cobrança
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'UNDEFINED',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de desfazer recebimento'
        ];

        $cobranca = $service->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        // Confirma recebimento
        $service->confirmarRecebimentoEmDinheiro($cobrancaId, [
            'paymentDate' => '2025-08-28',
            'value' => 100.00,
            'notifyCustomer' => false
        ]);

        // Agora desfaz
        $response = $service->desfazerConfirmacaoDeRecebimentoEmDinheiro($cobrancaId);

        dump('RESPOSTA DESFAZER RECEBIMENTO:', $response);
        
        // Se a API retornar array vazio, a operação pode não ser suportada
   

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals($cobrancaId, $response['id']);
    }

    /** @test */
    public function simular_venda()
    {
        $service = new CobrancaService($this->apiClient);

        $dados = [
            'value' => 100.00,
            'billingTypes' => 'CREDIT_CARD',
            'installmentCount' => 3
        ];

        $response = $service->simularVenda($dados);

        dump('RESPOSTA SIMULAR VENDA:', $response);

        $this->assertIsArray($response);
    }

    /** @test */
    public function recuperar_garantia_da_cobranca_na_conta_escrow()
    {
        $service = new CobrancaService($this->apiClient);

        // Primeiro cria uma cobrança
        $dados = [
            'customer' => 'cus_000006963164',
            'billingType' => 'BOLETO',
            'value' => 100.00,
            'dueDate' => '2025-12-31',
            'description' => 'Teste de garantia escrow'
        ];

        $cobranca = $service->criarNovaCobranca($dados);
        $cobrancaId = $cobranca['id'];

        $response = $service->recuperarGarantiaDaCobrancaNaContaEscrow($cobrancaId);

        dump('RESPOSTA GARANTIA ESCROW:', $response);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('status', $response);
    }

    /** @test */
    public function recuperar_limites_de_cobranca()
    {
        $service = new CobrancaService($this->apiClient);

        $response = $service->recuperarLimitesDeCobranca();

        dump('RESPOSTA LIMITES DE COBRANÇA:', $response);

        $this->assertIsArray($response);
    }
}
